<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\So;
use App\Models\OTransaksi\SoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class SoController extends Controller
{
    public function index()
    {
        return view('otransaksi_so.index');
    }

    public function browsesod(Request $request)
    {
        $sod = DB::table('sod')->select('REC','NO_ID', 'KD_BRG', 'NA_BRG', 'QTY', 'QTY_ODR', 'QTY_HP', 'QTY_LAIN', 'SISA_HP', 'QTY_SJ', 'SISA_SJ')->where('NO_BUKTI', $request->NO_BUKTI)->orderBy('REC', 'ASC')->get();
        return response()->json($sod);
    }

    public function browseOrderk(Request $request)
    {
        $orderk = DB::SELECT('
        SELECT a.NO_BUKTI, a.TGL, NO_PRS, b.KD_PRS, b.NA_PRS, b.MASUK, b.KELUAR, b.SISA, b.PROSES 
        from orderk a, orderkxd b 
        where a.NO_BUKTI=b.NO_BUKTI and a.ID_SOD='.$request->NO_ID.' 
        order by NO_BUKTI, NO_PRS');
        return response()->json($orderk);
    }

    public function browsePakai(Request $request)
    {
        $pakai = DB::SELECT('
        SELECT a.NO_BUKTI, a.TGL, b.KD_PRS, b.NA_PRS, b.QTY as QTY_IN, b.QTY as QTY_OUT, b.KD_BHN, b.NA_BHN, b.QTY 
        from pakai a, pakaid b 
        where a.NO_BUKTI=b.NO_BUKTI and a.ID_SOD='.$request->NO_ID.' 
        order by no_bukti,kd_bhn');
        return response()->json($pakai);
    }
    
    public function browseTerima(Request $request)
    {
        $terima = DB::SELECT('
        SELECT a.NO_BUKTI, a.TGL, a.KD_BRG, a.NA_BRG, a.QTY 
        from terima a 
        where a.ID_SOD='.$request->NO_ID.' 
        order by NO_BUKTI, KD_BHN');
        return response()->json($terima);
    }

    public function browseSurats(Request $request)
    {
        $surats = DB::SELECT('
        SELECT a.NO_BUKTI, a.TGL, b.KD_BRG, b.NA_BRG, b.QTY 
        from surats a, suratsd b 
        where a.NO_BUKTI=b.NO_BUKTI and b.ID_SOD='.$request->NO_ID.' 
        order by NO_BUKTI');
        return response()->json($surats);
    }

    public function getSo(Request $request)
    {
	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
		
           $so = DB::table('so')->select('*')->where('PER', $periode)->where('FLAG', 'SO')->orderBy('NO_BUKTI', 'ASC')->get();
	
        return Datatables::of($so)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="so/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="so/print/'. $row->NO_ID .'">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="so/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="so/show/'. $row->NO_ID .'">
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
    
    public function multiSo()
    {
        return view('otransaksi_so.multiso');
    }

    public function getMultiSo(Request $request)
    {
	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
        
        $so = DB::SELECT("SELECT so.NO_BUKTI, so.TGL, so.KODEC, so.NAMAC, so.ALAMAT, so.KOTA, so.NOTES, sod.KD_BRG, sod.NA_BRG, sod.QTY, sod.KET, sod.SATUAN, sod.NO_ID, sod.NO_ORDER FROM so, sod  WHERE so.NO_BUKTI=sod.NO_BUKTI AND sod.NO_ORDER = '' 
        ORDER BY so.NO_BUKTI
        ");
        return Datatables::of($so)
                ->addIndexColumn()
                ->addColumn('cek', function ($row) {
                    return
                        '
                        <input type="checkbox" name="cek[]" class="cek form-control" ' . (($row->NO_ORDER != "") ? "checked" : "") . '  value="' . $row->NO_ID . '" ' . (($row->NO_ORDER != "") ? "disabled" : "") . '></input>
                        ';
                })
                ->addColumn('nofo', function ($row) {
                    return
                        '
                        <input type="text" id="NO_FO'.$row->NO_ID.'" name="NO_FO[]" class="form-control NO_FO" onkeypress="browseFo(event,this.id)" placeholder="Formula#" readonly></input>
                        ';
                })
                ->addColumn('qtyso', function ($row) {
                    return
                        '
                        <input type="text" id="qtyso'.$row->NO_ID.'" name="qtyso[]" class="form-control qtyso" placeholder="Qty Terima" value="'.number_format($row->QTY, 0, ".", ",").'" style="text-align: right" onclick="select()" onkeyup="hitung()"></input>
                        <input type="text" id="KDBRG'.$row->NO_ID.'" value="'.$row->KD_BRG.'" readonly hidden>
                        ';
                })
                ->rawColumns(['cek','nofo','qtyso'])
                ->make(true);
    }

    public function postMultiSo(Request $request)
    {
        ////////////NAMBAH LANGSUNG JADI BARANG 1/2 JADI/////////////////
        ////////////PAKAI panggil order kerja, cek dulu apakah OK lain yang 1/2 jadi sudah finish//////
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);

        $NO_FO = $request->input('NO_FO');
        $CEK = $request->input('cek');
        $QTY = $request->input('qtyso');

        $hasilFo = "";

        if ($CEK) {
            foreach ($CEK as $key => $value) 
            {
                $getSod = DB::SELECT("SELECT so.NO_BUKTI, so.TGL, so.KODEC, so.NAMAC, so.ALAMAT, so.KOTA, so.NOTES, sod.KD_BRG, sod.NA_BRG, ".(float) str_replace(',', '', $QTY[$key])." as QTY, sod.KET, sod.SATUAN, sod.NO_ID, sod.NO_ORDER FROM so, sod  WHERE so.NO_BUKTI=sod.NO_BUKTI AND sod.NO_ORDER = '' AND sod.NO_ID=$CEK[$key];");

                $cekFormula = DB::table('fo')->select('NO_BUKTI','KD_BRG','NA_BRG','TOTAL_QTY')->where('KD_BRG', $getSod[0]->KD_BRG)->where('AKTIF', 1)->where('NO_BUKTI', $NO_FO[$key])->get();
                // $cekFormula = DB::table('fo')
                // ->join('fod', 'fo.NO_BUKTI', '=', 'fod.NO_BUKTI')
                // ->select('fo.NO_BUKTI','fo.KD_BRG','fo.NA_BRG','fo.TOTAL_QTY')->where('fo.KD_BRG', $KD_BRG[$key])->where('fo.AKTIF', 1)->where('fod.KD_PRS', $KD_PRS[$key])->get();

                if ($cekFormula != '[]') 
                {
                    $flag = 'OK';
                    $query = DB::table('orderk')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $flag)->orderByDesc('NO_BUKTI')->limit(1)->get();
        
                    if ($query != '[]') {
                        $query = substr($query[0]->NO_BUKTI, -4);
                        $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                        $no_bukti = $flag . $tahun . $bulan . '-' . $query;
                    } else {
                        $no_bukti = $flag . $tahun . $bulan . '-0001';
                    }
                
                    DB::SELECT("INSERT into orderk (NO_BUKTI,TGL,JTEMPO,KODEC,NAMAC,ALAMAT,KOTA,TOTAL_QTY,TOTAL_QTYA, POSTED, NO_SO, QTY, SISA, KD_BRG, SATUAN, NA_BRG, NO_FO, NOTES, USRNM, TG_SMP, PER, FLAG, ID_SOD) 
                    values
                    ('$no_bukti',now(),now(),'".$getSod[0]->KODEC."','".$getSod[0]->NAMAC."','".$getSod[0]->ALAMAT."','".$getSod[0]->KOTA."',".$cekFormula[0]->TOTAL_QTY.",".$cekFormula[0]->TOTAL_QTY.",0,'".$getSod[0]->NO_BUKTI."',".$getSod[0]->QTY.",".$getSod[0]->QTY.",'".$getSod[0]->KD_BRG."','".$getSod[0]->SATUAN."','".$getSod[0]->NA_BRG."','".$cekFormula[0]->NO_BUKTI."','".$getSod[0]->KET."','".Auth::user()->username."',now(),'$periode','$flag',".$getSod[0]->NO_ID.");");

                    
                    $cekOrderk = DB::table('orderk')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
                    if ($cekOrderk != '[]') 
                    {
                        DB::statement("SET SQL_MODE=''");
                        $cekFod = DB::table('fod')->select('KD_PRS','NA_PRS','KD_BHN','NA_BHN','SATUAN',DB::raw('SUM(QTY) AS QTY'),'KET')->where('NO_BUKTI', $cekFormula[0]->NO_BUKTI)->groupBy('KD_BHN')->orderBy('KD_PRS', 'ASC')->get();
                        
                        if ($cekFod != '[]') 
                        {
                            $rec=1;
                            foreach ($cekFod as $keyFod => $value)
                            {
                                DB::SELECT("INSERT into orderkd (NO_BUKTI, REC, PER, KD_PRS, NA_PRS, KD_BHN, NA_BHN, SATUAN, QTYA, QTY, QTYX, KET, ID, FLAG)
                                values
                                ('$no_bukti', $rec, '$periode', '".$cekFod[$keyFod]->KD_PRS."', '".$cekFod[$keyFod]->NA_PRS."', '".$cekFod[$keyFod]->KD_BHN."', '".$cekFod[$keyFod]->NA_BHN."', '".$cekFod[$keyFod]->SATUAN."', '".$cekFod[$keyFod]->QTY*$getSod[0]->QTY."', '".$cekFod[$keyFod]->QTY*$getSod[0]->QTY."', '".$cekFod[$keyFod]->QTY."', '".$cekFod[$keyFod]->KET."', ".$cekOrderk[0]->NO_ID.", '$flag');");
                                $rec=$rec+1;
                            }
                        }

                        DB::statement("SET SQL_MODE=''");
                        // $cekPrs = DB::table('fod')
                        // ->join('prs', 'fod.KD_PRS', '=', 'prs.KD_PRS')
                        // ->select('fod.KD_PRS','fod.NA_PRS','prs.AKHIR')->where('NO_BUKTI', $cekFormula[0]->NO_BUKTI)->groupBy('KD_PRS')->get();
                        $cekPrs = DB::table('fod2')
                        ->select('fod2.KD_PRS','fod2.NA_PRS','fod2.AKHIR')->where('NO_BUKTI', $cekFormula[0]->NO_BUKTI)->groupBy('KD_PRS')->orderBy('AKHIR', 'ASC')->orderBy('NO_PRS', 'ASC')->get();
                        
                        if ($cekPrs != '[]') 
                        {
                            $rec=1;
                            foreach ($cekPrs as $keyPrs => $value)
                            {
                                DB::SELECT("INSERT into orderkxd (NO_BUKTI, REC, PER, KD_PRS, NA_PRS, ID, FLAG,NO_PRS,AKHIR)
                                values
                                ('$no_bukti', $rec, '$periode', '".$cekPrs[$keyPrs]->KD_PRS."', '".$cekPrs[$keyPrs]->NA_PRS."', ".$cekOrderk[0]->NO_ID.", '$flag', $rec, ".$cekPrs[$keyPrs]->AKHIR.");");
                                $rec=$rec+1;
                            }
                        }
                    }

                    DB::SELECT("CALL orderkins('" . $no_bukti . "');");
                    
                    $cekFoBahan = DB::SELECT("SELECT NO_BUKTI, KD_BRG, NA_BRG, TOTAL_QTY,(SELECT sum(QTY) from fod WHERE KD_BHN=fo.KD_BRG and NO_BUKTI='".$NO_FO[$key]."') as QTY_BHN from fo WHERE FLAG='FW' and AKTIF=1 and KD_BRG in (SELECT KD_BRG from fod WHERE NO_BUKTI='".$NO_FO[$key]."') ORDER BY NO_BUKTI");
                    if ($cekFoBahan != '[]') 
                    {
                        foreach ($cekFoBahan as $keyFoBahan => $value)
                        {
                            $flag = 'OW';
                            $query = DB::table('orderk')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $flag)->orderByDesc('NO_BUKTI')->limit(1)->get();
                
                            if ($query != '[]') {
                                $query = substr($query[0]->NO_BUKTI, -4);
                                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                                $no_bukti = $flag . $tahun . $bulan . '-' . $query;
                            } else {
                                $no_bukti = $flag . $tahun . $bulan . '-0001';
                            }
                            
                            DB::SELECT("INSERT into orderk (NO_BUKTI,TGL,JTEMPO,KODEC,NAMAC,ALAMAT,KOTA,TOTAL_QTY,TOTAL_QTYA, POSTED, NO_SO, QTY, SISA, KD_BRG, SATUAN, NA_BRG, NO_FO, NOTES, USRNM, TG_SMP, PER, FLAG, ID_SOD, KD_BHN, NA_BHN, QTY_BHN) 
                            values
                            ('$no_bukti',now(),now(),'".$getSod[0]->KODEC."','".$getSod[0]->NAMAC."','".$getSod[0]->ALAMAT."','".$getSod[0]->KOTA."',".$cekFoBahan[$keyFoBahan]->TOTAL_QTY.",".$cekFoBahan[$keyFoBahan]->TOTAL_QTY.",0,'".$getSod[0]->NO_BUKTI."',0,".$getSod[0]->QTY*$cekFoBahan[$keyFoBahan]->QTY_BHN.",'".$getSod[0]->KD_BRG."','".$getSod[0]->SATUAN."','".$getSod[0]->NA_BRG."','".$cekFoBahan[$keyFoBahan]->NO_BUKTI."','".$getSod[0]->KET."','".Auth::user()->username."',now(),'$periode','$flag',".$getSod[0]->NO_ID.",'".$cekFoBahan[$keyFoBahan]->KD_BRG."','".$cekFoBahan[$keyFoBahan]->NA_BRG."','".$getSod[0]->QTY*$cekFoBahan[$keyFoBahan]->QTY_BHN."');");

                            $cekOrderkBahan = DB::table('orderk')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();

                            DB::statement("SET SQL_MODE=''");
                            $cekFodBahan = DB::table('fod')->select('KD_PRS','NA_PRS','KD_BHN','NA_BHN','SATUAN',DB::raw('SUM(QTY) AS QTY'),'KET')->where('NO_BUKTI', $cekFoBahan[$keyFoBahan]->NO_BUKTI)->groupBy('KD_BHN')->orderBy('KD_PRS', 'ASC')->get();
                            
                            $rec=1;
                            foreach ($cekFodBahan as $keyFodBahan => $value)
                            {
                                DB::SELECT("INSERT into orderkd (NO_BUKTI, REC, PER, KD_PRS, NA_PRS, KD_BHN, NA_BHN, SATUAN, QTYA, QTY, QTYX, KET, ID, FLAG)
                                values
                                ('$no_bukti', $rec, '$periode', '".$cekFodBahan[$keyFodBahan]->KD_PRS."', '".$cekFodBahan[$keyFodBahan]->NA_PRS."', '".$cekFodBahan[$keyFodBahan]->KD_BHN."', '".$cekFodBahan[$keyFodBahan]->NA_BHN."', '".$cekFodBahan[$keyFodBahan]->SATUAN."', '".$cekFodBahan[$keyFodBahan]->QTY*$getSod[0]->QTY*$cekFoBahan[$keyFoBahan]->QTY_BHN."', '".$cekFodBahan[$keyFodBahan]->QTY*$getSod[0]->QTY*$cekFoBahan[$keyFoBahan]->QTY_BHN."', '".$cekFodBahan[$keyFodBahan]->QTY."', '".$cekFodBahan[$keyFodBahan]->KET."', ".$cekOrderkBahan[0]->NO_ID.", '$flag');");
                                $rec=$rec+1;
                            }
                            
                            DB::statement("SET SQL_MODE=''");
                            $cekPrsBahan = DB::table('fod2')
                            ->select('fod2.KD_PRS','fod2.NA_PRS','fod2.AKHIR')->where('NO_BUKTI', $cekFoBahan[$keyFoBahan]->NO_BUKTI)->groupBy('KD_PRS')->orderBy('AKHIR', 'ASC')->orderBy('NO_PRS', 'ASC')->get();
                            
                            if ($cekPrsBahan != '[]') 
                            {
                                $rec=1;
                                foreach ($cekPrsBahan as $keyPrsBahan => $value)
                                {
                                    DB::SELECT("INSERT into orderkxd (NO_BUKTI, REC, PER, KD_PRS, NA_PRS, ID, FLAG,NO_PRS,AKHIR)
                                    values
                                    ('$no_bukti', $rec, '$periode', '".$cekPrsBahan[$keyPrsBahan]->KD_PRS."', '".$cekPrsBahan[$keyPrsBahan]->NA_PRS."', ".$cekOrderkBahan[0]->NO_ID.", '$flag', $rec, ".$cekPrsBahan[$keyPrsBahan]->AKHIR.");");
                                    $rec=$rec+1;
                                }
                            }
                            
                            DB::SELECT("CALL orderkins('" . $no_bukti . "');");
                        }
                    }
                    else
                    {
                        $hasilFo = $hasilFo ."FORMULA UNTUK BAHAN (".$getSod[0]->KD_BRG." - ".$getSod[0]->NA_BRG.") BELUM ADA ; ";
                    }
                }
                else
                {
                    $hasilFo = $hasilFo ."FORMULA UNTUK BARANG (".$getSod[0]->KD_BRG." - ".$getSod[0]->NA_BRG.") BELUM ADA ; ";
                }
            }
        }
        else
        {
            $hasilFo = $hasilFo ."Tidak ada SO yang dipilih! ; ";
        }

        if($hasilFo!='')
        {
            return redirect('/so/multiSo')->with('status', 'Proses Multiple SO selesai..')->with('gagal', $hasilFo);
        }
        else
        {
            return redirect('/so/multiSo')->with('status', 'Proses Multiple SO selesai..');
        }
    }

    public function create()
    {
        return view('otransaksi_so.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'NO_BUKTI'       => 'required',
            'TGL'      => 'required',
            'KODEC'       => 'required'
        ]
        );

//////     nomer otomatis
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('so')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'SO')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'SO'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'SO'.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $so = So::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
				'FLAG'             => 'SO',	
				'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
				'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'            => ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'            => ($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],				
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'TOTAL'      	  => (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$KET	= $request->input('KET');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new SoDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'SO';
				$detail->KD_BRG	= $KD_BRG[$key];
				$detail->NA_BRG	= $NA_BRG[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->SISA	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];				
				$detail->save();
			}
		}

        return redirect('/so')->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(So $so)
    {

        $no_bukti = $so->NO_BUKTI;
        $soDetail = DB::table('sod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $so,
			'detail'		=> $soDetail
		];        
		
		return view('otransaksi_so.show', $data);
    }

    public function edit(So $so)
    {
        $no_bukti = $so->NO_BUKTI;
        $soDetail = DB::table('sod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $so,
			'detail'		=> $soDetail
		];        
		
		return view('otransaksi_so.edit', $data);
    }

    public function update(Request $request, So $so )
    {
		
        $this->validate($request,
        [
            'TGL'      => 'required',
            'KODEC'       => 'required'
        ]
        );
		
        $so->update(
            [
				'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
				'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
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
        $NO_ID	= $request->input('NO_ID');
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
        $query = DB::table('sod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = SoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $so->PER,
                        'FLAG'       => 'SO',							
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'      	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'SISA'        => (float) str_replace(',', '', $QTY[$i]),
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = SoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'KET'      	 => ($KET[$i]==null) ? "" : $KET[$i],
                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'SISA'        => (float) str_replace(',', '', $QTY[$i]),
                    ]
                );
            }
        }	   
/////////////////////////////////////////////////////////////////////////
 
        for ($i=0;$i<$length;$i++) {
            $upsert = SoDetail::updateOrCreate(
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
                    'KET'           => $KET[$i],
                ]
            );
        }

///////////////////////////////////////////////////////////////////////////
        return redirect('/so')->with('status', 'Data '.$request->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(So $so)
    {
        $deleteSo = So::find($so->NO_ID);
        $deleteSo->delete();
        DB::SELECT("DELETE from sod WHERE NO_BUKTI='$so->NO_BUKTI'");

        return redirect('/so')->with('status', 'Data '.$so->NO_BUKTI.' berhasil dihapus');
    }
}

