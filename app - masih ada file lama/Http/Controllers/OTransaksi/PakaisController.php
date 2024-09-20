<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Pakai;
use App\Models\OTransaksi\PakaiDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class PakaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_pakais.index');
    }

// ganti 4

    public function getPakais(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


         $pakai = DB::table('pakai')->select('*')->where('PER', $periode)->where('GOL', 'S')->orderBy('NO_BUKTI', 'ASC')->get();

		
// ganti 6
		
        return Datatables::of($pakai)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="pakais/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pakais/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="pakais/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="pakais/show/'. $row->NO_ID .'">
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
        return view('otransaksi_pakais.create');
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
                'TGL'      => 'required',

            ]
        );

		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('pakai')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'S')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		$query = substr($query[0]->NO_BUKTI, -4);
		$query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
		$no_bukti = 'PS'.$tahun.$bulan.'-'.$query;



        // Insert Header

// ganti 10

        $pakais = Pakai::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
				'FLAG'             => 'PK',
                'GOL'			   => 'S',	
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
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new PakaiDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'PK';
				$detail->GOL	= 'S';
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];
				$detail->SATUAN	= $SATUAN[$key];
				$detail->KET	= $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);	
				$detail->save();
			}
		}
//  ganti 11
		
        return redirect('/pakais')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Pakai $pakais)
    {

        $no_bukti = $pakais->NO_BUKTI;
        $pakaisDetail = DB::table('pakaid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pakai,
			'detail'		=> $pakaisDetail
		];        
		
		return view('ftransaksi_pakais.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Pakai $pakais)
    {

        $no_bukti = $pakais->NO_BUKTI;
        $pakaisDetail = DB::table('pakaid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pakai,
			'detail'		=> $pakaisDetail
		];        
		
		return view('ftransaksi_pakais.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Pakai $pakais )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required'
            ]
        );
		
// ganti 20
		$sql = "CALL pakaidel('". $request['NO_BUKTI'] ."') ";
		$variablell = DB::query($sql);
		
        $pakai->update(
            [

                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],	
				'NAMAS'			   => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'KET'              => ($request['KET']==null) ? "" : $request['KET'],
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
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
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$QTY	= $request->input('QTY');
		$NOTES	= $request->input('NOTES');
       
	   
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

       // Delete yang NO_ID tidak ada di input
        $query = DB::table('pakaid')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PakaiDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'PY',	
                        'GOL'        => 'Y',  							
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'      	 => ($KET[$i]==null) ? "" : $KET[$i],
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
						'KET'      	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
///////////////////////////////////////////////
	   
        for ($i=0;$i<$length;$i++) {
            $upsert = PakaiDetail::updateOrCreate(
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
                    'NOTES'         => $NOTES[$i]
					
                ]
            );
        }






////////////////////////////////////////////////////////////////


//  ganti 21
		$sql = "CALL pakaiins('". $request['NO_BUKTI'] ."') ";
		$variablell = DB::query($sql);
		
        return redirect('/pakais')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Pakai $pakais)
    {

		$sql = "CALL pakaidel('". $request['NO_BUKTI'] ."') ";
		$variablell = DB::query($sql);
		
// ganti 23
        $deletePakais = Pakai::find($pakais->NO_ID);

// ganti 24

        $deletePakais->delete();

// ganti 
        return redirect('/pakais')->with('status', 'Data berhasil dihapus');
		
		
    }
}
