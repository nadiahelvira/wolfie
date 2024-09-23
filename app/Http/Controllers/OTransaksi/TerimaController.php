<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Terima;
use App\Models\OTransaksi\TerimaDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class TerimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resbelinse
     */
	 
    var $judul = '';
    var $FLAGZ = '';
    var $GOLZ = '';
	
    function setFlag(Request $request)
    {
        if ( $request->flagz == 'HP' && $request->golz == 'J' ) {
            $this->judul = "Hasil Produksi";
        } else if ( $request->flagz == '' && $request->golz == '' ) {
            $this->judul = "";
        } 
		
        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;


    }
       	
    public function index(Request $request)
    {

	    $this->setFlag($request);
        // ganti 3
        return view('otransaksi_terima.index')->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ ]);
	
	
    }
	


	public function index_posting(Request $request)
    {
 
        return view('otransaksi_terima.post');
    }

    public function browseuang(Request $request)
    {

		$filterkodec = '';
	   
        $CBG = Auth::user()->CBG;
		
		if($request->KODEC)
		{
	
			// $filterkodec = " WHERE SISA <> 0 AND KODEC='".$request->KODEC."' ";
			$filterkodec = " WHERE KODEC='".$request->KODEC."' ";
		}
		
		$terima = DB::SELECT("SELECT NO_BUKTI, TGL, KODEC, 
                        NAMAC, NETT AS TOTAL, BAYAR, SISA from terima
                        $filterkodec AND CBG = '$CBG' ORDER BY NO_BUKTI ");
 
        return response()->json($terima);
    }
	
    // ganti 4

    public function browsePakai(Request $request)
    {
        $flag = $request->FLAG;

        $CBG = Auth::user()->CBG;
		
		$pakai = DB::SELECT("SELECT KODEC, NAMAC, NO_BUKTI, NO_ORDER, NO_SO, NO_FO, KD_PRS, NA_PRS, NO_PRS, KD_BRG, NA_BRG, KD_BHN, NA_BHN, QTY_OUT, SATUAN, NOTES 
        from pakai 
        WHERE FLAG='".$flag."' AND CBG = '$CBG' AND KD_PRS in (SELECT KD_PRS from fod2 WHERE AKHIR=1);");
		return response()->json($pakai);
	}

    public function browsePakaid(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
		$pakaid = DB::SELECT("SELECT KD_BHN, NA_BHN, SATUAN, sum(QTY) as QTY, KET 
        from pakaid 
        WHERE NO_BUKTI in (SELECT NO_BUKTI from pakai WHERE NO_ORDER='".$request->no_orderk."') 
        GROUP BY KD_BHN
        ORDER BY KD_BHN;");
		return response()->json($pakaid);
	}

    public function getTerima(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
   
        $CBG = Auth::user()->CBG;
		
        $terima = DB::SELECT("SELECT * from terima  where PER = '$periode' and FLAG ='$this->FLAGZ' 
                AND GOL ='$this->GOLZ' AND CBG = '$CBG' ORDER BY NO_BUKTI ");
	   
        // ganti 6

        return Datatables::of($terima)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ( Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit
                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="terima/edit/?idx=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&judul=' . $this->judul . '&golz=' . $row->GOL . '"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="terima/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '&golz=' . $row->GOL . '" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jsterimac/' . $row->NO_ID . '">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger"  ' . $btnDelete . '>
   
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                } else {
                    $btnPrivilege = '';
                }

                $actionBtn =
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-hasbelipup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            

                            ' . $btnPrivilege . '
                        </div>
                    </div>
                    ';

                return $actionBtn;
            })
			
	
			->addColumn('cek', function ($row) {
                return
                    '
                    <input type="checkbox" name="cek[]" class="form-control cek" ' . (($row->POSTED == 1) ? "checked" : "") . '  value="' . $row->NO_ID . '" ' . (($row->POSTED == 2) ? "disabled" : "") . '></input> 				
                    ';
            
            })			
			
            ->rawColumns(['action','cek'])
            ->make(true);
    }

	
			
			



//////////////////////////////////////////////////////////////////////////////////


	
			

    public function store(Request $request)
    {


        $this->validate(
            $request,
            // GANTI 9

            [
 //               'NO_PO'       => 'required',
                'TGL'      => 'required'

            ]
        );

        //////     nomer otomatis

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);

        $query = DB::table('terima')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $FLAGZ )->where('CBG', $CBG )
                ->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'HP'. $CBG . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'HP'. $CBG . $tahun . $bulan . '-0001';
        }
		
