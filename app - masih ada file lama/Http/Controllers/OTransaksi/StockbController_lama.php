<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Stockb;
use App\Models\OTransaksi\StockbDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class StockbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_stockb.index');
    }

// ganti 4

    public function getStockb(Request $request)
    {
// ganti 5
	
		 if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


         $stockb = DB::table('stockb')->select('*')->where('PER', $periode)->orderBy('NO_BUKTI', 'ASC')->get();
	 	 
// ganti 6
		
        return Datatables::of($stockb)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="stockb/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="stockb/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="stockb/delete/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                    } 
                    else
                    {
                        $btnPrivilege = '';
                    }

                    $actionBtn = 
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="stockb/show/'. $row->NO_ID .'">
                            <i class="fas fa-eye"></i>
                                Lihat
                            </a>

                            '.$btnPrivilege.'
                        </div>
                    </div>
                    ';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
 // ganti 8
        return view('otransaksi_stockb.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $this->validate($request,
// GANTI 9

        [
                'NO_BUKTI'       => 'required',
                'TGL'      		=> 'required',
                'KD_BRG'      => 'required'

            ]
        );

//////     nomer otomatis

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('stockb')->select('NO_BUKTI')->where('PER', $periode)->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'KZ'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'KZ'.$tahun.$bulan.'-0001';
        }



        // Insert Header

// ganti 10

        $stockb = Stockb::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
				'FLAG'             => 'KZ',	
                'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],				
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
        $NO_ID  = $request->input('NO_ID');
		
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTYC	= $request->input('QTYC');
		$QTYR	= $request->input('QTYR');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new StockbDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'KZ';
				$detail->KD_BRG	= ($KD_BRG[$key]==null) ? "" :  $KD_BRG[$key];
				$detail->NA_BRG	= ($NA_BRG[$key]==null) ? "" :  $NA_BRG[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? "" :  $SATUAN[$key];
				$detail->QTYC	= (float) str_replace(',', '', $QTYC[$key]);
				$detail->QTYR	= (float) str_replace(',', '', $QTYR[$key]);
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->KET	= $KET[$key];				
				$detail->save();
			}
		}

//  ganti 11

	$variablell = DB::select('call stockbins(?)',array($no_bukti));
		
        return redirect('/stockb')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Stockb $stockb)
    {

        $no_bukti = $stockb->NO_BUKTI;
        $stockbDetail = DB::table('stockbd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $stockb,
			'detail'		=> $stockbDetail
		];        
		
		return view('otransaksi_stockb.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Stockb $stockb)
    {

        $no_bukti = $stockb->NO_BUKTI;
        $stockbDetail = DB::table('stockbd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $stockb,
			'detail'		=> $stockbDetail
		];        
		
		return view('otransaksi_stockb.edit', $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Stockb $stockb )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required'
            ]
        );
		
// ganti 20
		$variablell = DB::select('call stockbdel(?)',array($stockb['NO_BUKTI']));
		

		$stockb->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],				
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );


        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');		
		
        $REC	= $request->input('REC');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTYC	= $request->input('QTYC');
		$QTYR	= $request->input('QTYR');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');
 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

       // Delete yang NO_ID tidak ada di input
        $query = DB::table('stockbd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = StockbDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'KY',								
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'QTYC'      => (float) str_replace(',', '', $QTYC[$i]),
                        'QTYR'      => (float) str_replace(',', '', $QTYR[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = StockbDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
						'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'QTYC'      => (float) str_replace(',', '', $QTYC[$i]),
                        'QTYR'      => (float) str_replace(',', '', $QTYR[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
/////////////////////////////////////////////////////////////////////

 
      
//////////////////////////////////////////////////////////////////

		
//  ganti 21

//		$variablell = DB::select('call stockbins(?)',array($stockb['NO_BUKTI']));
		
        return redirect('/stockb')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Stockb $stockb)
    {

		$variablell = DB::select('call stockbdel(?)',array($stockb['NO_BUKTI']));
		
		
// ganti 23
        $deleteStockb = Stockb::find($stockb->NO_ID);

// ganti 24

        $deleteStockb->delete();

// ganti 
        return redirect('/stockb')->with('status', 'Data berhasil dihapus');
		
		
    }
}
