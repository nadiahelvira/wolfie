<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Surats;
use App\Models\OTransaksi\SuratsDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class SuratsController extends Controller
{
    public function index()
    {
        return view('otransaksi_surats.index');
    }

    public function browseCust(Request $request)
    {
		$so = DB::SELECT("SELECT KODEC,NAMAC,ALAMAT,KOTA from cust where AKT ='1' order by KODEC");
		return response()->json($so);
	}

    public function browseSo(Request $request)
    {
		$so = DB::SELECT("SELECT sod.NO_ID, so.NO_BUKTI, so.TGL, so.NAMAC, sod.KD_BRG, sod.NA_BRG, sod.SATUAN, sod.QTY, SOD.KIRIM, sod.HARGA,
                  SOD.SISA from so, sod 
        WHERE so.NO_BUKTI=sod.NO_BUKTI and sod.SISA>0 and so.KODEC='".$request->kodec."' ");
		return response()->json($so);
	}

    public function getSurats(Request $request)
    {
	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
			
        $surats = DB::table('surats')->select('*')->where('PER', $periode)->where('FLAG', 'SJ' )->orderBy('NO_BUKTI', 'ASC')->get();
			 	 
        return Datatables::of($surats)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="surats/edit/' . $row->NO_ID . '" ';
                        $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="surats/delete/' . $row->NO_ID . '" ';

                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="surats/print/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="surats/show/'. $row->NO_ID .'">
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
        return view('otransaksi_surats.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'NO_BUKTI'   => 'required',
                'TGL'        => 'required',
                'KODEC'      => 'required',
                'TRUCK'     => 'required',
                'SOPIR'     => 'required',
            ]
        );

	    // Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('surats')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'SJ')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'SJ'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'SJ'.$tahun.$bulan.'-0001';
        }

        // Insert Header
        $surats = Surats::create(
            [
				'NO_BUKTI'      => $no_bukti,
                'TGL'           => date('Y-m-d', strtotime($request['TGL'])),	
                'PER'           => $periode,			
                'FLAG'          => 'SJ',		
                'TRUCK'         => ($request['TRUCK']==null) ? "" : $request['TRUCK'],
                'SOPIR'         => ($request['SOPIR']==null) ? "" : $request['SOPIR'],
                'VIA'           => ($request['VIA']==null) ? "" : $request['VIA'],
                'KODEC'         => ($request['KODEC']==null) ? "" : $request['KODEC'],	
				'NAMAC'		    =>($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'		=>($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'		    =>($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'			=>($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'     => (float) str_replace(',', '', $request['TQTY']),
                'TOTAL'      	=> (float) str_replace(',', '', $request['TTOTAL']),
				'USRNM'         => Auth::user()->username,
				'TG_SMP'        => Carbon::now(),
            ]
        );

		// Insert Detail
		$REC	= $request->input('REC');
		$NO_SO	= $request->input('NO_SO');
		$TYP	= $request->input('TYP');
		$NO_TERIMA = $request->input('NO_TERIMA');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$MERK	= $request->input('MERK');	
		$NO_SERI = $request->input('NO_SERI');	
		$KET	= $request->input('KET');	
		$ID_SOD	= $request->input('ID_SOD');		

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new SuratsDetail;
				$idSurats = DB::table('surats')->select('NO_ID')->where('NO_BUKTI', $no_bukti)->get();
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;	
				$detail->NO_SO	= $NO_SO[$key];
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'SJ';
				$detail->TYP	= ($TYP[$key]==null) ? '' : $TYP[$key];
				$detail->NO_TERIMA	= ($NO_TERIMA[$key]==null) ? '' : $NO_TERIMA[$key];
				$detail->KD_BRG	= ($KD_BRG[$key]==null) ? '' : $KD_BRG[$key];
				$detail->NA_BRG	= ($NA_BRG[$key]==null) ? '' : $NA_BRG[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? '' : $SATUAN[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->SISA	= (float) str_replace(',', '', $QTY[$key]);
				$detail->HARGA	= (float) str_replace(',', '', $HARGA[$key]);
				$detail->TOTAL	= (float) str_replace(',', '', $TOTAL[$key]);
				$detail->MERK	= ($MERK[$key]==null) ? '' : $MERK[$key];
				$detail->NO_SERI	= ($NO_SERI[$key]==null) ? '' : $NO_SERI[$key];
				$detail->KET	= ($KET[$key]==null) ? '' : $KET[$key];
				$detail->ID	    = $idSurats[0]->NO_ID;
				$detail->ID_SOD	= ($ID_SOD[$key]==null) ? '' : $ID_SOD[$key];
				$detail->save();
			}
		}
        DB::SELECT("CALL suratsins('$no_bukti')");

        return redirect('/surats')->with('status', 'Data baru '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Surats $surats)
    {
        $no_bukti = $surats->NO_BUKTI;
        $suratsDetail = DB::table('suratsd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $surats,
			'detail'		=> $suratsDetail
		];        
        return view('otransaksi_surats.show', $data);
    }

    public function edit(Surats $surats)
    {
        $no_bukti = $surats->NO_BUKTI;
        $suratsDetail = DB::table('suratsd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $surats,
			'detail'		=> $suratsDetail
		];        
        return view('otransaksi_surats.edit', $data);
    }

    public function update(Request $request, Surats $surats )
    {
        $this->validate($request,
            [
                'NO_BUKTI'   => 'required',
                'TGL'        => 'required',
                'KODEC'      => 'required',
                'TRUCK'     => 'required',
                'SOPIR'     => 'required',
            ]
        );
		
        DB::SELECT("CALL suratsdel('$surats->NO_BUKTI')");

        $surats->update(
            [
                'TGL'           => date('Y-m-d', strtotime($request['TGL'])),	
                'TRUCK'         => ($request['TRUCK']==null) ? "" : $request['TRUCK'],
                'SOPIR'         => ($request['SOPIR']==null) ? "" : $request['SOPIR'],
                'VIA'           => ($request['VIA']==null) ? "" : $request['VIA'],
                'KODEC'         => ($request['KODEC']==null) ? "" : $request['KODEC'],	
				'NAMAC'		    =>($request['NAMAC']==null) ? "" : $request['NAMAC'],
				'ALAMAT'		=>($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
				'KOTA'		    =>($request['KOTA']==null) ? "" : $request['KOTA'],
				'NOTES'			=>($request['NOTES']==null) ? "" : $request['NOTES'],
                'TOTAL_QTY'     => (float) str_replace(',', '', $request['TQTY']),
                'TOTAL'      	=> (float) str_replace(',', '', $request['TTOTAL']),
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
		$NO_TERIMA = $request->input('NO_TERIMA');
		$KD_BRG	= $request->input('KD_BRG');
		$NA_BRG	= $request->input('NA_BRG');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$HARGA	= $request->input('HARGA');
		$TOTAL	= $request->input('TOTAL');
		$MERK	= $request->input('MERK');	
		$NO_SERI = $request->input('NO_SERI');	
		$KET	= $request->input('KET');	
		$ID_SOD	= $request->input('ID_SOD');	
       
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('suratsd')->where('NO_BUKTI', $surats->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = SuratsDetail::create(
                    [
                        'NO_BUKTI'   => $surats->NO_BUKTI,
                        'NO_SO'      => ($NO_SO[$i]==null) ? "" :  $NO_SO[$i],
                        'REC'        => $REC[$i],
				        'PER'        => $surats->PER,	
				        'FLAG'       => 'SJ',					
                        'TYP'        => ($TYP[$i]==null) ? "" :  $TYP[$i],
                        'NO_TERIMA'  => ($NO_TERIMA[$i]==null) ? "" :  $NO_TERIMA[$i],	
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'      	 => (float) str_replace(',', '', $QTY[$i]),
						'SISA'       => (float) str_replace(',', '', $QTY[$i]),
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'MERK'       => ($MERK[$i]==null) ? "" : $MERK[$i],
                        'NO_SERI'    => ($NO_SERI[$i]==null) ? "" : $NO_SERI[$i],
                        'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'ID'         => $surats->NO_ID,
                        'ID_SOD'     => ($ID_SOD[$i]==null) ? "" : $ID_SOD[$i],
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = SuratsDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $surats->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'NO_SO'      => ($NO_SO[$i]==null) ? "" :  $NO_SO[$i],
                        'REC'        => $REC[$i],		
                        'TYP'        => ($TYP[$i]==null) ? "" :  $TYP[$i],
                        'NO_TERIMA'  => ($NO_TERIMA[$i]==null) ? "" :  $NO_TERIMA[$i],	
                        'KD_BRG'     => ($KD_BRG[$i]==null) ? "" :  $KD_BRG[$i],
                        'NA_BRG'     => ($NA_BRG[$i]==null) ? "" : $NA_BRG[$i],	
                        'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'      	 => (float) str_replace(',', '', $QTY[$i]),
						'SISA'       => (float) str_replace(',', '', $QTY[$i]),
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'MERK'       => ($MERK[$i]==null) ? "" : $MERK[$i],
                        'NO_SERI'    => ($NO_SERI[$i]==null) ? "" : $NO_SERI[$i],
                        'KET'        => ($KET[$i]==null) ? "" : $KET[$i],
                        'ID_SOD'     => ($ID_SOD[$i]==null) ? "" : $ID_SOD[$i],
                    ]
                );
            }
        }	   
	   
        DB::SELECT("CALL suratsins('$surats->NO_BUKTI')");
        return redirect('/surats')->with('status', 'Data '.$request->NO_BUKTI.' berhasil diubah');
    }

    public function destroy(Surats $surats)
    {
        DB::SELECT("CALL suratsdel('$surats->NO_BUKTI')");
        Surats::find($surats->NO_ID)->delete();
        DB::SELECT("DELETE from suratsd WHERE NO_BUKTI='$surats->NO_BUKTI'");

        return redirect('/surats')->with('status', 'Data '.$surats->NO_BUKTI.' berhasil dihapus');
    }
}
