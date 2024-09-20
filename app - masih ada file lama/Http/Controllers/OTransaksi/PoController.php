<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Po;
use App\Models\OTransaksi\PoDetail;
use App\Models\Master\Sup;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class PoController extends Controller
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
        if ( $request->flagz == 'PO' && $request->golz == 'B' ) {
            $this->judul = "PO Bahan Baku";
        } else if ( $request->flagz == 'PO' && $request->golz == 'J' ) {
            $this->judul = "PO Bahan Jadi";
        }

        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;

    }
		
    public function index(Request $request)
    {


	    $this->setFlag($request);
        // ganti 3
        return view('otransaksi_po.index')->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ ]);
	
		
    }
	
		public function browse(Request $request)
    {
        $golz = $request->GOL;

        $po = DB::SELECT("SELECT distinct PO.NO_BUKTI , PO.KODES, PO.NAMAS, 
		                  PO.ALAMAT, PO.KOTA from po, pod 
                          WHERE PO.NO_BUKTI = POD.NO_BUKTI AND PO.GOL ='$golz' AND POD.SISA > 0	");
        return response()->json($po);
    }

    public function browseuang(Request $request)
    {
		$po = DB::SELECT("SELECT NO_BUKTI,TGL,  KODES, NAMAS, TOTAL,  BAYAR, 
                        (TOTAL-BAYAR) AS SISA, ALAMAT, KOTA from po
		WHERE LNS <> 1 ORDER BY NO_BUKTI; ");

        return response()->json($po);
    }


	public function index_posting(Request $request)
    {
 
        return view('otransaksi_po.post');
    }
	  
	//SHELVI
	
	public function browse_detail(Request $request)
    {
		$filterbukti = '';
		if($request->NO_PO)
		{
	
			$filterbukti = " WHERE a.NO_BUKTI='".$request->NO_PO."' AND a.KD_BHN = b.KD_BHN ";
		}
		$pod = DB::SELECT("SELECT a.REC, a.KD_BHN, a.NA_BHN, a.SATUAN , a.QTY, a.HARGA, a.KIRIM, a.SISA, 
                                b.SATUAN AS SATUAN_PO, a.QTY AS QTY_PO, '1' AS X
                            from pod a, bhn b 
                            $filterbukti ORDER BY NO_BUKTI ");
	

		return response()->json($pod);
	}


    public function browse_detail2(Request $request)
    {
		$filterbukti = '';
		if($request->NO_PO)
		{
	
			$filterbukti = " WHERE NO_BUKTI='".$request->NO_PO."' AND a.KD_BRG = b.KD_BRG ";
		}
		$pod = DB::SELECT("SELECT a.REC, a.KD_BRG, a.NA_BRG, a.SATUAN , a.QTY, a.HARGA, a.KIRIM, a.SISA, 
                                b.SATUAN AS SATUAN_PO, a.QTY AS QTY_PO, '1' AS X 
                            from pod a, brg b
                            $filterbukti ORDER BY NO_BUKTI ");
	

		return response()->json($pod);
	}
    // ganti 4



    public function getPo(Request $request)
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

        $po = DB::SELECT("SELECT * from po  WHERE PER='$periode' and FLAG ='$this->FLAGZ' AND GOL ='$this->GOLZ' ORDER BY NO_BUKTI ");
	  
	   
        // ganti 6

        return Datatables::of($po)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit

                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="po/edit/?idx=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&judul=' . $this->judul . '&golz=' . $row->GOL . '"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="po/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '/?golz=' . $row->GOL . '" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="cetak/' . $row->NO_ID . '">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" ' . $btnDelete . '>
   
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
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resbelinse
     */
    public function store(Request $request)
    {


        $this->validate(
            $request,
            // GANTI 9

            [
 //               'NO_PO'       => 'required',
                'TGL'      => 'required',
                'KODES'       => 'required'

            ]
        );

        //////     nomer otomatis
		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);

        $query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'PO')->where('GOL', $this->GOLZ )->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PO' . $this->GOLZ . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'PO' . $this->GOLZ . $tahun . $bulan . '-0001';
        }		

        $po = Po::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'JTEMPO'              => date('Y-m-d', strtotime($request['JTEMPO'])),
                'PER'              => $periode,
				'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'FLAG'             => 'PO',						
                'GOL'              => $GOLZ,
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
				'PKP'              => (float) str_replace(',', '', $request['PKP']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'created_by'       => Auth::user()->username,
            ]
        );


		$REC        = $request->input('REC');
		$KD_BHN     = $request->input('KD_BHN');
        $NA_BHN     = $request->input('NA_BHN');
		$KD_BRG     = $request->input('KD_BRG');
        $NA_BRG     = $request->input('NA_BRG');
        $SATUAN     = $request->input('SATUAN');
        $QTY        = $request->input('QTY');
        $HARGA      = $request->input('HARGA');		
        $TOTAL      = $request->input('TOTAL');		
        $KET        = $request->input('KET');  

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new PoDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = $FLAGZ;		
                $detail->GOL 	     = $GOLZ;               
                $detail->KD_BHN      = ($KD_BHN[$key] == null) ? "" :  $KD_BHN[$key];
                $detail->NA_BHN      = ($NA_BHN[$key] == null) ? "" :  $NA_BHN[$key];          
                $detail->KD_BRG      = ($KD_BRG[$key] == null) ? "" :  $KD_BRG[$key];
                $detail->NA_BRG      = ($NA_BRG[$key] == null) ? "" :  $NA_BRG[$key];
                $detail->SATUAN      = ($SATUAN[$key] == null) ? "" :  $SATUAN[$key];				
                $detail->QTY         = (float) str_replace(',', '', $QTY[$key]);
                $detail->HARGA       = (float) str_replace(',', '', $HARGA[$key]);
                $detail->TOTAL       = (float) str_replace(',', '', $TOTAL[$key]); 
                $detail->SISA       = (float) str_replace(',', '', $QTY[$key]); 

				$detail->KET         = ($KET[$key] == null) ? "" :  $KET[$key];				
                $detail->save();
            }
        }	
		
		$no_buktix = $no_bukti;
		
		$po = Po::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE po,  pod
                            SET  pod.ID =  po.NO_ID  WHERE  po.NO_BUKTI =  pod.NO_BUKTI 
							AND  po.NO_BUKTI='$no_buktix';");

		
					 
        return redirect('/po/edit/?idx=' . $po->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&golz=' . $this->GOLZ . '&judul=' . $this->judul . '');
		
    }

   public function edit( Request $request , Po $po)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        // $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        // if ($cekperid[0]->POSTED==1)
        // {
        //     return redirect('/po')
		// 	       ->with('status', 'Maaf Periode sudah ditutup!')
        //            ->with(['judul' => $judul, 'flagz' => $FLAGZ]);
        // }
		
		$this->setFlag($request);
		
        $tipx = $request->tipx;

		$idx = $request->idx;
			

		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from po
		                 where PER ='$per' and FLAG ='$this->FLAGZ'
                         and GOL ='$this->GOLZ' 
						 and NO_BUKTI = '$buktix'						 
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
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from po
		                 where PER ='$per' 
						 and FLAG ='$this->FLAGZ' 
                         and GOL ='$this->GOLZ'    
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from po     
		             where PER ='$per' 
					 and FLAG ='$this->FLAGZ' 
                     and GOL ='$this->GOLZ'  and NO_BUKTI < 
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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from po    
		             where PER ='$per'  
					 and FLAG ='$this->FLAGZ' 
                     and GOL ='$this->GOLZ' and NO_BUKTI > 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from po
						where PER ='$per'
						and FLAG ='$this->FLAGZ'
                        and GOL ='$this->GOLZ'    
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
			$po = Po::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$po = new Po;
                $po->TGL = Carbon::now();
				
				
		 }

        $no_bukti = $po->NO_BUKTI;
        $poDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->orderBy('REC')->get();
		
		$data = [
            'header'        => $po,
			'detail'        => $poDetail

        ];
 
 		$sup = DB::SELECT("SELECT KODES, CONCAT(NAMAS,'-',KOTA) AS NAMAS FROM SUP 
		                 ORDER BY NAMAS ASC" );
		
         
         return view('otransaksi_po.edit', $data)->with(['sup' => $sup])
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ, 'judul'=> $this->judul ]);
			 

    }

  /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 18

    public function update(Request $request, Po $po)
    {

        $this->validate(
            $request,
            [

                'TGL'      => 'required',
                'KODES'       => 'required'
            ]
        );

		$this->setFlag($request);
        $GOLZ = $this->GOLZ;
        $FLAGZ = $this->FLAGZ;
        $judul = $this->judul;
		
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];


        $po->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'JTEMPO'              => date('Y-m-d', strtotime($request['JTEMPO'])),
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'PKP'              => (float) str_replace(',', '', $request['PKP']),
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
                'FLAG'             => 'PO',						
                'GOL'              => $GOLZ,
            ]
        );

		$no_buktix = $po->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');

        $KD_BHN = $request->input('KD_BHN');
        $NA_BHN = $request->input('NA_BHN');
        $KD_BRG = $request->input('KD_BRG');
        $NA_BRG = $request->input('NA_BRG');
        $SATUAN = $request->input('SATUAN');		
        $QTY    = $request->input('QTY');
        $HARGA    = $request->input('HARGA');
        $TOTAL    = $request->input('TOTAL');
        $KET = $request->input('KET');			

        $query = DB::table('pod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'SISA'      => (float) str_replace(',', '', $QTY[$i]),

                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],	
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = PoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],

                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'SISA'        => (float) str_replace(',', '', $QTY[$i]),
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'PER'        => $periode,
                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],							
                    ]
                );
            }
        }

 		$po = Po::where('NO_BUKTI', $no_buktix )->first();

        $no_bukti = $po->NO_BUKTI;

        DB::SELECT("UPDATE po,  pod
                    SET  pod.ID =  po.NO_ID  WHERE  po.NO_BUKTI =  pod.NO_BUKTI 
                    AND  po.NO_BUKTI='$no_bukti';");
					 
        return redirect('/po/edit/?idx=' . $po->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&golz=' . $this->GOLZ . '&judul=' . $this->judul . '');	
		
	   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 22

    public function destroy(Request $request, Po $po)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('po')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ]);
        }
		
        $deletePo = Po::find($po->NO_ID);

        $deletePo->delete();

       return redirect('/po?flagz='.$FLAGZ.'&golz='.$GOLZ)->with(['judul' => $judul, 'golz' => $GOLZ , 'flagz' => $FLAGZ ])->with('statusHapus', 'Data '.$po->NO_BUKTI.' berhasil dihapus');


    }
    
    public function cetak(Po $po)
    {
        $no_po = $po->NO_BUKTI;

        $file     = 'poc';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("
			SELECT NO_BUKTI,  TGL, KODES, NAMAS, TOTAL_QTY, NOTES, TOTAL, ALAMAT, KOTA
			FROM po 
			WHERE po.NO_BUKTI='$no_po' 
			ORDER BY NO_BUKTI;
		");

        $xno_po1       = $query[0]->NO_BUKTI;
        $xtgl1         = $query[0]->TGL;
        $xkodes1       = $query[0]->KODES;
        $xnamas1       = $query[0]->NAMAS;
        $xtotal1       = $query[0]->TOTAL_QTY;
        $xnotes1       = $query[0]->NOTES;
        $xharga1       = $query[0]->TOTAL;
        $xalamat1      = $query[0]->ALAMAT;
        $xkota1        = $query[0]->KOTA;
        
        $PHPJasperXML->arrayParameter = array("HARGA1" => (float) $xharga1, "TOTAL1" => (float) $xtotal1, "NO_PO1" => (string) $xno_po1,
                                     "TGL1" => (string) $xtgl1,  "KODES1" => (string) $xkodes1,  "NAMAS1" => (string) $xnamas1, "NOTES1" => (string) $xnotes1, "ALAMAT1" => (string) $xalamat1, "KOTA1" => (string) $xkota1 );
        $PHPJasperXML->arraysqltable = array();


        $query2 = DB::SELECT("
			SELECT NO_BUKTI, TGL, KODES, NAMAS, if(ALAMAT='','NOT-FOUND.png',ALAMAT) as ALAMAT, NO_PO,  IF ( FLAG='BL' , 'A','B' ) AS FLAG, AJU, BL, EMKL, KD_BRG, NA_BRG, KG, RPHARGA AS HARGA, RPTOTAL AS TOTAL, 0 AS BAYAR,  NOTES
			FROM beli 
			WHERE beli.NO_PO='$no_po'  UNION ALL 
			SELECT NO_BUKTI, TGL, KODES, NAMAS, if(ALAMAT='','NOT-FOUND.png',ALAMAT) as ALAMAT,  NO_PO,  'C' AS FLAG, '' AS AJU, '' AS BL, '' AS EMKL,  '' AS KD_BRG, '' AS NA_BRG, 0 AS KG, 
			0 AS HARGA, 0 AS TOTAL, BAYAR, NOTES
			FROM hut 
			WHERE hut.NO_PO='$no_po' 
			ORDER BY TGL, FLAG, NO_BUKTI;
		");

        $data = [];

        foreach ($query2 as $key => $value) {
            array_push($data, array(
                'NO_BUKTI' => $query2[$key]->NO_BUKTI,
                'TGL'      => $query2[$key]->TGL,
                'KODES'    => $query2[$key]->KODES,
                'NAMAS'    => $query2[$key]->NAMAS,
                'ALAMAT'    => $query2[$key]->ALAMAT,
                'AJU'    => $query2[$key]->AJU,
                'BL'       => $query2[$key]->BL,
                'EMKL'    => $query2[$key]->EMKL,
                'KG'       => $query2[$key]->KG,
                'HARGA'    => $query2[$key]->HARGA,
                'TOTAL'    => $query2[$key]->TOTAL,
                'BAYAR'    => $query2[$key]->BAYAR,
                'NOTES'    => $query2[$key]->NOTES
            ));
        }
		
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
       
    }
	
	
	
	 public function posting(Request $request)
    {
      

    }
	
	
	
	
	
	
	
}
