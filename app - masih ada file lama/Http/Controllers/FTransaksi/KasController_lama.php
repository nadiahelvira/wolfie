<?php

namespace App\Http\Controllers\FTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\FTransaksi\Kas;
use App\Models\FTransaksi\KasDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;


include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";

use PHPJasperXML;




// ganti 2
class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('ftransaksi_kas.index');
    }

// ganti 4

    public function getKas(Request $request)
    {
// ganti 5

		if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}

           $kas = DB::table('kas')->select('*')->where('PER', $periode)->where('TYPE', 'BKM')->orderBy('NO_BUKTI', 'ASC')->get();
	 	 
		
// ganti 6
		
        return Datatables::of($kas)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                    	// CEK  SUDAH POSTED di INDEX dan EDIT
						// <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="kas/delete/'. $row->NO_ID .'">
                        $btnEdit = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="kas/edit/'. $row->NO_ID .'" ' ;
                        $btnDelete = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="kas/delete/'. $row->NO_ID .'" ' ;
                        
                        $btnPrivilege = 
                        '								
                                <a class="dropdown-item" '.$btnEdit.'>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="kas/jasper-kas-trans/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="kas/show/'. $row->NO_ID .'">
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
        return view('ftransaksi_kas.create');
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
                'NO_BUKTI'     => 'required',
                'TGL'          => 'required',
                'BACNO'        => 'required'

        ]
      );

        //////     nomer otomatis

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKM')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
        // Check apakah No Bukti terakhir NULL
        if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'BKM'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'BKM'.$tahun.$bulan.'-0001';
        }
		



        // Insert Header

        // ganti 10

        $kas = Kas::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],			
                'BNAMA'            => ($request['BNAMA']==null) ? "" : $request['BNAMA'],
				'FLAG'             => 'K',
                'TYPE'		       => 'BKM',	
				'KET'              => ($request['KET']==null) ? "" : $request['KET'],
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
				
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$ACNO	= $request->input('ACNO');
		$NACNO	= $request->input('NACNO');
		$URAIAN	= $request->input('URAIAN');
		$JUMLAH	= $request->input('JUMLAH');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new KasDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'K';
				$detail->TYPE	= 'BKM';
				$detail->ACNO	= $ACNO[$key];
				$detail->NACNO	= $NACNO[$key];
				$detail->URAIAN	= $URAIAN[$key];
				$detail->JUMLAH	= (float) str_replace(',', '', $JUMLAH[$key]);
				$detail->DEBET	= (float) str_replace(',', '', $JUMLAH[$key]);				
				$detail->save();
			}
		}

 //  ganti 11
		$variablell = DB::select('call kasins(?)',array($no_bukti));
		
        return redirect('/kas')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	
    public function show(Kas $kas)
    {

        $no_bukti = $kas->NO_BUKTI;
        $kasDetail = DB::table('kasd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $kas,
			'detail'		=> $kasDetail
		];        
		
		return view('ftransaksi_kas.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Kas $kas)
    {

        $no_bukti = $kas->NO_BUKTI;
        $kasDetail = DB::table('kasd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $kas,
			'detail'		=> $kasDetail
		];        
	
        //CEK  SUDAH POSTED di INDEX dan EDIT	
		if($kas->POSTED==1)
        {
            return redirect('/kas')->with('status', 'Data '.$kas->NO_BUKTI.' sudah terposting');
        }
        else
        {
		return view('ftransaksi_kas.edit', $data);
        }
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Kas $kas )
    {		
        // return $request;
        $this->validate($request,
            [
            // ganti 19
                'TGL'       => 'required',
                'BACNO'     => 'required'
            ]
        );
		
        // ganti 20
		$variablell = DB::select('call kasdel(?)',array($kas['NO_BUKTI']));
     
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
	
	
        $kas->update(
            [

                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA']==null) ? "" : $request['BNAMA'],
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),	
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
        $query = DB::table('kasd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = KasDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'K',	
                        'TYPE'       => 'BKM',  							
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = KasDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            }
        }

        // ganti 21
		$variablell = DB::select('call kasins(?)',array($kas['NO_BUKTI']));
		
        return redirect('/kas')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Kas $kas)
    {
        // Delete Detail
 //       $no_bukti       = $kas->NO_BUKTI;
 //       $deleteDetail   = DB::table('kasd')->where('NO_BUKTI', $no_bukti)->delete();
	
		$variablell = DB::select('call kasdel(?)',array($kas['NO_BUKTI']));
        
        // ganti 23
        $deleteKas = Kas::find($kas->NO_ID);

        // ganti 24
        $deleteKas->delete();

        // ganti 
        return redirect('/kas')->with('status', 'Data berhasil dihapus');
		
		
    }
    
    
     public function jasperKasTrans(Kas $kas)
    {
        $no_bukti = $kas->NO_BUKTI;
        
		$file 	= 'kasc';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		$query = DB::SELECT("
			SELECT kas.NO_BUKTI,kas.TGL,kas.KET,kas.BNAMA,
            kasd.REC,kasd.ACNO,kasd.NACNO,kasd.URAIAN,if(kasd.DEBET>=0,kasd.DEBET,kasd.KREDIT) as JUMLAH 
			FROM kas, kasd 
			WHERE kas.NO_BUKTI=kasd.NO_BUKTI and kas.NO_BUKTI='$no_bukti' 
			ORDER BY kas.NO_BUKTI;
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
    
    
