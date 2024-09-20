<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Beli;
use App\Models\OTransaksi\BeliDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class BeliController extends Controller
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
        if ( $request->flagz == 'BL' && $request->golz == 'B' ) {
            $this->judul = "Pembelian Bahan Baku";
        } else if ( $request->flagz == 'RB' && $request->golz == 'B' ) {
            $this->judul = "Retur Pembelian Bahan Baku";
        } else if ( $request->flagz == 'BL' && $request->golz == 'J' ) {
            $this->judul = "Pembelian Bahan Jadi";
        } else if ( $request->flagz == 'RB' && $request->golz == 'J' ) {
            $this->judul = "Retur Pembelian Bahan Jadi";
        } else if ( $request->flagz == 'BL' && $request->golz == 'N' ) {
            $this->judul = "Pembelian Non";
        } else if ( $request->flagz == 'RB' && $request->golz == 'N' ) {
            $this->judul = "Retur Pembelian Non";
        } 
		
        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;


    }
		
    public function index(Request $request)
    {


	    $this->setFlag($request);
        // ganti 3
        return view('otransaksi_beli.index')->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ , 'golz' => $this->GOLZ]);
	
		
    }
	

	public function index_posting(Request $request)
    {
 
        return view('otransaksi_beli.post');
    }

    public function browse(Request $request)
    {
        $golz = $request->GOL;

        $beli = DB::SELECT("SELECT distinct beli.NO_BUKTI , beli.KODES, beli.NAMAS, 
		                  beli.ALAMAT, beli.KOTA, beli.PKP, beli.NO_PO from beli, belid 
                          WHERE beli.NO_BUKTI = beliD.NO_BUKTI AND beli.FLAG='BL' AND beli.GOL ='$golz'");
        return response()->json($beli);
    }
	
	
    public function browseuang(Request $request)
    {
        //	$beli = DB::table('beli')->select('NO_BUKTI', 'TGL', 'KODES','NAMAS', 'ALAMAT','KOTA', 'PERB','PERBB', 'SISA' )->where('PERB', '<>' ,'PERBB')->where('LNS', '<>',1)->where('GOL', 'Y')->orderBy('KODES', 'ASC')->get();
        $filterkodes = '';
	   
		if($request->KODES)
		{
	
			// $filterkodes = " WHERE SISA <> 0 AND KODES='".$request->KODES."' ";
			$filterkodes = " WHERE KODES='".$request->KODES."' ";
		}
		
		$beli = DB::SELECT("SELECT NO_BUKTI, TGL, KODES, 
		            NAMAS, TOTAL, BAYAR, SISA from beli
		            $filterkodes ORDER BY NO_BUKTI ");
 
        return response()->json($beli);
    }
	//SHELVI
	
	
    // ganti 4



    public function getBeli(Request $request)
    {
        // ganti 5

       if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

		$this->setFlag($request);	
        $beli = DB::SELECT("SELECT * from beli  WHERE PER='$periode' and FLAG = '$this->FLAGZ' and GOL = '$this->GOLZ' ORDER BY NO_BUKTI ");
	  
	   
        // ganti 6

        return Datatables::of($beli)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit

                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="beli/edit/?idx=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&judul=' . $this->judul . '&golz=' . $row->GOL . '"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="beli/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '&golz=' . $row->GOL .'" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="beli/cetak/' . $row->NO_ID . '">
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


			
			
			
			
///            ->rawColumns(['action'])
 //           ->make(true);
//    }



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

        $query = DB::table('beli')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $FLAGZ )->where('GOL', $GOLZ )->orderByDesc('NO_BUKTI')->limit(1)->get();

        if( $GOLZ=='B'){

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ . $this->GOLZ . $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $this->GOLZ . $tahun . $bulan . '-0001';
            }

        } elseif($GOLZ=='J') {

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ .  $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ .  $tahun . $bulan . '-0001';
            }

        } elseif($GOLZ=='N') {

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ . $this->GOLZ . $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $this->GOLZ . $tahun . $bulan . '-0001';
            }

        }
        

		