//////////////////////////////////////////////////////////////////////////
       

        // Insert Header

        // ganti 10

        $terima = Terima::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'FLAG'             => $FLAGZ,						
                'GOL'              => $GOLZ,
                'CBG'              => $CBG,

                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
                'NO_PAKAI'         => ($request['NO_PAKAI']==null) ? "" : $request['NO_PAKAI'],
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'QTY'              => (float) str_replace(',', '', $request['QTYH']),
                // 'QTY'              => (float) str_replace(',', '', $request['QTYH']) : 0,
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KD_PRS'           => ($request['KD_PRSH']==null) ? "" : $request['KD_PRSH'],			
                'NA_PRS'           => ($request['NA_PRSH']==null) ? "" : $request['NA_PRSH'],
				'NO_PRS'           => ($request['NO_PRS']==null) ? "" : $request['NO_PRS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'FIN'              => ($request['FIN']==null) ? "0" : $request['FIN'],
	   
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'created_by'       => Auth::user()->username,
            ]
        );


		$REC    = $request->input('REC');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');		 

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new TerimaDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = $FLAGZ;		
                $detail->GOL 	     = $GOLZ; 

                $detail->KD_BHN	     = $KD_BHN[$key];
				$detail->NA_BHN	     = $NA_BHN[$key];	
				$detail->SATUAN	     = ($SATUAN[$key]==null) ? '' : $SATUAN[$key];	
				$detail->QTY	     = (float) str_replace(',', '', $QTY[$key]);
				$detail->KET	     = ($KET[$key]==null) ? '' : $KET[$key];				
 		
                $detail->save();
            }
        }

        if($request['FIN'])
        {
            DB::SELECT("UPDATE orderk set FIN=".$request['FIN']." WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        else
        {
            DB::SELECT("UPDATE orderk set FIN=0 WHERE NO_BUKTI='".$request['NO_OK']."'");
        }


        //  ganti 11
        $variablell = DB::select('call terimains(?)', array($no_bukti));

        $no_buktix = $no_bukti;
		
		$terima = Terima::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE terima, terimad
                            SET terimad.ID = terima.NO_ID  WHERE terima.NO_BUKTI = terimad.NO_BUKTI 
							AND terima.NO_BUKTI='$no_buktix';");
					 
					 
        return redirect('/terima/edit/?idx=' . $terima->NO_ID . '&tipx=edit&flagz=' . $FLAGZ . '&golz=' . $this->GOLZ . '&judul=' . $this->judul . '');

    }



   public function edit( Request $request , Terima $terima)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/terima')
			       ->with('status', 'Maaf Periode sudah ditutup!')
                   ->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ]);
        }
		

		$this->setFlag($request);
		
        $tipx = $request->tipx;

		$idx = $request->idx;
		
        $CBG = Auth::user()->CBG;
		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from terima
		                 where PER ='$per' and FLAG ='$this->FLAGZ'
                         and GOL ='$this->GOLZ' 
						 and NO_BUKTI = '$buktix'
                         AND CBG = '$CBG'						 
		                 ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
			
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
		
					
		}
		
		if ($tipx=='top') {
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from terima
		                 where PER ='$per' and FLAG ='$this->FLAGZ'
                         and GOL ='$this->GOLZ' AND CBG = '$CBG'    
		                 ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
		
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
		
					
		}
		
		
		if ($tipx=='prev' ) {
			
    	   $buktix = $request->buktix;
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from terima     
		                where PER ='$per' and FLAG ='$this->FLAGZ'
                        and GOL ='$this->GOLZ' AND CBG = '$CBG' and NO_BUKTI < 
					    '$buktix' ORDER BY NO_BUKTI DESC LIMIT 1" );
			

			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = $idx; 
			  }
			  
		}
		
		
		if ($tipx=='next' ) {
			
				
      	   $buktix = $request->buktix;
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from terima    
		                where PER ='$per' and FLAG ='$this->FLAGZ'
                        and GOL ='$this->GOLZ' AND CBG = '$CBG' 
                        and NO_BUKTI > 
					    '$buktix' ORDER BY NO_BUKTI ASC LIMIT 1" );
					 
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = $idx; 
			  }
			  
			
		}

		if ($tipx=='bottom') {
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from terima
						where PER ='$per' and FLAG ='$this->FLAGZ'
                        and GOL ='$this->GOLZ' AND CBG = '$CBG' 
		                ORDER BY NO_BUKTI DESC  LIMIT 1" );
					 
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
			  
			
		}

        
		if ( $tipx=='undo' || $tipx=='search' )
	    {
        
			$tipx ='edit';
			
		   }
		
		

       	if ( $idx != 0 ) 
		{
			$terima = Terima::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$terima = new Terima;
                $terima->TGL = Carbon::now();
      
				
		 }

        $no_bukti = $terima->NO_BUKTI;
	    $terimaDetail = DB::table('terimad')->where('NO_BUKTI', $no_bukti)->orderBy('REC')->get();	
		
		$data = [
            'header'        => $terima,
            'detail'        => $terimaDetail,
			
        ];
 
         
      
         return view('otransaksi_terima.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ, 'judul'=> $this->judul ]);
      	 
 
 
    }

    // ganti 18

    public function update(Request $request, Terima $terima)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'TGL'      => 'required'


            ]
        );

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
		
        // ganti 20
        $variablell = DB::select('call terimadel(?)', array($terima['NO_BUKTI']));

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        // ganti 20

        $terima->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),

                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
                'NO_PAKAI'         => ($request['NO_PAKAI']==null) ? "" : $request['NO_PAKAI'],
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                // 'QTY_BHN'          => $terima->FLAG=="HW" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                // 'QTY'              => $terima->FLAG=="HP" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'QTY'              => (float) str_replace(',', '', $request['QTYH']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KD_PRS'           => ($request['KD_PRSH']==null) ? "" : $request['KD_PRSH'],			
                'NA_PRS'           => ($request['NA_PRSH']==null) ? "" : $request['NA_PRSH'],
				'NO_PRS'           => ($request['NO_PRS']==null) ? "" : $request['NO_PRS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],

				'FIN'              => ($request['FIN']==null) ? "0" : $request['FIN'],

				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
                'FLAG'             => $FLAGZ,						
                'GOL'              => $GOLZ,
                'CBG'              => $CBG,
            ]
        );


		$no_buktix = $terima->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');
        $KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');	

        $query = DB::table('terimad')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = TerimaDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = TerimaDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],
                      
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'PER'        => $periode,
                    ]
                );
            }
        }

        if($request['FIN'])
        {
            DB::SELECT("UPDATE orderk set FIN=".$request['FIN']." WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        else
        {
            DB::SELECT("UPDATE orderk set FIN=0 WHERE NO_BUKTI='".$request['NO_OK']."'");
        }

        //  ganti 21
        $variablell = DB::select('call terimains(?)', array($terima['NO_BUKTI']));

 		$terima = Terima::where('NO_BUKTI', $no_buktix )->first();

        $no_bukti = $terima->NO_BUKTI;

         DB::SELECT("UPDATE terima,  terimad
                     SET  terimad.ID =  terima.NO_ID  WHERE  terima.NO_BUKTI =  terimad.NO_BUKTI 
                     AND  terima.NO_BUKTI='$no_bukti';");
					 
        return redirect('/terima/edit/?idx=' . $terima->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&judul=' . $this->judul . '&golz=' . $this->GOLZ . '');	
	
	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 22

    public function destroy(Request $request, Terima $terima)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED AS POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('terima')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ]);
        }
		
       $variablell = DB::select('call terimadel(?)', array($terima['NO_BUKTI']));//


        // ganti 23
		
        $deleteTerima = Terima::find($terima->NO_ID);

        // ganti 24

        $deleteTerima->delete();

        // ganti 
       return redirect('/terima?flagz='.$FLAGZ.'&golz='.$GOLZ)->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ ])->with('statusHapus', 'Data '.$terima->NO_BUKTI.' berhasil dihapus');


    }
    
    public function jsterimac(Terima $terima)
    {
        $no_terima = $terima->NO_BUKTI;
		
        $file     = 'terimac';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("
            SELECT terima.NO_BUKTI, terima.TGL, terimad.KD_BRG, terimad.NA_BRG,  terima.TGL, terima.USRNM, terima.PPN, terima.NETT,
			terimad.SATUAN, terimad.QTY,  
			from terima, terimad 
			WHERE terima.NO_BUKTI=terimad.NO_BUKTI and terima.NO_BUKTI='$no_terima'
			ORDER BY terima.NO_BUKTI;
		");

        $data = [];

        $rec=1;
        $kdbrg = '';
        $nabrg = '';
        foreach ($query as $key => $value) {

            array_push($data, array(
                'NO_BUKTI' => $no_terima,
                // 'TGL'      => date("d/m/Y", strtotime($terima->TGL)),
                'TGL'      => $query[$key]->TGL,               
                'REC'      => $rec,
                'KD_BRG'   => $query[$key]->KD_BRG,
                'NA_BRG'   => $query[$key]->NA_BRG,
                'QTY'      => $query[$key]->QTY,				
				'SATUAN'    => $query[$key]->SATUAN,
		    	'USRNM'    => $query[$key]->USRNM,



            ));
            $rec++;
        }
	
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
	
	
	
	 
	
	
	
	
	
	
}
