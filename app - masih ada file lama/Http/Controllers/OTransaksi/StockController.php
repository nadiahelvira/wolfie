<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Stock;
use App\Models\OTransaksi\StockDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resbelinse
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_stock.index');
    }
	
		public function browse()
    {
        $Stock = DB::SELECT("SELECT  NO_BUKTI, TGL from stock  ");
        return response()->json($Stock);
    }

	public function index_posting(Request $request)
    {
 
        return view('otransaksi_stock.post');
    }
	
	

	//SHELVI
	
	public function browse_Stockd(Request $request)
    {
		$filterbukti = '';
		if($request->NO_BUKTI)
		{
	
			$filterbukti = " WHERE NO_BUKTI='".$request->NO_BUKTI."' ";
		}
		$Stockd = DB::SELECT("SELECT REC, KD_BRG, NA_BRG, 
		SATUAN, QTY from stockd $filterbukti ORDER BY NO_BUKTI ");
	
		
	
		return response()->json($Stockd);
	}
    // ganti 4

    public function getStock(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

	
	   
       $stock = DB::SELECT("SELECT NO_ID, NO_BUKTI, TGL, TOTAL_QTY, 
	   NOTES, 
	   USRNM, POSTED from stock  where PER = '$periode' 
	   ORDER BY NO_BUKTI ");
	   
        // ganti 6

        return Datatables::of($stock)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ( Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit
                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="stock/edit/?idx=' . $row->NO_ID . '&tipx=edit"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="stock/delete/' . $row->NO_ID .'" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jsStockc/' . $row->NO_ID . '">
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


		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
 
        $query = DB::table('stock')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'KS')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'KS' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'KS' . $tahun . $bulan . '-0001';
        }

//////////////////////////////////////////////////////////////////////////
       

        // Insert Header

        // ganti 10

        $Stock = Stock::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'FLAG'             => 'KS',				
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'created_by'       => Auth::user()->username,
            ]
        );


		$REC        = $request->input('REC');
		$KD_BRG     = $request->input('KD_BRG');
        $NA_BRG     = $request->input('NA_BRG');
        $SATUAN     = $request->input('SATUAN');
        $QTY        = $request->input('QTY');
	 

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new StockDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = 'KS';
            
                $detail->KD_BRG      = ($KD_BRG[$key] == null) ? "" :  $KD_BRG[$key];
                $detail->NA_BRG      = ($NA_BRG[$key] == null) ? "" :  $NA_BRG[$key];
                $detail->SATUAN      = ($SATUAN[$key] == null) ? "" :  $SATUAN[$key];				

                $detail->QTY         = (float) str_replace(',', '', $QTY[$key]);
			
                $detail->save();
            }
        }


        //  ganti 11
        $variablell = DB::select('call stockins(?)', array($no_bukti));
        $no_buktix = $no_bukti;
		
		$stock = Stock::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE stock, stockd
                            SET stockd.ID = stock.NO_ID  WHERE stock.NO_BUKTI = stockd.NO_BUKTI 
							AND stock.NO_BUKTI='$no_buktix';");

		
					 
					 
        return redirect('/stock/edit/?idx=' . $stock->NO_ID . '&tipx=edit');

		

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 12

   
   public function edit( Request $request , Stock $stock )
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/stock')
			       ->with('status', 'Maaf Periode sudah ditutup!');
				   
        }
		
		
        $tipx = $request->tipx;

		$idx = $request->idx;
			

		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from stock
		                 where PER ='$per' 
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
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from stock 
		                 where PER ='$per' 
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from stock     
		             where PER ='$per'  
					 and NO_BUKTI < '$buktix' ORDER BY NO_BUKTI DESC LIMIT 1" );
			

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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from stock    
		             where PER ='$per'  
					 and NO_BUKTI > '$buktix' ORDER BY NO_BUKTI ASC LIMIT 1" );
					 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from stock
						where PER ='$per'    
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
			$stock = Stock::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$stock = new Stock;
                $stock->TGL = Carbon::now();
      
				
		 }

        $no_bukti = $stock->NO_BUKTI;

    	$stockDetail = DB::table('stockd')->where('NO_BUKTI', $no_bukti)->get();	
		
		$data = [
            'header'        => $stock,
            'detail'        => $stockDetail,
        ];
 
         
         return view('otransaksi_stock.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx ]);
		 
         
    }

    // ganti 18

    public function update(Request $request, Stock $stock)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'TGL'      => 'required'


            ]
        );

        // ganti 20
        $variablell = DB::select('call stockdel(?)', array($stock['NO_BUKTI']));

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        // ganti 20

        $stock->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
            ]
        );

		$no_buktix = $stock->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');
        $KD_BRG = $request->input('KD_BRG');
        $NA_BRG = $request->input('NA_BRG');
        $SATUAN = $request->input('SATUAN');		
        $QTY    = $request->input('QTY');
     //   $BB_BP  = $request->input('BB_BP');		

        $query = DB::table('stockd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = StockDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => 'KS',					
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = StockDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],
                      
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
                        
                   ]
                );
            }
        }


        //  ganti 21
       $variablell = DB::select('call stockins(?)', array($stock['NO_BUKTI']));

 		$stock = Stock::where('NO_BUKTI', $no_buktix )->first();
					 
					 
        return redirect('/stock/edit/?idx=' . $stock->NO_ID . '&tipx=edit');	
		
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 22

    public function destroy(Stock $stock)
    {

		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED AS POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/stock')->with('status', 'Maaf Periode sudah ditutup!');
        }
		
        $variablell = DB::select('call stockdel(?)', array($stock['NO_BUKTI']));//

        $deleteStock = Stock::find($stock->NO_ID);

        $deleteStock->delete();

        return redirect('/stock')->with('status', 'Data berhasil dihapus');
    }
    
    public function jsStockc(Stock $stock)
    {
        $no_stock = $stock->NO_BUKTI;
		
        $file     = 'stockc';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("
            SELECT Stock.NO_BUKTI, stock.TGL, stockd.KD_BRG, stockd.NA_BRG, 
			stockd.SATUAN, stockd.QTY  
			from stock, stockd 
			WHERE stock.NO_BUKTI=stockd.NO_BUKTI and stock.NO_BUKTI='$no_stock'
			ORDER BY stock.NO_BUKTI;
		");

        $data = [];

        $rec=1;
        $kdbrg = '';
        $nabrg = '';
        foreach ($query as $key => $value) {

            array_push($data, array(
                'NO_BUKTI' => $no_Stock,
                // 'TGL'      => date("d/m/Y", strtotime($Stock->TGL)),
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
