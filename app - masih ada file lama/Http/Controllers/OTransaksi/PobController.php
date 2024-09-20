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
class PobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_pob.index');
    }

// ganti 4


    public function browse()
    {
        $pob = DB::SELECT("SELECT po.NO_BUKTI, po.KODES, po.NAMAS, po.ALAMAT, po.KOTA, pod.KD_BHN, pod.NA_BHN, pod.QTY,pod.HARGA, pod.KIRIM, pod.SISA from po, pod where po.NO_BUKTI=pod.NO_BUKTI and pod.SISA>0");
        return response()->json($pob);
    }

    public function browse_detail()
    {
        $pob1 = DB::SELECT("SELECT pod.KD_BHN, pod.NA_BHN, pod.SATUAN, pod.QTY,pod.HARGA, pod.KIRIM, pod.SISA from pod   ");
        return response()->json($pob1);
    }
	

    public function getPob(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
 
		$pob = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'B')->orderBy('NO_BUKTI', 'ASC')->get();
		
		
// ganti 6
		
        return Datatables::of($pob)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="pob/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pob/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="pob/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="pob/show/'. $row->NO_ID .'">
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
        return view('otransaksi_pob.create');
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
		$query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'B')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PB'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'PB'.$tahun.$bulan.'-0001';
        }



        // Insert Header

// ganti 10

        $pob = Po::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],			
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],			
                'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'FLAG'             => 'PB',
                'GOL'			   => 'B',	
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
				$detail->FLAG	= 'PB';
				$detail->GOL	= 'B';
				$detail->KD_BHN	= ($KD_BHN[$key]==null) ? "" :  $KD_BHN[$key];
				$detail->NA_BHN	= ($NA_BHN[$key]==null) ? "" :  $NA_BHN[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? "" :  $SATUAN[$key];
				$detail->KET	= ($KET[$key]==null) ? "" :  $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->SISA	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);				
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);	
				$detail->save();
			}
		}

//  ganti 11

        return redirect('/pob')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Po $pob)
    {

// ganti 13

        $no_bukti = $pob->NO_BUKTI;
        $poDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pob,
			'detail'		=> $poDetail
		];        
		
		return view('otransaksi_pob.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Po $pob)
    {

        $no_bukti = $pob->NO_BUKTI;
        $poDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pob,
			'detail'		=> $poDetail
		];        
	
        //CEK  SUDAH POSTED di INDEX dan EDIT	
		if($pob->POSTED==1)
        {
            return redirect('/pob')->with('status', 'Data '.$pob->NO_BUKTI.' sudah terposting');
        }
        else
        {
		return view('otransaksi_pob.edit', $data);
        }
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Po $pob )
    {
		
     	
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'KODES'       => 'required'
            ]
        );
		

        // ganti 20
	    $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
	
		
        $pob->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],	
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],		
                'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],		
                'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],									
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
                        'FLAG'       => 'PB',	
                        'GOL'        => 'B',  							
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'      => ($KET[$i]==null) ? "" : $KET[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'SISA'        => (float) str_replace(',', '', $QTY[$i])
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
						'KET'      => ($KET[$i]==null) ? "" : $KET[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'       => (float) str_replace(',', '', $QTY[$i]),
						'SISA'       => (float) str_replace(',', '', $QTY[$i])
                    ]
                );
            }
        }	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
///////////////////////////////////////////////


        //  ganti 21

////////////////////////////////////////////////////////////////////////////////

//  ganti 21

        return redirect('/pob')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Po $pob)
    {

// ganti 23
        $deletePob = Po::find($pob->NO_ID);

// ganti 24

        $deletePob->delete();

// ganti 
        return redirect('/pob')->with('status', 'Data berhasil dihapus');
		
		
    }
}
