<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Po;
use App\Models\OTransaksi\PoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class PonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_pon.index');
    }

// ganti 4

    public function getPon(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
 
		$pon = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'Z')->orderBy('NO_BUKTI', 'ASC')->get();
		
		
// ganti 6
		
        return Datatables::of($pon)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="pon/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pon/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="pon/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="pon/show/'. $row->NO_ID .'">
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
        return view('otransaksi_pon.create');
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
                'NO_BUKTI'    => 'required',
                'TGL'         => 'required',
                'KODES'       => 'required'

            ]
        );


// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Z')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PZ'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'PZ'.$tahun.$bulan.'-0001';
        }


        // Insert Header

// ganti 10

        $pon = Po::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],			
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'FLAG'             => 'PZ',
                'GOL'			   => 'Z',	
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'VIA'              => ($request['VIA']==null) ? "" : $request['VIA'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );

//  ganti 11
		$REC	= $request->input('REC');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$KET	= $request->input('KET');
		$QTY	= $request->input('QTY');
		$SATUAN	= $request->input('SATUAN');
		$HARGA	= $request->input('HARGA');		
		$TOTAL	= $request->input('TOTAL');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new PoDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'PZ';
				$detail->GOL	= 'Z';
				$detail->KD_BRG	= $KD_BRG[$key];
				$detail->NA_BRG	= $NA_BRG[$key];
				$detail->KET	= $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);				
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);	
				$detail->save();
			}
		}


        return redirect('/pon')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
       public function show(Po $pon)
    {

        $no_bukti = $pon->NO_BUKTI;
        $ponDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pon,
			'detail'		=> $ponDetail
		];        
		
		return view('ftransaksi_pon.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Po $pon)
    {

        $no_bukti = $pon->NO_BUKTI;
        $ponDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pon,
			'detail'		=> $ponDetail
		];        
		
		return view('otransaksi_pon.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Po $pon )
    {
		
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'KODES'       => 'required'
            ]
        );
		

        // ganti 20
		
        $pon->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],	
				'NAMAS'				=>($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
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
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');
 


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

       // Delete yang NO_ID tidak ada di input
        $query = DB::table('pod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'PZ',	
                        'GOL'        => 'Z',  							
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'NOTES'      => ($NOTES[$i]==null) ? "" : $NOTES[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = PoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'NOTES'      => ($NOTES[$i]==null) ? "" : $NOTES[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'       => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
///////////////////////////////////////////////

 
        for ($i=0;$i<$length;$i++) {
            $upsert = PoDetail::updateOrCreate(
                [
                    'REC'       => $rec[$i],
                    'NO_BUKTI'  => $request->NO_BUKTI
                ],

                [
                    'KD_BRG'        => $KD_BRG[$i],
                    'NA_BRG'        => $NA_BRG[$i],
                    'SATUAN'        => $SATUAN[$i],
                    'HARGA'         => (float) str_replace(',', '', $HARGA[$i]),
					'TOTAL'         => (float) str_replace(',', '', $TOTAL[$i]),
					'QTY'           => (float) str_replace(',', '', $QTY[$i]),
                    'NOTES'         => $NOTES[$i]
					
                ]
            );
        }

//////////////////////////////////////////////////////////////////////////////// 

 //  ganti 21

//  ganti 21

        return redirect('/pon')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Pon $pon)
    {

// ganti 23
        $deletePon = Pon::find($pon->NO_ID);

// ganti 24

        $deletePon->delete();

// ganti 
        return redirect('/pon')->with('status', 'Data berhasil dihapus');
		
		
    }
}
