<?php

namespace App\Http\Controllers\FTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\FTransaksi\Memo;
use App\Models\FTransaksi\MemoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;



include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;



// ganti 2
class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('ftransaksi_memo.index');
    }

// ganti 4

    public function getMemo(Request $request)
    {
// ganti 5

		 if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}

        //   $po = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'Y')->orderBy('NO_PO', 'ASC')->get();

           $memo = DB::table('memo')->select('*')->where('PER', $periode)->where('FLAG', 'M')->orderBy('NO_BUKTI', 'ASC')->get();

		
// ganti 6
		
        return Datatables::of($memo)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {

                        $btnEdit = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="memo/edit/'. $row->NO_ID .'" ' ;
                        $btnDelete = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="memo/delete/'. $row->NO_ID .'" '; 
 						
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" '.$btnEdit.'>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="memo/jasper-memo-trans/'. $row->NO_ID .'">
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
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="memo/show/'. $row->NO_ID .'">
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
        return view('ftransaksi_memo.create');
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
                'NO_BUKTI'       => 'required',
                'TGL'      => 'required'

            ]
        );

        
		$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('memo')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'M')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'M'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'M'.$tahun.$bulan.'-0001';
        }


        // Insert Header

// ganti 10

        $memo = Memo::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
				'KET'              =>($request['KET']==null) ? "" : $request['KET'],
				'FLAG'             => 'M',	
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),
                'DEBET'            => (float) str_replace(',', '', $request['TJUMLAH']),
                'KREDIT'           => (float) str_replace(',', '', $request['TJUMLAH']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$ACNO	= $request->input('ACNO');
		$NACNO	= $request->input('NACNO');
		$ACNOB	= $request->input('ACNOB');
		$NACNOB	= $request->input('NACNOB');
		$DEBET	= $request->input('DEBET');
		$KREDIT	= $request->input('KREDIT');
		$URAIAN	= $request->input('URAIAN');
		$JUMLAH	= $request->input('JUMLAH');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new MemoDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'M';
				$detail->ACNO	= $ACNO[$key];
				$detail->NACNO	= $NACNO[$key];
				$detail->ACNOB	= $ACNOB[$key];
				$detail->NACNOB	= $NACNOB[$key];
				$detail->URAIAN	= $URAIAN[$key];
				$detail->JUMLAH	= (float) str_replace(',', '', $JUMLAH[$key]);
				$detail->DEBET	= (float) str_replace(',', '', $JUMLAH[$key]);				
				$detail->KREDIT	= (float) str_replace(',', '', $JUMLAH[$key]);
				$detail->save();
			}
		}

//  ganti 11
		$variablell = DB::select('call memoins(?)',array($no_bukti));
		
		
        return redirect('/memo')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
     public function show(Memo $memo)
    {

        $no_bukti = $memo->NO_BUKTI;
        $memoDetail = DB::table('memod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $memo,
			'detail'		=> $memoDetail
		];        
		
		return view('ftransaksi_memo.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Memo $memo)
    {

        $no_bukti = $memo->NO_BUKTI;
        $memoDetail = DB::table('memod')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $memo,
			'detail'		=> $memoDetail
		];        
		
		return view('ftransaksi_memo.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Memo $memo )
    {
		
        $this->validate($request,
        [
		
// ganti 10
		
                'TGL'      => 'required'
            ]
        );
		
// ganti 20
		$variablell = DB::select('call memodel(?)',array($memo['NO_BUKTI']));

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
	
	
        $memo->update(
            [

                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),
                'DEBET'            => (float) str_replace(',', '', $request['TJUMLAH']),
                'KREDIT'           => (float) str_replace(',', '', $request['TJUMLAH']),
				'KET'              => ($request['KET']==null) ? "" : $request['KET'],				
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );


        // Update Detail
        $length = sizeof($request->input('REC'));
		$NO_ID  = $request->input('NO_ID');
        
		$REC    = $request->input('REC');
        $ACNO   = $request->input('ACNO');
        $NACNO  = $request->input('NACNO');
        $ACNOB   = $request->input('ACNOB');
        $NACNOB  = $request->input('NACNOB');
        $URAIAN = $request->input('URAIAN');
        $JUMLAH = $request->input('JUMLAH');
		
		
            // Delete yang NO_ID tidak ada di input       
		$query = DB::table('memod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = MemoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'M',	 							
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'ACNOB'      => ($ACNOB[$i]==null) ? "" :  $ACNOB[$i],
                        'NACNOB'     => ($NACNOB[$i]==null) ? "" : $NACNOB[$i],	
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = MemoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])	
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'ACNOB'       => ($ACNOB[$i]==null) ? "" :  $ACNOB[$i],
                        'NACNOB'      => ($NACNOB[$i]==null) ? "" : $NACNOB[$i],
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            }
        }



//  ganti 21
		$variablell = DB::select('call memoins(?)',array($memo['NO_BUKTI']));
        return redirect('/memo')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Memo $memo)
    {

		$variablell = DB::select('call memodel(?)',array($memo['NO_BUKTI']));
     
		
// ganti 23
        $deleteMemo = Memo::find($memo->NO_ID);

// ganti 24

        $deleteMemo->delete();

// ganti 
        return redirect('/memo')->with('status', 'Data berhasil dihapus');
		
		
    }
	
	public function jasperMemoTrans(Memo $memo)
    {
        $no_bukti = $memo->NO_BUKTI;
        
		$file 	= 'memoc';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		$query = DB::SELECT("
			SELECT memo.NO_BUKTI,memo.TGL,memo.KET,memo.BNAMA,
            memod.REC,memod.ACNO,memod.NACNO,memod.URAIAN,if(memod.DEBET>=0,memod.DEBET,memod.KREDIT) as JUMLAH 
			FROM memo, memod 
			WHERE memo.NO_BUKTI=memod.NO_BUKTI and memo.NO_BUKTI='$no_bukti' 
			ORDER BY memo.NO_BUKTI;
		");

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KET' => $query[$key]->KET,
				'BNAMA' => $query[$key]->BNAMA,
				'REC' => $query[$key]->REC,
				'ACNO' => $query[$key]->ACNO,
				'NACNO' => $query[$key]->NACNO,
				'URAIAN' => $query[$key]->URAIAN,
				'JUMLAH' => $query[$key]->JUMLAH,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
    }	

	
}
