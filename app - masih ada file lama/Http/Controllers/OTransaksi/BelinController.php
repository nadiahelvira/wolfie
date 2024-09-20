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

// ganti 2
class BelinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_belin.index');
    }

// ganti 4

    public function getBelin(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
  
           $belin = DB::table('beli')->select('*')->where('PER', $periode)->where('FLAG', 'BL')->where('GOL', 'Z')->orderBy('NO_BUKTI', 'ASC')->get();
		
		
// ganti 6
		
        return Datatables::of($belin)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="belin/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="belin/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="belin/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="belin/show/'. $row->NO_ID .'">
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
        return view('otransaksi_belin.create');
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
                'NO_PO'       => 'required',
                'TGL'      => 'required',
                'KODES'       => 'required',
                'KD_BRG'       => 'required',				


            ]
        );


        // Insert Header

// ganti 10

        // Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('beli')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		$query = substr($query[0]->NO_BUKTI, -4);
		$query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
		$no_bukti = 'BN'.$tahun.$bulan.'-'.$query;



        // Insert Header

// ganti 10

        $belin = Beli::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'NO_PO'            => $request['NO_PO'],
                'KODES'            => $request['KODES'],			
                'NAMAS'            => $request['NAMAS'],
				'FLAG'             => 'BL',
                'GOL'			   => 'Z',	
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'           => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
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
				$detail	= new BeliDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'BL';
				$detail->GOL	= 'Z';
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];
				$detail->KET	= $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);				
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);	
				$detail->save();
			}
		}

//  ganti 11
		$variablell = DB::select('call beliins(?)',array($no_bukti));	
        return redirect('/belin')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
     public function show(Beli $belin)
    {

        $no_bukti = $belin->NO_BUKTI;
        $belinDetail = DB::table('belid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $belin,
			'detail'		=> $belinDetail
		];        
		
		return view('ftransaksi_belin.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Beli $belin)
    {

        $no_bukti = $belin->NO_BUKTI;
        $belinDetail = DB::table('belid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $belin,
			'detail'		=> $belinDetail
		];        
		
		return view('ftransaksi_belin.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Beli $belin )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'NO_PO'       => 'required',
                'KODES'       => 'required'
            ]
        );
		
// ganti 20
		$variablell = DB::select('call belidel(?)',array($belin['NO_BUKTI']));
		
		
        	
        $belin->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'NO_PO'            => $request['NO_PO'],
                'KODES'            => $request['KODES'],	
                'NAMAS'            => $request['NAMAS'],	
                'ALAMAT'           => $request['ALAMAT'],	
                'KOTA'             => $request['KOTA'],									
                'NOTES'            => $request['NOTES'],				
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
        $query = DB::table('belid')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = BeliDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'BL',	
                        'GOL'        => 'Z',  							
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
                $update = BeliDetail::updateOrCreate(
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
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'      	 => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
///////////////////////////////////////////////  


  for ($i=0;$i<$length;$i++) {
            $upsert = BeliDetail::updateOrCreate(
                [
                    'REC'       => $rec[$i],
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



//  ganti 21
		$variablell = DB::select('call beliins(?)',array($belin['NO_BUKTI']));
		
		
        return redirect('/belin')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Beli $belin)
    {
		$variablell = DB::select('call belidel(?)',array($belin['NO_BUKTI']));
		
		
// ganti 23
        $deleteBelin = Beli::find($belin->NO_ID);

// ganti 24

        $deleteBelin->delete();

// ganti 
        return redirect('/belin')->with('status', 'Data berhasil dihapus');
		
		
    }
}
