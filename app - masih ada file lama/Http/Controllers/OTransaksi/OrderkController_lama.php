<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Orderk;
use App\Models\OTransaksi\OrderkDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class OrderkController extends Controller
{
    public function index(Request $request)
    {
        $jns = "OK";
        $judul="";
        
        if (!empty($request->JNSOK))
        {
            $jns = $request->JNSOK;

            if ($jns=="OW")
            {
                $judul="WIP";
            }
        }
        return view('otransaksi_orderk.index', ['JNSOK'=>$jns, 'JUDUL'=>$judul]);
    }

    public function browsePakai(Request $request)
    {
        $pakai = DB::SELECT("
        SELECT NO_BUKTI, TGL, KD_PRS, NA_PRS, QTY_IN, QTY_OUT from pakai WHERE NO_ORDER='".$request->NO_ORDER."' and KD_PRS='".$request->KD_PRS."'
        order by NO_BUKTI");
        return response()->json($pakai);
    }
    
    public function browseOrderkxd(Request $request)
    {
        $sod = DB::table('orderkxd')->select('REC','NO_ID','NO_BUKTI','NO_PRS', 'KD_PRS', 'NA_PRS', 'MASUK', 'KELUAR', 'LAIN', 'SISA', 'PROSES', 'BLM_PROSES','AKHIR')->where('NO_BUKTI', $request->NO_BUKTI)->orderBy('NO_PRS', 'ASC')->get();
        return response()->json($sod);
    }
    
    public function browseSo()
    {
		$so = DB::SELECT("SELECT SO.NO_BUKTI, SO.TGL, SO.KODEC, SO.NAMAC, SO.ALAMAT, SO.KOTA, SOD.KD_BRG, SOD.NA_BRG, SOD.QTY, SOD.SATUAN, SOD.NO_SERI, SOD.NO_ID FROM SO,SOD WHERE SO.NO_BUKTI = SOD.NO_BUKTI AND SOD.NO_ORDER =''");
		return response()->json($so);
	}

    public function browseFo(Request $request)
    {
		$fo = DB::SELECT("SELECT FO.NO_BUKTI, FO.KD_BRG, FO.NA_BRG, FO.NOTES from FO where FO.KD_BRG='".$request->kdbrg."' and FO.AKTIF=1 order by FO.NO_BUKTI");
		return response()->json($fo);
	}

    public function browseFod(Request $request)
    {
		$fod = DB::SELECT("SELECT REC, KD_PRS, NA_PRS, KD_BHN, NA_BHN, SATUAN, QTY, KET from fod where NO_BUKTI='".$request->nobukti."' order by REC");
		return response()->json($fod);
	}

    public function browseFodPrs(Request $request)
    {
		$fod = DB::SELECT("SELECT REC, KD_PRS, NA_PRS, KD_BHN, NA_BHN, SATUAN, QTY, KET from fod where NO_BUKTI='".$request->NO_FO."' and KD_PRS ='".$request->KD_PRSH."' order by REC");
		return response()->json($fod);
	}
    
    public function getOrderk(Request $request)
    {
		if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


        $orderk = DB::table('orderk')->select('*')->where('PER', $periode)->where('FLAG', $request->JNSOK)->orderBy('NO_BUKTI', 'ASC')->get();
		   	 	 
        return Datatables::of($orderk)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="orderk/edit/' . $row->NO_ID . '" ';
                        $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="orderk/delete/' . $row->NO_ID . '" ';

                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="orderk/print/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="orderk/show/'. $row->NO_ID .'">
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
        $jns = "OK";
        $judul="";
        
        if (!empty($request->JNSOK))
        {
            $jns = $request->JNSOK;

            if ($jns=="OW")
            {
                $judul="WIP";
            }
        }

        return view('otransaksi_orderk.create', ['JNSOK'=>$jns, 'JUDUL'=>$judul]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'NO_BUKTI'       => 'required',
                'TGL'      => 'required',
                'NO_SO'       => 'required',
                'NO_FO'       => 'required',
                'KODEC'       => 'required',
            ]
        );

		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
        
        $flagbukti = "OK";
        if (!empty($request->JNSOK))
        {
            $flagbukti = $request->JNSOK;
        }

		$query = DB::table('orderk')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $flagbukti)->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = $flagbukti.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = $flagbukti.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $orderk = Orderk::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'JTEMPO'           => date('Y-m-d', strtotime($request['JTEMPO'])),	
				'FLAG'             => $flagbukti,
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'ID_SOD'           => ($request['ID_SOD']==null) ? 0 : $request['ID_SOD'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_BHN'          => ($flagbukti=="OW") ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'QTY'              => ($flagbukti=="OK") ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_SERI'          => ($request['NO_SERI']==null) ? "" : $request['NO_SERI'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],			
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTYA'       => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SISA'             => (float) str_replace(',', '', $request['QTYH']),
				'USRNM'            => Auth::user()->username,	
                'PER'              => $periode,
				'TG_SMP'           => Carbon::now(),
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		// $KD_PRS	= $request->input('KD_PRS');
		// $NA_PRS	= $request->input('NA_PRS');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		// $QTYA	= $request->input('QTYA');
		$QTY	= $request->input('QTY');
		$QTYX	= $request->input('QTYX');
		$KET	= $request->input('KET');		

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new OrderkDetail;
				$idOrderk = DB::table('orderk')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;	
				// $detail->KD_PRS	= $KD_PRS[$key];
				// $detail->NA_PRS	= $NA_PRS[$key];
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];	
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];	
				$detail->QTYA	= (float) str_replace(',', '', $QTY[$key]);
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->QTYX	= (float) str_replace(',', '', $QTYX[$key]);
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];
				$detail->REC	= $REC[$key];
				$detail->ID	    = $idOrderk[0]->NO_ID;
				$detail->PER	= $periode;
				$detail->FLAG	= $flagbukti;
				$detail->save();
			}
		}
        
	    $idOrderk = DB::table('orderk')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
        DB::statement("SET SQL_MODE=''");
        $cekPrs = DB::table('fod2')
        ->select('fod2.KD_PRS','fod2.NA_PRS','fod2.AKHIR')->where('NO_BUKTI', $request['NO_FO'])->groupBy('KD_PRS')->orderBy('NO_PRS', 'ASC')->get();
        
        if ($cekPrs != '[]') 
        {
            $rec=1;
            foreach ($cekPrs as $keyPrs => $value)
            {
                DB::SELECT("INSERT into orderkxd (NO_BUKTI, REC, PER, KD_PRS, NA_PRS, ID, FLAG,NO_PRS,AKHIR)
                values
                ('$no_bukti', $rec, '$periode', '".$cekPrs[$keyPrs]->KD_PRS."', '".$cekPrs[$keyPrs]->NA_PRS."', ".$idOrderk[0]->NO_ID.", '$flagbukti', $rec, ".$cekPrs[$keyPrs]->AKHIR.");");
                $rec=$rec+1;
            }
        }

        DB::SELECT("CALL orderkins('$no_bukti')");

        return redirect('/orderk?JNSOK='.$flagbukti)->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Orderk $orderk)
    {
        $judul = "";
        if ($orderk->FLAG=='OW')
        {
            $judul="WIP";
        }

        $no_bukti = $orderk->NO_BUKTI;
        $orderkDetail = DB::table('orderkd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $orderk,
			'detail'		=> $orderkDetail
		];        
		
		return view('otransaksi_orderk.show', $data, ['JUDUL'=>$judul]);
    }

    public function edit(Orderk $orderk)
    {
        $judul = "";
        if ($orderk->FLAG=='OW')
        {
            $judul="WIP";
        }

        $no_bukti = $orderk->NO_BUKTI;
        $orderkDetail = DB::table('orderkd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $orderk,
			'detail'		=> $orderkDetail
		];        
		
		return view('otransaksi_orderk.edit', $data, ['JUDUL'=>$judul]);
    }

    public function update(Request $request, Orderk $orderk )
    {
		
        $this->validate($request,
            [
                'NO_BUKTI'    => 'required',
                'TGL'         => 'required',
                'NO_SO'       => 'required',
                'NO_FO'       => 'required',
                'KODEC'       => 'required',
            ]
        );
	
        DB::SELECT("CALL orderkdel('$orderk->NO_BUKTI')");
        
        $orderk->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'JTEMPO'           => date('Y-m-d', strtotime($request['JTEMPO'])),	
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'ID_SOD'           => ($request['ID_SOD']==null) ? 0 : $request['ID_SOD'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_BHN'          => $orderk->FLAG=="OW" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'QTY'              => $orderk->FLAG=="OK" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_SERI'          => ($request['NO_SERI']==null) ? "" : $request['NO_SERI'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],			
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'           => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'             => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTYA'       => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SISA'             => (float) str_replace(',', '', $request['QTYH']),
				'USRNM'            => Auth::user()->username,	
				'TG_SMP'           => Carbon::now(),
            ]
        );

        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID	= $request->input('NO_ID');
		$REC	= $request->input('REC');
		// $KD_PRS	= $request->input('KD_PRS');
		// $NA_PRS	= $request->input('NA_PRS');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		// $QTYA	= $request->input('QTYA');
		$QTY	= $request->input('QTY');
		$QTYX	= $request->input('QTYX');
		$KET	= $request->input('KET');			
       
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('orderkd')->where('NO_BUKTI', $orderk->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
				$idOrderk = DB::table('orderk')->select('NO_ID','PER')->where('NO_BUKTI', $orderk->NO_BUKTI)->get();
                $insert = OrderkDetail::create(
                    [
                        'NO_BUKTI'   => $orderk->NO_BUKTI,
                        // 'KD_PRS'     => ($KD_PRS[$i]==null) ? "" :  $KD_PRS[$i],
                        // 'NA_PRS'     => ($NA_PRS[$i]==null) ? "" : $NA_PRS[$i],					
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTYA'       => (float) str_replace(',', '', $QTY[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'QTYX'       => (float) str_replace(',', '', $QTYX[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                        'ID'         => $orderk->NO_ID,
				        'PER'        => $orderk->PER,
                        'FLAG'       => $orderk->FLAG,	
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = OrderkDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $orderk->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        // 'KD_PRS'     => ($KD_PRS[$i]==null) ? "" :  $KD_PRS[$i],
                        // 'NA_PRS'     => ($NA_PRS[$i]==null) ? "" : $NA_PRS[$i],					
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTYA'       => (float) str_replace(',', '', $QTY[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'QTYX'       => (float) str_replace(',', '', $QTYX[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                    ]
                );
            }
        }	   
        
        DB::SELECT("CALL orderkins('$orderk->NO_BUKTI')");
        return redirect('/orderk?JNSOK='.$orderk->FLAG)->with('status', 'Data '.$request->NO_BUKTI.' berhasil diubah');
    }

    public function destroy(Orderk $orderk)
    {
        DB::SELECT("CALL orderkdel('$orderk->NO_BUKTI')");
        Orderk::find($orderk->NO_ID)->delete();
        DB::SELECT("DELETE from orderkd WHERE NO_BUKTI='$orderk->NO_BUKTI'");
        DB::SELECT("DELETE from orderkxd WHERE NO_BUKTI='$orderk->NO_BUKTI'");

        return redirect('/orderk?JNSOK='.$orderk->FLAG)->with('status', 'Data '.$orderk->NO_BUKTI.' berhasil dihapus');
    }
}
