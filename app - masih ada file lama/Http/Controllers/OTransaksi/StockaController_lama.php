<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Stocka;
use App\Models\OTransaksi\StockaDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class StockaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_stocka.index');
    }

// ganti 4

    public function getStocka(Request $request)
    {
// ganti 5
	
		 if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


         $stocka = DB::table('stocka')->select('*')->where('PER', $periode)->where('FLAG', 'KB')->orderBy('NO_BUKTI', 'ASC')->get();
	 	 
// ganti 6
		
        return Datatables::of($stocka)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="stocka/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="stocka/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="stocka/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="stocka/show/'. $row->NO_ID .'">
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
        return view('otransaksi_stocka.create');
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
                'TGL'      => 'required'

            ]
        );
//////     nomer otomatis

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('stocka')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'KB')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'KB'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'KB'.$tahun.$bulan.'-0001';
        }



        // Insert Header

// ganti 10

        $stocka = Stocka::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
				'FLAG'             => 'KB',	
                'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],				
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTYC	= $request->input('QTYC');
		$QTYR	= $request->input('QTYR');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new StockaDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'KB';
				$detail->KD_BHN	= ($KD_BHN[$key]==null) ? "" :  $KD_BHN[$key];
				$detail->NA_BHN	= ($NA_BHN[$key]==null) ? "" :  $NA_BHN[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? "" :  $SATUAN[$key];
				$detail->QTYC	= (float) str_replace(',', '', $QTYC[$key]);
				$detail->QTYR	= (float) str_replace(',', '', $QTYR[$key]);
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->KET	= $KET[$key];				
				$detail->save();
			}
		}

//  ganti 11

	$variablell = DB::select('call stockains(?)',array($no_bukti));
		
        return redirect('/stocka')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
     public function show(Stocka $stocka)
    {

        $no_bukti = $stocka->NO_BUKTI;
        $stockaDetail = DB::table('stockad')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $stocka,
			'detail'		=> $stockaDetail
		];        
		
		return view('otransaksi_stocka.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Stocka $stocka)
    {

        $no_bukti = $stocka->NO_BUKTI;
        $stockaDetail = DB::table('stockad')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $stocka,
			'detail'		=> $stockaDetail
		];        
		
		return view('otransaksi_stocka.edit', $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Stocka $stocka )
    {
	
      $this->validate($request,
            [




// ganti 19
                 'TGL'       => 'required'
            ]
        );
		



// ganti 20
		$variablell = DB::select('call stockadel(?)',array($stocka['NO_BUKTI']));
		
        $stocka->update(
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
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTYC	= $request->input('QTYC');
		$QTYR	= $request->input('QTYR');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

       // Delete yang NO_ID tidak ada di input
        $query = DB::table('stockad')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = StockaDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'KB',								
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'QTYC'      => (float) str_replace(',', '', $QTYC[$i]),
                        'QTYR'      => (float) str_replace(',', '', $QTYR[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = StockaDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
						'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'QTYC'      => (float) str_replace(',', '', $QTYC[$i]),
                        'QTYR'      => (float) str_replace(',', '', $QTYR[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
///////////////////////////////////////////////
 
  
////////////////////////////////////////////////////////////////

//  ganti 21
		$variablell = DB::select('call stockains(?)',array($stocka['NO_BUKTI']));
		
//  ganti 21

		
        return redirect('/stocka')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Stocka $stocka)
    {

		$variablell = DB::select('call stockadel(?)',array($stocka['NO_BUKTI']));
		
// ganti 23
        $deleteStocka = Stocka::find($stocka->NO_ID);

// ganti 24

        $deleteStocka->delete();

// ganti 
        return redirect('/stocka')->with('status', 'Data berhasil dihapus');
		
		
    }
}
