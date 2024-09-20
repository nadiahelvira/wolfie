<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Terima;
use App\Models\OTransaksi\TerimaDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class TerimaController extends Controller
{
    public function index(Request $request)
    {
        $jns = "HP";
        $judul="";
        
        if (!empty($request->JNSHP))
        {
            $jns = $request->JNSHP;

            if ($jns=="HW")
            {
                $judul="WIP";
            }
        }
        return view('otransaksi_terima.index', ['JNSHP'=>$jns, 'JUDUL'=>$judul]);
    }

    public function browsePakai(Request $request)
    {
        $flag = "PK";

        if($request->flag=="HW")
        {
            $flag = "PW";
        }
		$pakai = DB::SELECT("SELECT KODEC, NAMAC, NO_BUKTI, NO_ORDER, NO_SO, NO_FO, KD_PRS, NA_PRS, NO_PRS, KD_BRG, NA_BRG, KD_BHN, NA_BHN, QTY_OUT, SATUAN, NOTES 
        from pakai 
        WHERE FLAG='".$flag."' AND KD_PRS in (SELECT KD_PRS from fod2 WHERE AKHIR=1);");
		return response()->json($pakai);
	}

    public function browsePakaid(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
		$pakaid = DB::SELECT("SELECT KD_BHN, NA_BHN, SATUAN, sum(QTY) as QTY, KET 
        from pakaid 
        WHERE NO_BUKTI in (SELECT NO_BUKTI from pakai WHERE NO_ORDER='".$request->no_orderk."') 
        GROUP BY KD_BHN
        ORDER BY KD_BHN;");
		return response()->json($pakaid);
	}

    public function getTerima(Request $request)
    {
		if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}

        $terima = DB::table('terima')->select('*')->where('PER', $periode)->where('FLAG', $request->JNSHP)->orderBy('NO_BUKTI', 'ASC')->get();
		   	 	 
        return Datatables::of($terima)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="terima/edit/' . $row->NO_ID . '" ';
                        $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="terima/delete/' . $row->NO_ID . '" ';

                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="terima/print/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="terima/show/'. $row->NO_ID .'">
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
        $jns = "HP";
        $judul="";
        
        if (!empty($request->JNSHP))
        {
            $jns = $request->JNSHP;

            if ($jns=="HW")
            {
                $judul="WIP";
            }
        }

        return view('otransaksi_terima.create', ['JNSHP'=>$jns, 'JUDUL'=>$judul]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'NO_BUKTI' => 'required',
            'TGL'      => 'required',
            'NO_PAKAI' => 'required',
            'NO_SO'    => 'required',
            'NO_FO'    => 'required',
            'NO_OK'    => 'required',
        ]
        );

		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
        
        $flagbukti = "HP";
        if (!empty($request->JNSHP))
        {
            $flagbukti = $request->JNSHP;
        }

		$query = DB::table('terima')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $flagbukti)->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = $flagbukti.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = $flagbukti.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $terima = Terima::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
				'FLAG'             => $flagbukti,
                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
                'NO_PAKAI'         => ($request['NO_PAKAI']==null) ? "" : $request['NO_PAKAI'],
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_BHN'          => ($flagbukti=="HW") ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'QTY'              => ($flagbukti=="HP") ? (float) str_replace(',', '', $request['QTYH']) : 0,
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
				'FIN'              => ($request['FIN']==null) ? "0" : $request['FIN'],
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
				$detail	= new TerimaDetail;
				$idTerima = DB::table('terima')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;	
				$detail->KD_BHN	= $KD_BHN[$key];
				$detail->NA_BHN	= $NA_BHN[$key];	
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];	
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];
				$detail->REC	= $REC[$key];
				$detail->ID	    = $idTerima[0]->NO_ID;
				$detail->PER	= $periode;
				$detail->FLAG	= $flagbukti;
				$detail->save();
			}
		}

        if($request['FIN'])
        {
            DB::SELECT("UPDATE orderk set FIN=".$request['FIN']." WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        else
        {
            DB::SELECT("UPDATE orderk set FIN=0 WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        DB::SELECT("UPDATE terima a, pakai b set a.ID_SOD=b.ID_SOD WHERE a.NO_PAKAI=b.NO_BUKTI and a.NO_BUKTI='$no_bukti'");
        DB::SELECT("CALL terimains('$no_bukti')");
        return redirect('/terima?JNSHP='.$flagbukti)->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Terima $terima)
    {
        $judul = "";
        if ($terima->FLAG=='HW')
        {
            $judul="WIP";
        }

        $no_bukti = $terima->NO_BUKTI;
        $terimaDetail = DB::table('terimad')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $terima,
			'detail'		=> $terimaDetail
		];        
		
		return view('otransaksi_terima.show', $data, ['JUDUL'=>$judul]);
    }

    public function edit(Terima $terima)
    {
        $judul = "";
        if ($terima->FLAG=='HW')
        {
            $judul="WIP";
        }

        $no_bukti = $terima->NO_BUKTI;
        $terimaDetail = DB::table('terimad')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $terima,
			'detail'		=> $terimaDetail
		];        
		
		return view('otransaksi_terima.edit', $data, ['JUDUL'=>$judul]);
    }

    public function update(Request $request, Terima $terima )
    {
		
        $this->validate($request,
        [
            'NO_BUKTI' => 'required',
            'TGL'      => 'required',
            'NO_PAKAI' => 'required',
            'NO_SO'    => 'required',
            'NO_FO'    => 'required',
            'NO_OK'    => 'required',
        ]
        );
	
        DB::SELECT("CALL terimadel('$terima->NO_BUKTI')");

        $terima->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),	
                'KODEC'            => ($request['KODEC']==null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
                'NO_PAKAI'         => ($request['NO_PAKAI']==null) ? "" : $request['NO_PAKAI'],
                'NO_ORDER'         => ($request['NO_OK']==null) ? "" : $request['NO_OK'],
                'NO_SO'            => ($request['NO_SO']==null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'KD_BHN'           => ($request['KD_BHN_H']==null) ? "" : $request['KD_BHN_H'],
                'NA_BHN'           => ($request['NA_BHN_H']==null) ? "" : $request['NA_BHN_H'],
                'QTY_BHN'          => $terima->FLAG=="HW" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'QTY'              => $terima->FLAG=="HP" ? (float) str_replace(',', '', $request['QTYH']) : 0,
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'SATUAN'           => ($request['SATUANH']==null) ? "" : $request['SATUANH'],
                'NO_FO'            => ($request['NO_FO']==null) ? "" : $request['NO_FO'],
                'KD_PRS'            => ($request['KD_PRSH']==null) ? "" : $request['KD_PRSH'],			
                'NA_PRS'            => ($request['NA_PRSH']==null) ? "" : $request['NA_PRSH'],
				'NO_PRS'           => ($request['NO_PRS']==null) ? "" : $request['NO_PRS'],
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'USRNM'            => Auth::user()->username,	
				'TG_SMP'           => Carbon::now(),
				'FIN'              => ($request['FIN']==null) ? "0" : $request['FIN'],
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
		$KET	= $request->input('KET');	
       
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('terimad')->where('NO_BUKTI', $terima->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = TerimaDetail::create(
                    [
                        'NO_BUKTI'   => $terima->NO_BUKTI,				
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                        'ID'         => $terima->NO_ID,
				        'PER'        => $terima->PER,
                        'FLAG'       => $terima->FLAG,	
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = TerimaDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $terima->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [				
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'REC'        => $REC[$i],
                    ]
                );
            }
        }	   

        if($request['FIN'])
        {
            DB::SELECT("UPDATE orderk set FIN=".$request['FIN']." WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        else
        {
            DB::SELECT("UPDATE orderk set FIN=0 WHERE NO_BUKTI='".$request['NO_OK']."'");
        }
        DB::SELECT("UPDATE terima a, pakai b set a.ID_SOD=b.ID_SOD WHERE a.NO_PAKAI=b.NO_BUKTI and a.NO_BUKTI='".$terima->NO_BUKTI."'");
        DB::SELECT("CALL terimains('$terima->NO_BUKTI')");
        return redirect('/terima?JNSHP='.$terima->FLAG)->with('status', 'Data '.$request->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(Terima $terima)
    {
        DB::SELECT("CALL terimadel('$terima->NO_BUKTI')");
        Terima::find($terima->NO_ID)->delete();
        DB::SELECT("DELETE from terimad WHERE NO_BUKTI='$terima->NO_BUKTI'");

        return redirect('/terima?JNSHP='.$terima->FLAG)->with('status', 'Data '.$terima->NO_BUKTI.' berhasil dihapus');
    }
}

