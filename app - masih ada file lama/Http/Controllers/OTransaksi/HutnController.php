<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Hut;
use App\Models\OTransaksi\HutDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class HutnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_hutn.index');
    }

// ganti 4

    public function getHutn(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
           $hutn = DB::table('hut')->select('*')->where('PER', $periode)->where('GOL', 'Z')->orderBy('NO_BUKTI', 'ASC')->get();
		
		
// ganti 6
		
        return Datatables::of($hutn)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="hutn/edit/'. $row->NO_ID .'" ' ;
 //                       $btnDelete = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="hutn/delete/'. $row->NO_ID .'" ' ;
                        $btnDelete = '';
 						 												 
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" '.$btnEdit.'>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="hutn/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" '.$btnDelete.'>
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
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="hutn/show/'. $row->NO_ID .'">
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
        return view('otransaksi_hutn.create');
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
                'BACNO'       => 'required',
                'KODES'       => 'required'

            ]
        );

//////     nomer otomatis

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('hut')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Z')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		
        // Check apakah No Bukti terakhir NULL
        if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'HZ'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'HZ'.$tahun.$bulan.'-0001';
        }

        $typebayar = substr($request['BNAMA'],0,1);
		
		if ( $typebayar != 'K' )
        {
			
			$bulan	= session()->get('periode')['bulan'];
			$tahun	= substr(session()->get('periode')['tahun'],-2);
			$query2 = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBK')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
			if ($query2 != '[]')
			{
				$query2 = substr($query2[0]->NO_BUKTI, -4);
				$query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
				$no_bukti2 = 'BBK'.$tahun.$bulan.'-'.$query2;
			} else {
				$no_bukti2 = 'BBK'.$tahun.$bulan.'-0001';
			}
		
		}
		else
		{
			$bulan    = session()->get('periode')['bulan'];
            $tahun    = substr(session()->get('periode')['tahun'], -2);
            $query2 = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKK')->orderByDesc('NO_BUKTI')->limit(1)->get();

            if ($query2 != '[]') {
                $query2 = substr($query2[0]->NO_BUKTI, -4);
                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti2 = 'BKK' . $tahun . $bulan . '-' . $query2;
            } else {
                $no_bukti2 = 'BKK' . $tahun . $bulan . '-0001';
            }




        }
		
        // Insert Header

// ganti 10

        $hutn = Hut::create(
            [
                'NO_BUKTI'      	=> $no_bukti,
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'NO_PO'            => ($request['NO_PO']==null) ? "" : $request['NO_PO'],	
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],			
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],			
                'BNAMA'            => ($request['BNAMA']==null) ? "" : $request['BNAMA'],
                'NO_BANK'          => $no_bukti2,				
				'FLAG'             => 'HY',
                'GOL'			   => 'Y',	
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'BAYAR'        => (float) str_replace(',', '', $request['TBAYAR']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );


		$REC	    = $request->input('REC');
		$NO_FAKTUR	= $request->input('NO_FAKTUR');
		$TOTAL	= $request->input('TOTAL');
		$BAYAR	= $request->input('BAYAR');		
		$SISA	= $request->input('SISA');
		$KET = $request->input('KET');
		
		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new HutDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'HY';
				$detail->GOL	= 'Y';
				$detail->NO_FAKTUR = ($NO_FAKTUR[$key]==null) ? "" :  $NO_FAKTUR[$key];
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);
				$detail->BAYAR	= (float) str_replace(',', '', $BAYAR[$key]);				
				$detail->SISA	= (float) str_replace(',', '', $SISA[$key]);	
				$detail->KET    = ($KET[$key]==null) ? "" :  $KET[$key];
				$detail->save();
			}
		}
		

//  ganti 11
		$variablell = DB::select('call hutins(?,?)',array($no_bukti,$no_bukti2));
        return redirect('/hutn')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Hut $hutn)
    {

        $no_bukti = $hutn->NO_BUKTI;
        $hutnDetail = DB::table('hutd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $hut,
			'detail'		=> $hutnDetail
		];        
		
		return view('otransaksi_hutn.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Hut $hutn)
    {

        $no_bukti = $hut->NO_BUKTI;
        $hutnDetail = DB::table('hutd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $hutn,
			'detail'		=> $hutnDetail
		];        
		
		
		return view('otransaksi_hut.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Hut $hutn )
    {
		
        $this->validate($request,
        [
		
// ganti 19
                'NO_PO'       => 'required',
                'TGL'      => 'required',
                'BACNO'       => 'required',
                'KODES'       => 'required'
            ]
        );
		
// ganti 20
		$variablell = DB::select('call hutndel(?,?)',array($beli['NO_BUKTI'].'0'));		

        // ganti 20
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
	
	
        $hutn->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_PO'            => ($request['NO_PO']==null) ? "" : $request['NO_PO'],
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],	
				'NAMAS'				=>($request['NAMAS']==null) ? "" : $request['NAMAS'],
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],	
				'BNAMA'				=>($request['BNAMA']==null) ? "" : $request['BNAMA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'BAYAR'            => (float) str_replace(',', '', $request['TBAYAR']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()	
            ]
        );


        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');
		
        $REC	= $request->input('REC');
		$NO_FAKTUR = $request->input('NO_FAKTUR');
		$BAYAR	= $request->input('BAYAR');
		$TOTAL	= $request->input('TOTAL');
		$SISA	= $request->input('SISA');
		$KET	= $request->input('KET');
       
         $query = DB::table('hutd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = HutDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'HZ',	
                        'GOL'        => 'Z',  							
                        'NO_FAKTUR'  => ($NO_FAKTUR[$i]==null) ? "" :  $NO_FAKTUR[$i],
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'BAYAR'      => (float) str_replace(',', '', $BAYAR[$i]),
                        'SISA'       => (float) str_replace(',', '', $SISA[$i]),
                        'KET'        => ($KET[$i]==null) ? "" :  $KET[$i]
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = HutDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'NO_FAKTUR'  => ($NO_FAKTUR[$i]==null) ? "" :  $NO_FAKTUR[$i],
                        'KET'        => ($KET[$i]==null) ? "" : $KET[$i],	
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'BAYAR'      => (float) str_replace(',', '', $BAYAR[$i]),
                        'SISA'       => (float) str_replace(',', '', $SISA[$i])
                    ]
                );
            }
        }

//  ganti 21
		$variablell = DB::select('call hutins(?,?)',array($hutn['NO_BUKTI'],'X'));
		
        return redirect('/hutn')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Hut $hutn)
    {


		$variablell = DB::select('call hutdel(?,?)',array($hutn['NO_BUKTI'],'1'));
		
		
// ganti 23
        $deleteHut = Hut::find($hutn->NO_ID);

// ganti 24

        $deleteHut->delete();

// ganti 
        return redirect('/hutn')->with('status', 'Data berhasil dihapus');
		
		
    }
}