//////////////////////////////////////////////////////////////////////////
       

        // Insert Header

        // ganti 10

        $beli = Beli::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
				'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
				'NO_BELI'            => ($request['NO_BELI'] == null) ? "" : $request['NO_BELI'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'FLAG'             => $FLAGZ,					
                'GOL'              => $GOLZ,					
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'PPN'               => (float) str_replace(',', '', $request['PPN']),
				'PKP'               => (float) str_replace(',', '', $request['PKP']),
				'DPP'               => (float) str_replace(',', '', $request['DPP']),
                'NETT'            => (float) str_replace(',', '', $request['NETT']),
                'SISA'            => (float) str_replace(',', '', $request['NETT']),
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
        $KALI          = $request->input('KALI');
        $SATUAN_PO     = $request->input('SATUAN_PO');
        $QTY_PO        = $request->input('QTY_PO');
        $HARGA      = $request->input('HARGA');		
        $PPNX      = $request->input('PPNX');		
        $DPP      = $request->input('DPP');		
        $TOTAL      = $request->input('TOTAL');
	
        $KET        = $request->input('KET');  

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new BeliDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = $FLAGZ;		
                $detail->GOL         = $GOLZ;		
               
                $detail->KD_BHN      = ($KD_BHN[$key] == null) ? "" :  $KD_BHN[$key];
                $detail->NA_BHN      = ($NA_BHN[$key] == null) ? "" :  $NA_BHN[$key];
                $detail->KD_BRG      = ($KD_BRG[$key] == null) ? "" :  $KD_BRG[$key];
                $detail->NA_BRG      = ($NA_BRG[$key] == null) ? "" :  $NA_BRG[$key];
                $detail->SATUAN      = ($SATUAN[$key] == null) ? "" :  $SATUAN[$key];				
                $detail->QTY         = (float) str_replace(',', '', $QTY[$key]);
                $detail->KALI           = (float) str_replace(',', '', $KALI[$key]);
                $detail->SATUAN_PO   = ($SATUAN_PO[$key] == null) ? "" :  $SATUAN_PO[$key];				
                $detail->QTY_PO      = (float) str_replace(',', '', $QTY_PO[$key]);
                $detail->HARGA       = (float) str_replace(',', '', $HARGA[$key]);
                $detail->PPN       = (float) str_replace(',', '', $PPNX[$key]);
                $detail->DPP       = (float) str_replace(',', '', $DPP[$key]);
                $detail->TOTAL       = (float) str_replace(',', '', $TOTAL[$key]); 
				$detail->KET         = ($KET[$key] == null) ? "" :  $KET[$key];				
                $detail->save();
            }
        }	
		
		


        //  ganti 11
       $variablell = DB::select('call beliins(?)', array($no_bukti));
		$no_buktix = $no_bukti;
		
		$beli = Beli::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE beli,  belid
                            SET  belid.ID = beli.NO_ID  WHERE  beli.NO_BUKTI =  belid.NO_BUKTI 
							AND  beli.NO_BUKTI='$no_buktix';");

		
					 
        return redirect('/beli/edit/?idx=' . $beli->NO_ID . '&tipx=edit&flagz=' . $FLAGZ . '&judul=' . $this->judul . '&golz=' . $this->GOLZ . '');

					
    }


    // ganti 15

   
   public function edit( Request $request , Beli $beli)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/beli')
			       ->with('status', 'Maaf Periode sudah ditutup!')
                   ->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ]);
        }
		
		$this->setFlag($request);
		
        $tipx = $request->tipx;

		$idx = $request->idx;
			

		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli
		                 where PER ='$per' and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
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
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli 
		                 where PER ='$per' 
						 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'    
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli     
		             where PER ='$per' 
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'  and NO_BUKTI < 
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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli    
		             where PER ='$per'  
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' and NO_BUKTI > 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli
						where PER ='$per'
						and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'   
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
			$beli = Beli::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$beli = new Beli;
                $beli->TGL = Carbon::now();
				
				
		 }

        $no_bukti = $beli->NO_BUKTI;
        $beliDetail = DB::table('belid')->where('NO_BUKTI', $no_bukti)->orderBy('REC')->get();
		
		$data = [
            'header'        => $beli,
			'detail'        => $beliDetail

        ];
 
         
         return view('otransaksi_beli.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'flagz' =>$this->FLAGZ, 'judul', $this->judul, 'golz' =>$this->GOLZ ]);
      
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 18

    public function update(Request $request, Beli $beli)
    {

        $this->validate(
            $request,
            [

                // ganti 19

 //               'NO_PO'       => 'required',
                'TGL'      => 'required',
                'KODES'       => 'required'


            ]
        );

        // ganti 20
      $variablell = DB::select('call belidel(?)', array($beli['NO_BUKTI']));

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        // ganti 20

        $beli->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
                'NO_BELI'            => ($request['NO_BELI'] == null) ? "" : $request['NO_BELI'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'PPN'              => (float) str_replace(',', '', $request['PPN']),
				'PKP'              => (float) str_replace(',', '', $request['PKP']),
                'NETT'             => (float) str_replace(',', '', $request['NETT']),
		   	    'SISA'             => (float) str_replace(',', '', $request['NETT']), 
                'FLAG'             => $FLAGZ,					
                'GOL'              => $GOLZ,					
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
            ]
        );

		$no_buktix = $beli->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');

        $KD_BHN     = $request->input('KD_BHN');
        $NA_BHN     = $request->input('NA_BHN');
        $KD_BRG     = $request->input('KD_BRG');
        $NA_BRG     = $request->input('NA_BRG');
        $SATUAN     = $request->input('SATUAN');		
        $QTY        = $request->input('QTY');
        $KALI          = $request->input('KALI');
        $SATUAN_PO  = $request->input('SATUAN_PO');
        $QTY_PO     = $request->input('QTY_PO');
        $HARGA      = $request->input('HARGA');
        $PPNX      = $request->input('PPNX');
        $DPP      = $request->input('DPP');
        $TOTAL      = $request->input('TOTAL');
        $KET = $request->input('KET');			

        $query = DB::table('belid')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = BeliDetail::create(
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
                        'KALI'          => (float) str_replace(',', '', $KALI[$i]),
                        'SATUAN_PO'  => ($SATUAN_PO[$i] == null) ? "" :  $SATUAN_PO[$i],				
                        'QTY_PO'     => (float) str_replace(',', '', $QTY_PO[$i]),
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'PPN'      => (float) str_replace(',', '', $PPNX[$i]),
                        'DPP'      => (float) str_replace(',', '', $DPP[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],	
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = BeliDetail::updateOrCreate(
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
                        'KALI'          => (float) str_replace(',', '', $KALI[$i]),
                        'SATUAN_PO'  => ($SATUAN_PO[$i] == null) ? "" :  $SATUAN_PO[$i],				
                        'QTY_PO'     => (float) str_replace(',', '', $QTY_PO[$i]),
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'PPN'      => (float) str_replace(',', '', $PPNX[$i]),
                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],
                        'DPP'      => (float) str_replace(',', '', $DPP[$i]),	
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,						
                    ]
                );
            }
        }


        //  ganti 21
        $variablell = DB::select('call beliins(?)', array($beli['NO_BUKTI']));

 		$beli = Beli::where('NO_BUKTI', $no_buktix )->first();

        $no_bukti = $beli->NO_BUKTI;

        DB::SELECT("UPDATE beli,  belid
                    SET  belid.ID =  beli.NO_ID  WHERE  beli.NO_BUKTI =  belid.NO_BUKTI 
                    AND  beli.NO_BUKTI='$no_bukti';");
					 
        return redirect('/beli/edit/?idx=' . $beli->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&judul=' . $this->judul . '');	
		
	   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 22

    public function destroy(Request $request, Beli $beli)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('beli')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ]);
        }
		
		
       $variablell = DB::select('call belidel(?)', array($beli['NO_BUKTI']));//


        // ganti 23
		
        $deleteBeli = Beli::find($beli->NO_ID);

        // ganti 24

        $deleteBeli->delete();

        // ganti 

       return redirect('/beli?flagz='.$FLAGZ.'&golz='.$GOLZ)->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ ])->with('statusHapus', 'Data '.$beli->NO_BUKTI.' berhasil dihapus');


    }
    
    
    public function cetak(Beli $beli)
    {
        $no_beli = $beli->NO_BUKTI;

        $file     = 'belic';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("SELECT beli.NO_BUKTI, beli.TGL, beli.KODES, beli.NAMAS, beli.TOTAL_QTY, beli.NOTES, beli.ALAMAT, 
                                    beli.KOTA, belid.KD_BRG, belid.NA_BRG, belid.SATUAN, belid.QTY, 
                                    belid.HARGA, belid.TOTAL, belid.KET, beli.PPN, beli.NETT, beli.NO_PO
                            FROM beli, belid 
                            WHERE beli.NO_BUKTI='$no_beli' AND beli.NO_BUKTI = belid.NO_BUKTI 
                            ;
		");

        
        $data = [];

        foreach ($query as $key => $value) {
            array_push($data, array(
                'NO_BUKTI' => $query[$key]->NO_BUKTI,
                'TGL'      => $query[$key]->TGL,
                'KODES'    => $query[$key]->KODES,
                'NAMAS'    => $query[$key]->NAMAS,
                'ALAMAT'    => $query[$key]->ALAMAT,
                'KOTA'    => $query[$key]->KOTA,
                'KG'       => $query[$key]->KG,
                'HARGA'    => $query[$key]->HARGA,
                'TOTAL'    => $query[$key]->TOTAL,
                'BAYAR'    => $query[$key]->BAYAR,
                'NOTES'    => $query[$key]->NOTES,
                'KD_BRG'    => $query[$key]->KD_BRG,
                'NA_BRG'    => $query[$key]->NA_BRG,
                'SATUAN'    => $query[$key]->SATUAN,
                'QTY'    => $query[$key]->QTY,
                'PPN'    => $query[$key]->PPN,
                'NETT'    => $query[$key]->NETT,
                'KET'    => $query[$key]->KET,
                'NO_PO'    => $query[$key]->NO_PO
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
