<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Po;
use App\Models\OTransaksi\PoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class PoController extends Controller
{
    public function index()
    {
        return view('otransaksi_po.index');
    }

    public function getPo(Request $request)
    {
		if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


           $po = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'Y')->orderBy('NO_BUKTI', 'ASC')->get();
		   	 	 
        return Datatables::of($po)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="po/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="po/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus '.$row->NO_BUKTI.'? &quot;)" href="po/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="po/show/'. $row->NO_ID .'">
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

    public function create(Request $request )
    {
        return view('otransaksi_po.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'NO_BUKTI'       => 'required',
            'TGL'      => 'required',
            'KODES'       => 'required'
        ]
        );

		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PY'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'PY'.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $po = Po::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'JTEMPO'              => date('Y-m-d', strtotime($request['JTEMPO'])),		
                'PER'              => $periode,
				'FLAG'             => 'PY',
                'GOL'			   => 'Y',	
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],			
                'NAMAS'            => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'TERM'             => ($request['TERM']==null) ? "" : $request['TERM'],
				'VIA'              => ($request['VIA']==null) ? "" : $request['VIA'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
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
				$detail->FLAG	= 'PY';
				$detail->GOL	= 'Y';
				$detail->KD_BRG	= $KD_BRG[$key];
				$detail->NA_BRG	= $NA_BRG[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];
				$detail->KET	= $KET[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);				
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);	
				$detail->save();
			}
		}

        return redirect('/po')->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Po $po)
    {

        $no_bukti = $po->NO_BUKTI;
        $poDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $po,
			'detail'		=> $poDetail
		];        
		
		return view('otransaksi_po.show', $data);
    }

    public function edit(Po $po)
    {
        $no_bukti = $po->NO_BUKTI;
        $poDetail = DB::table('pod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $po,
			'detail'		=> $poDetail
		];        
		
		return view('otransaksi_po.edit', $data);
    }

    public function update(Request $request, Po $po )
    {
		
        $this->validate($request,
        [
            'TGL'      		=> 'required',
            'NO_BUKTI'       => 'required',
            'KODES'      	 => 'required'
        ]
        );
	
        $po->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'JTEMPO'           => date('Y-m-d', strtotime($request['JTEMPO'])),	
                'KODES'            => ($request['KODES']==null) ? "" : $request['KODES'],	
				'NAMAS'			   =>($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'TERM'             => ($request['TERM']==null) ? "" : $request['TERM'],
				'VIA'              => ($request['VIA']==null) ? "" : $request['VIA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()	
            ]
        );

        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID	= $request->input('NO_ID');
        $REC	= $request->input('REC');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$QTY	= $request->input('QTY');
		$NOTES	= $request->input('NOTES');
       
	   
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
                        'FLAG'       => 'PY',	
                        'GOL'        => 'Y',  							
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
                    'REC'       => $REC[$i],
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
////////////////////////////////////////////////////////////////
        return redirect('/po')->with('status', 'Data '.$request->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(Po $po)
    {
        $deletePo = Po::find($po->NO_ID);
        $deletePo->delete();
        DB::SELECT("DELETE from pod WHERE NO_BUKTI='$po->NO_BUKTI'");

        return redirect('/po')->with('status', 'Data '.$po->NO_BUKTI.' berhasil dihapus');
    }
}
