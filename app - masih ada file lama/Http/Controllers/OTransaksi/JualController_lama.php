<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Jual;
use App\Models\OTransaksi\JualDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class JualController extends Controller
{
    public function index()
    {
        return view('otransaksi_jual.index');
    }

    public function browseSj(Request $request)
    {
		$so = DB::SELECT("SELECT DISTINCT SURATS.NO_BUKTI,SURATS.TGL,SURATS.KODEC,SURATS.NAMAC,SURATS.ALAMAT,SURATS.KOTA,SURATS.NO_SO,SURATS.TRUCK,SURATS.SOPIR 
        from surats,SURATSD 
        WHERE SURATS.NO_BUKTI=SURATSD.NO_BUKTI #AND SURATS.POSTED=1 AND SURATSD.SISA>0 AND SURATSD.TYP<>'B'");
		return response()->json($so);
	}

    public function browseSuratsd(Request $request)
    {
		$fod = DB::SELECT("SELECT REC,TYP,KD_BRG,NA_BRG,SATUAN,QTY,HARGA,NO_SERI,KET,NO_SO,ID_SOD FROM suratsd WHERE NO_BUKTI='".$request->nobukti."' and SISA>0 AND TYP<>'B' 
        ORDER BY REC");
		return response()->json($fod);
	}

    public function browseSo(Request $request)
    {
        $listDetail = implode(",", $request->listDetail);
        $inDetail = '';
        // if ($request->listDetail) {
        //     $inDetail = " and so.NO_BUKTI not in ($listDetail) ";
        // }

		$so = DB::SELECT("SELECT so.NO_BUKTI, coalesce(terima.NO_BUKTI,'') NO_TERIMA, so.TGL, so.NAMAC, sod.KD_BRG, sod.NA_BRG, sod.SATUAN, sod.MERK, sod.NO_SERI, sod.KET, sod.QTY SISA, 
        if((SELECT JENIS from brg where KD_BRG=sod.KD_BRG limit 1)='JUAL', 'J',
            if((SELECT JENIS from brg where KD_BRG=sod.KD_BRG limit 1)='', 'N', (SELECT JENIS from brg where KD_BRG=sod.KD_BRG limit 1)
            )
        ) TYP, sod.NO_ID, sod.HARGA 
        from so, sod LEFT JOIN terima on sod.NO_ID=terima.ID_SOD 
        WHERE so.NO_BUKTI=sod.NO_BUKTI and sod.SISA>0 and terima.SISA>0 and so.KODEC='".$request->kodec."' $inDetail");
		return response()->json($so);
	}

    public function getJual(Request $request)
    {
	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
			
        $jual = DB::table('jual')->select('*')->where('PER', $periode)->where('FLAG', 'JL' )->orderBy('NO_BUKTI', 'ASC')->get();
			 	 
        return Datatables::of($jual)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="jual/edit/' . $row->NO_ID . '" ';
                        $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="jual/delete/' . $row->NO_ID . '" ';

                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jual/print/'. $row->NO_ID .'">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" ' . $btnDelete . '>
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
                            <a class="dropdown-item" href="jual/show/'. $row->NO_ID .'">
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

    public function create()
    {
        return view('otransaksi_jual.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'NO_BUKTI'   => 'required',
                'TGL'        => 'required',
                'NO_SJ'      => 'required',
                'TRUCK'      => 'required',
                'SOPIR'      => 'required',
            ]
        );

	    // Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('jual')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'JL')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'JL'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'JL'.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $jual = Jual::create(
            [
				'NO_BUKTI'      => $no_bukti,
                'TGL'           => date('Y-m-d', strtotime($request['TGL'])),			
                'FLAG'          => 'JL',		
                'NO_JUAL'       => ($request['NO_SJ']==null) ? "" : $request['NO_SJ'],
                'TRUCK'         => ($request['TRUCK']==null) ? "" : $request['TRUCK'],
                'SOPIR'         => ($request['SOPIR']==null) ? "" : $request['SOPIR'],
                'KODEC'         => ($request['KODEC']==null) ? "" : $request['KODEC'],	
				'NAMAC'		    =>($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'		=>($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'		    =>($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'			=>($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'     => (float) str_replace(',', '', $request['TQTY']),
                'TOTAL'      	=> (float) str_replace(',', '', $request['TTOTAL']),
                'PPN'      	    => 0,
                'NETT'      	=> (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'         => Auth::user()->username,
                'PER'           => $periode,	
				'TG_SMP'        => Carbon::now(),
            ]
        );

		// Insert Detail
		$REC	= $request->input('REC');
		$NO_SO	= $request->input('NO_SO');
		$TYP	= $request->input('TYP');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$NO_SERI = $request->input('NO_SERI');	
		$KET	= $request->input('KET');	
		$ID_SOD	= $request->input('ID_SOD');		

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new JualDetail;
				$idJual = DB::table('jual')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;	
				$detail->NO_SO	= $NO_SO[$key];
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'JL';
				$detail->TYP	= ($TYP[$key]==null) ? '' : $TYP[$key];
				$detail->KD_BRG	= ($KD_BRG[$key]==null) ? '' : $KD_BRG[$key];
				$detail->NA_BRG	= ($NA_BRG[$key]==null) ? '' : $NA_BRG[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);
				$detail->NO_SERI	= ($NO_SERI[$key]==null) ? '' : $NO_SERI[$key];
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];
				$detail->ID	    = $idJual[0]->NO_ID;
				$detail->ID_SOD	= ($ID_SOD[$key]==null) ? '' : $ID_SOD[$key];
				$detail->save();
			}
		}
        DB::SELECT("CALL jualins('$no_bukti')");

        return redirect('/jual')->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Jual $jual)
    {
       $no_bukti = $jual->NO_BUKTI;
        $jualDetail = DB::table('juald')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $jual,
			'detail'		=> $jualDetail
		];        
        return view('otransaksi_jual.show', $data);
    }

    public function edit(Jual $jual)
    {
        $no_bukti = $jual->NO_BUKTI;
        $jualDetail = DB::table('juald')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $jual,
			'detail'		=> $jualDetail
		];        
        return view('otransaksi_jual.edit', $data);
    }

    public function update(Request $request, Jual $jual )
    {
        $this->validate($request,
            [
                'NO_BUKTI'   => 'required',
                'TGL'        => 'required',
                'NO_SJ'      => 'required',
                'TRUCK'      => 'required',
                'SOPIR'      => 'required',
            ]
        );
		
        DB::SELECT("CALL jualdel('$jual->NO_BUKTI')");

        $jual->update(
            [
                'TGL'           => date('Y-m-d', strtotime($request['TGL'])),	
                'NO_JUAL'       => ($request['NO_SJ']==null) ? "" : $request['NO_SJ'],
                'TRUCK'         => ($request['TRUCK']==null) ? "" : $request['TRUCK'],
                'SOPIR'         => ($request['SOPIR']==null) ? "" : $request['SOPIR'],
                'KODEC'         => ($request['KODEC']==null) ? "" : $request['KODEC'],	
				'NAMAC'		    =>($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'		=>($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'		    =>($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'			=>($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'     => (float) str_replace(',', '', $request['TQTY']),
                'TOTAL'      	=> (float) str_replace(',', '', $request['TTOTAL']),
                'PPN'      	    => 0,
                'NETT'      	=> (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'         => Auth::user()->username,
				'TG_SMP'        => Carbon::now(),
            ]
        );

		// Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');
		$REC	= $request->input('REC');
		$NO_SO	= $request->input('NO_SO');
		$TYP	= $request->input('TYP');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$NO_SERI = $request->input('NO_SERI');	
		$KET	= $request->input('KET');	
		$ID_SOD	= $request->input('ID_SOD');	
       
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('juald')->where('NO_BUKTI', $jual->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = JualDetail::create(
                    [
                        'NO_BUKTI'   => $jual->NO_BUKTI,
                        'NO_SO'      => ($NO_SO[$i]==null) ? "" :  $NO_SO[$i],
                        'REC'        => $REC[$i],
				        'PER'        => $jual->PER,	
				        'FLAG'       => 'JL',					
                        'TYP'        => ($TYP[$i]==null) ? "" :  $TYP[$i],
                        'NO_TERIMA'  => ($NO_TERIMA[$i]==null) ? "" :  $NO_TERIMA[$i],	
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'      	 => (float) str_replace(',', '', $QTY[$i]),
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'NO_SERI'    => ($NO_SERI[$i]==null) ? "" : $NO_SERI[$i],
                        'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'ID'         => $jual->NO_ID,
                        'ID_SOD'     => ($ID_SOD[$i]==null) ? "" : $ID_SOD[$i],
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = JualDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $jual->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'NO_SO'      => ($NO_SO[$i]==null) ? "" :  $NO_SO[$i],
                        'REC'        => $REC[$i],		
                        'TYP'        => ($TYP[$i]==null) ? "" :  $TYP[$i],
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'      	 => (float) str_replace(',', '', $QTY[$i]),
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'NO_SERI'    => ($NO_SERI[$i]==null) ? "" : $NO_SERI[$i],
                        'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'ID_SOD'     => ($ID_SOD[$i]==null) ? "" : $ID_SOD[$i],
                    ]
                );
            }
        }	   
	   
        DB::SELECT("CALL jualins('$jual->NO_BUKTI')");
        return redirect('/jual')->with('status', 'Data '.$request->NO_BUKTI.' berhasil diubah');
    }

    public function destroy(Jual $jual)
    {
        DB::SELECT("CALL jualdel('$jual->NO_BUKTI')");
        Jual::find($jual->NO_ID)->delete();
        DB::SELECT("DELETE from juald WHERE NO_BUKTI='$jual->NO_BUKTI'");

        return redirect('/jual')->with('status', 'Data '.$jual->NO_BUKTI.' berhasil dihapus');
    }
}