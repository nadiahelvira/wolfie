<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;

use App\Models\Master\Fo;
use App\Models\Master\FoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class FoController extends Controller
{

    public function index(Request $request)
    {
        $jns = "FO";
        $judul="Barang Jadi";
        
        if (!empty($request->JNSFO))
        {
            $jns = $request->JNSFO;

            if ($jns=="FW")
            {
                $judul="Barang 1/2 Jadi";
            }
        }
        return view('master_fo.index', ['JNSFO'=>$jns, 'JUDUL'=>$judul]);
    }

    public function browse()
    {
		$fo = DB::table('fo')->select('KD_BRG', 'NA_BRG', 'NOTES')->where('GOL', 'Y')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($fo);
	}

	public function browses()
    {
		$fo = DB::table('fo')->select('KD_BRG', 'NA_BRG', 'NOTES')->where('GOL', 'S')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($fo);
	}
	
	public function browsen()
    {
		$fo = DB::table('fo')->select('KD_BRG', 'NA_BRG', 'NOTES')->where('GOL', 'Z')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($fo);
	}
	
	public function browseb()
    {
		$fo = DB::table('fo')->select('KD_BRG', 'NA_BRG', 'NOTES')->where('GOL', 'B')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($fo);
	}
	
    public function getFo(Request $request)
    {
        // $fo = Fo::query();
        $fo = DB::table('fo')->select('*')->where('FLAG', $request->JNSFO)->orderBy('NO_BUKTI', 'ASC')->get();
		
        return Datatables::of($fo)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $jns = !empty($request->JNSFO) ? $request->JNSFO : "FO";
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="fo/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="fo/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="fo/show/'. $row->NO_ID .'">
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

    public function create(Request $request)
    {
        $jns = "FO";
        $judul="Barang Jadi";
        
        if (!empty($request->JNSFO))
        {
            $jns = $request->JNSFO;

            if ($jns=="FW")
            {
                $judul="Barang 1/2 Jadi";
            }
        }

        return view('master_fo.create', ['JNSFO'=>$jns, 'JUDUL'=>$judul]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'NO_BUKTI'       => 'required'
            ]
        );
		
		//nomer otomatis
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);

        $flagbukti = "FO";
        if (!empty($request->JNSFO))
        {
            $flagbukti = $request->JNSFO;
        }
        
		$query = DB::table('fo')->select('NO_BUKTI')->where('FLAG', $flagbukti)->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = $flagbukti.'-'.$query;
        } else {
            $no_bukti = $flagbukti.'-0001';
        }
		
        // Insert Header
        $fo = Fo::create(
            [
                'NO_BUKTI'         => $no_bukti,
				'KD_BRG'           => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],	
                'NA_BRG'           => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],	
				'NOTES'            => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'AKTIF'        	   => ($request['AKTIF']==null) ? 0 : $request['AKTIF'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'FLAG'             => $flagbukti,
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$KD_PRS	= $request->input('KD_PRS');
		$NA_PRS	= $request->input('NA_PRS');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new FoDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->KD_PRS	= ($KD_PRS[$key]==null) ? "" :  $KD_PRS[$key];
				$detail->NA_PRS	= ($NA_PRS[$key]==null) ? "" :  $NA_PRS[$key];
				$detail->KD_BHN	= ($KD_BHN[$key]==null) ? "" :  $KD_BHN[$key];
				$detail->NA_BHN	= ($NA_BHN[$key]==null) ? "" :  $NA_BHN[$key];
				$detail->SATUAN	= ($SATUAN[$key]==null) ? "" :  $SATUAN[$key];
				$detail->QTY	= (float) str_replace(',', '', $QTY[$key]);
				$detail->KET	= $KET[$key];				
				$detail->save();
			}
		}

        return redirect('/fo?JNSFO='.$flagbukti)->with('status', 'Formula '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Fo $fo)
    {
        $judul = "Barang Jadi";
        if ($fo->FLAG=='FW')
        {
            $judul="Barang 1/2 Jadi";
        }
        
		$no_bukti = $fo->NO_BUKTI;
        $foDetail = DB::table('fod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $fo,
			'detail'		=> $foDetail
		];
		
		return view('master_fo.show', $data, ['JUDUL'=>$judul]);
    }

	public function edit(Fo $fo)
    {
        $judul = "Barang Jadi";
        if ($fo->FLAG=='FW')
        {
            $judul="Barang 1/2 Jadi";
        }
        
        
        $no_bukti = $fo->NO_BUKTI;
        $foDetail = DB::table('fod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $fo,
			'detail'		=> $foDetail
		];        

        return view('master_fo.edit', $data, ['JUDUL'=>$judul]);
    }

    public function update(Request $request, Fo $fo)
    {
        $this->validate($request,
            [
                'NO_BUKTI'       => 'required'
            ]
        );
		
        $fo->update(
            [
				'KD_BRG'            => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
				'NA_BRG'            => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'NOTES'             => ($request['NOTES']==null) ? "" : $request['NOTES'],
				'AKTIF'        		=> ($request['AKTIF']==null) ? 0 : $request['AKTIF'],				
                'TOTAL_QTY'         => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'USRNM'             => Auth::user()->username,
				'TG_SMP'            => Carbon::now(),
            ]
        );
		
		// Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');
		
        $REC	= $request->input('REC');
		$KD_PRS	= $request->input('KD_PRS');
		$NA_PRS	= $request->input('NA_PRS');
		$KD_BHN	= $request->input('KD_BHN');
		$NA_BHN	= $request->input('NA_BHN');
		$SATUAN	= $request->input('SATUAN');
		$QTY	= $request->input('QTY');
		$KET	= $request->input('KET');
		
       // Delete yang NO_ID tidak ada di input
        $query = DB::table('fod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = FoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
						'KD_PRS'     => ($KD_PRS[$i]==null) ? "" :  $KD_PRS[$i],
                        'NA_PRS'     => ($NA_PRS[$i]==null) ? "" : $NA_PRS[$i],
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],
						'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],						
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i]
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = FoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
						'KD_PRS'     => ($KD_PRS[$i]==null) ? "" :  $KD_PRS[$i],
                        'NA_PRS'     => ($NA_PRS[$i]==null) ? "" : $NA_PRS[$i],
                        'KD_BHN'     => ($KD_BHN[$i]==null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i]==null) ? "" : $NA_BHN[$i],
						'SATUAN'     => ($SATUAN[$i]==null) ? "" : $SATUAN[$i],
						'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						'KET'     	 => ($KET[$i]==null) ? "" : $KET[$i]
                    ]
                );
            }
        }	   
	   
        return redirect('/fo?JNSFO='.$fo->FLAG)->with('status', 'Formula '.$fo->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(Fo $fo)
    {
        Fo::find($fo->NO_ID)->delete();
        DB::SELECT("DELETE from fod WHERE NO_BUKTI='".$fo->NO_BUKTI."'");
        
        return redirect('/fo?JNSFO='.$fo->FLAG)->with('status', 'Formula '.$fo->NO_BUKTI.' berhasil dihapus');
    }
}
