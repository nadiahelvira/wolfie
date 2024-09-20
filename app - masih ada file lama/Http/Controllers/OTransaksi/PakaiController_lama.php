<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Pakai;
use App\Models\OTransaksi\PakaiDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class PakaiController extends Controller
{
    public function index(Request $request)
    {
        $jns = "PK";
        $judul="";
        
        if (!empty($request->JNSPK))
        {
            $jns = $request->JNSPK;

            if ($jns=="PW")
            {
                $judul="WIP";
            }
        }
        return view('otransaksi_pakai.index', ['JNSPK'=>$jns, 'JUDUL'=>$judul]);
    }

    public function cekOrderkWIP(Request $request)
    {
		$orderWIP = DB::SELECT("SELECT NO_BUKTI FROM orderk WHERE NO_SO='".$request->no_so."' and FLAG='OW' and FIN=0;");
		return response()->json($orderWIP);
    }
	
    public function browseXd(Request $request)
    {
		$xd = DB::SELECT("SELECT KD_PRS, NA_PRS, NO_PRS from orderkxd WHERE NO_BUKTI='".$request->nobukti."'  order by AKHIR,NO_PRS;");
		return response()->json($xd);
	}

    public function browseOk(Request $request)
    {
        $flag = "OK";
        $filterqty = "a.QTY-a.PROSES";

        if($request->flag=="PW")
        {
            $flag = "OW";
            $filterqty = "a.QTY_BHN-a.PROSES";
        }

		$ok = DB::SELECT("SELECT 'A' JNS, a.NO_BUKTI, a.KD_BRG, a.NA_BRG, a.KD_BHN, a.NA_BHN, a.SATUAN, 'AWAL' KD_PRSX, 'AWAL' NA_PRSX, 
        b.NO_PRS, b.KD_PRS, b.NA_PRS, b.MASUK, b.KELUAR, b.LAIN, b.SISA, $filterqty PROSES,
        b.NO_ID ID_ODR, a.NO_ID ID_ODRX, A.ID_SOD, a.NO_SO, a.NO_FO 
        FROM orderk a, orderkxd b 
        where a.NO_BUKTI=b.NO_BUKTI /*and b.NO_PRS<=1 and b.AKHIR=1*/ AND $filterqty>0 AND a.FLAG='$flag'
        union ALL 
        SELECT 'B' JNS, a.NO_BUKTI, c.KD_BRG, c.NA_BRG, c.KD_BHN, c.NA_BHN, c.SATUAN, a.KD_PRS KD_PRSX, a.NA_PRS NA_PRSX, 
        b.NO_PRS, b.KD_PRS, b.NA_PRS, b.MASUK, b.KELUAR, b.LAIN, b.SISA, a.KELUAR-a.PROSES PROSES, 
        b.NO_ID ID_ODR, a.NO_ID ID_ODRX, c.ID_SOD, c.NO_SO, c.NO_FO 
        FROM orderkxd a, orderkxd b, orderk c 
        where a.NO_BUKTI=b.NO_BUKTI and a.NO_BUKTI=c.NO_BUKTI /*and b.NO_PRS>1 and a.NO_PRS-B.NO_PRS=-1 and b.AKHIR=1*/ AND a.KELUAR-a.PROSES>0 AND a.FLAG='$flag';");
		return response()->json($ok);
	}

    public function browsePrs(Request $request)
    {
		$prs = DB::SELECT("SELECT KD_PRS, NA_PRS from prs order by KD_PRS;");
		return response()->json($prs);
	}

    public function browseBhn(Request $request)
    {
		$bhn = DB::SELECT("SELECT KD_BHN, NA_BHN, JENIS, SATUAN from bhn order by KD_BHN;");
		return response()->json($bhn);
	}
    
    public function getPakai(Request $request)
    {
		if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}

        $pakai = DB::table('pakai')->select('*')->where('PER', $periode)->where('FLAG', $request->JNSPK)->orderBy('NO_BUKTI', 'ASC')->get();
		   	 	 
        return Datatables::of($pakai)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="pakai/edit/' . $row->NO_ID . '" ';
                        $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="pakai/delete/' . $row->NO_ID . '" ';

                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pakai/print/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="pakai/show/'. $row->NO_ID .'">
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
        $jns = "PK";
        $judul="";
        
        if (!empty($request->JNSPK))
        {
            $jns = $request->JNSPK;

            if ($jns=="PW")
            {
                $judul="WIP";
            }
        }

        return view('otransaksi_pakai.create', ['JNSPK'=>$jns, 'JUDUL'=>$judul]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'NO_BUKTI' => 'required',
            'TGL'      => 'required',
            'NO_SO'    => 'required',
            'NO_FO'    => 'required',
            'NO_OK'    => 'required',
        ]
        );

		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
        
        $flagbukti = "PK";
        if (!empty($request->JNSPK))
        {
            $flagbukti = $request->JNSPK;
        }

		$query = DB::table('pakai')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $flagbukti)->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = $flagbukti.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = $flagbukti.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $pakai = Pakai::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
				'FLAG'             => $flagbukti,
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_IN'           => (float) str_replace(',', '', $request['QTYI']),
                'QTY_OUT'          => (float) str_replace(',', '', $request['QTYO']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KD_PRS'           => ($request['KD_PRSH']==null) ? "" : $request['KD_PRSH'],			
                'NA_PRS'           => ($request['NA_PRSH']==null) ? "" : $request['NA_PRSH'],
				'NO_PRS'           => ($request['NO_PRS']==null) ? "" : $request['NO_PRS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'USRNM'            => Auth::user()->username,	
                'PER'              => $periode,
				'TG_SMP'           => Carbon::now(),
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$QTYX	= $request->input('QTYX');
		$KET	= $request->input('KET');		

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new PakaiDetail;
				$idPakai = DB::table('pakai')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;	
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];	
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];	
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->QTYX	= (float) str_replace(',', '', $QTYX[$key]);
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];
				$detail->REC	= $REC[$key];
				$detail->ID	    = $idPakai[0]->NO_ID;
				$detail->PER	= $periode;
				$detail->FLAG	= $flagbukti;
				$detail->save();
			}
		}
        DB::SELECT("CALL pakaiins('$no_bukti')");

        return redirect('/pakai?JNSPK='.$flagbukti)->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Pakai $pakai)
    {
        $judul = "";
        if ($pakai->FLAG=='PW')
        {
            $judul="WIP";
        }

        $no_bukti = $pakai->NO_BUKTI;
        $pakaiDetail = DB::table('pakaid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pakai,
			'detail'		=> $pakaiDetail
		];        
		
		return view('otransaksi_pakai.show', $data, ['JUDUL'=>$judul]);
    }

    public function edit(Pakai $pakai)
    {
        $judul = "";
        if ($pakai->FLAG=='PW')
        {
            $judul="WIP";
        }

        $no_bukti = $pakai->NO_BUKTI;
        $pakaiDetail = DB::table('pakaid')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $pakai,
			'detail'		=> $pakaiDetail
		];        
		
		return view('otransaksi_pakai.edit', $data, ['JUDUL'=>$judul]);
    }

    public function update(Request $request, Pakai $pakai )
    {
		
        $this->validate($request,
        [
            'NO_BUKTI' => 'required',
            'TGL'      => 'required',
            'NO_SO'    => 'required',
            'NO_FO'    => 'required',
            'NO_OK'    => 'required',
        ]
        );
	
        DB::SELECT("CALL pakaidel('$pakai->NO_BUKTI')");

        $pakai->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_IN'           => (float) str_replace(',', '', $request['QTYI']),
                'QTY_OUT'          => (float) str_replace(',', '', $request['QTYO']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KD_PRS'            => ($request['KD_PRSH']==null) ? "" : $request['KD_PRSH'],			
                'NA_PRS'            => ($request['NA_PRSH']==null) ? "" : $request['NA_PRSH'],
				'NO_PRS'           => ($request['NO_PRS']==null) ? "" : $request['NO_PRS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'USRNM'            => Auth::user()->username,	
				'TG_SMP'           => Carbon::now(),
            ]
        );

        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID	= $request->input('NO_ID');
		$REC	= $request->input('REC');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$QTYX	= $request->input('QTYX');
		$KET	= $request->input('KET');	
       
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('pakaid')->where('NO_BUKTI', $pakai->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PakaiDetail::create(
                    [
                        'NO_BUKTI'   => $pakai->NO_BUKTI,				
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'QTYX'        => (float) str_replace(',', '', $QTYX[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                        'ID'         => $pakai->NO_ID,
				        'PER'        => $pakai->PER,
                        'FLAG'       => $pakai->FLAG,	
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = PakaiDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $pakai->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [				
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'QTYX'        => (float) str_replace(',', '', $QTYX[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                    ]
                );
            }
        }	   

        DB::SELECT("CALL pakaiins('$pakai->NO_BUKTI')");
        return redirect('/pakai?JNSPK='.$pakai->FLAG)->with('status', 'Data '.$request->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(Pakai $pakai)
    {
        DB::SELECT("CALL pakaidel('$pakai->NO_BUKTI')");
        Pakai::find($pakai->NO_ID)->delete();
        DB::SELECT("DELETE from pakaid WHERE NO_BUKTI='$pakai->NO_BUKTI'");

        return redirect('/pakai?JNSPK='.$pakai->FLAG)->with('status', 'Data '.$pakai->NO_BUKTI.' berhasil dihapus');
    }
}

