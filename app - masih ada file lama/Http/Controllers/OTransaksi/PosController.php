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
class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_pos.index');
    }

// ganti 4

    public function getPos(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
 
		$pos = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'S')->orderBy('NO_BUKTI', 'ASC')->get();
		
		
// ganti 6
		
        return Datatables::of($pos)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="pos/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pos/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="pos/delete/'. $row->NO_ID .'">
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
        return view('otransaksi_pos.create');
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
		$query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'S')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PS'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'PS'.$tahun.$bulan.'-0001';
        }


        // Insert Header

// ganti 10

        $pos = Po::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],			
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'FLAG'             => 'PS',
                'GOL'			   => 'S',	
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'VIA'              => ($request['VIA']==null) ? "" : $request['VIA'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'           => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );

//  ganti 11
		$REC	= $request->input('REC');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$KET	= $request->input('KET');
		$QTY	= $request->input('QTY');
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
				$detail->FLAG	= 'PS';
				$detail->GOL	= 'S';
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];
				$detail->KET	= $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);				
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);	
				$detail->save();
			}
		}


        return redirect('/pos')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
       public function show(Pos $pos)
    {

        $no_bukti = $pos->NO_BUKTI;
        $posDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pos,
			'detail'		=> $posDetail
		];        
		
		return view('otransaksi_pos.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Po $pos)
    {

        $no_bukti = $pos->NO_BUKTI;
        $posDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pos,
			'detail'		=> $posDetail
		];        
		
		return view('otransaksi_pos.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Po $pos )
    {
		
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'KODES'       => 'required'
            ]
        );
		

        // ganti 20
		
        $pos->update(
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
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
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
                        'FLAG'       => 'PS',	
                        'GOL'        => 'S',  							
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
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
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
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
                    'REC'       => $REC[$i],
                    'NO_BUKTI'  => $request->NO_BUKTI
                ],

                [
                    'KD_BHN'        => $KD_BHN[$i],
                    'NA_BHN'        => $NA_BHN[$i],
                    'SATUAN'        => $SATUAN[$i],
                    'HARGA'         => (float) str_replace(',', '', $HARGA[$i]),
					'TOTAL'         => (float) str_replace(',', '', $TOTAL[$i]),
					'QTY'           => (float) str_replace(',', '', $QTY[$i]),
                    'KET'           => $KET[$i]
					
                ]
            );
        }

////////////////////////////////////////////////////////////////////////////////

        //  ganti 21

//  ganti 21

        return redirect('/pos')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Pos $pos)
    {

// ganti 23
        $deletePos = Pos::find($pos->NO_ID);

// ganti 24

        $deletePos->delete();

// ganti 
        return redirect('/pos')->with('status', 'Data berhasil dihapus');
		
		
    }
}
