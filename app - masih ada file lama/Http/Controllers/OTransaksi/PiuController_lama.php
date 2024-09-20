<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Piu;
use App\Models\OTransaksi\PiuDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";

use PHPJasperXML;


// ganti 2
class PiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_piu.index');
    }

    // ganti 4

    public function getPiu(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $piu = DB::table('piu')->select('*')->where('PER', $periode)->where('GOL', 'Y')->orderBy('NO_BUKTI', 'ASC')->get();


        // ganti 6

        return Datatables::of($piu)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="piu/edit/' . $row->NO_ID . '" ';
                    //                         $btnDelete = ($row->POSTED==1) ? ' onclick= "alert(\'Transaksi '.$row->NO_BUKTI.' sudah diposting!\')" href="#" ' : ' href="piu/delete/'. $row->NO_ID .'" ' ;	
                    $btnDelete = '';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jasper-piu-trans/' . $row->NO_ID . '">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" ' . $btnDelete . '>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                } else {
                    $btnPrivilege = '';
                }

                $actionBtn =
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="piu/show/' . $row->NO_ID . '">
                            <i class="fas fa-eye"></i>
                                Lihat
                            </a>

                            ' . $btnPrivilege . '
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
        return view('otransaksi_piu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate(
            $request,
            // GANTI 9

            [
                'NO_SO'       => 'required',
                'TGL'         => 'required',
                'KODEC'       => 'required',
                'BACNO'       => 'required'

            ]
        );

        // Insert Header


        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('piu')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();

        // Check apakah No Bukti terakhir NULL
        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'PY' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'PY' . $tahun . $bulan . '-0001';
        }


        $typebayar = substr($request['BNAMA'],0,1);
		
		if ( $typebayar != 'K' )
        {
			
			$bulan	= session()->get('periode')['bulan'];
			$tahun	= substr(session()->get('periode')['tahun'],-2);
			$query2 = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBM')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
			if ($query2 != '[]')
			{
				$query2 = substr($query2[0]->NO_BUKTI, -4);
				$query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
				$no_bukti2 = 'BBM'.$tahun.$bulan.'-'.$query2;
			} else {
				$no_bukti2 = 'BBM'.$tahun.$bulan.'-0001';
			}
		}

		else 
        {
			
    		$bulan    = session()->get('periode')['bulan'];
            $tahun    = substr(session()->get('periode')['tahun'], -2);
            $query2 = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKM')->orderByDesc('NO_BUKTI')->limit(1)->get();

            if ($query2 != '[]') {
                $query2 = substr($query2[0]->NO_BUKTI, -4);
                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti2 = 'BKM' . $tahun . $bulan . '-' . $query2;
            } else {
                $no_bukti2 = 'BKM' . $tahun . $bulan . '-0001';
            }

        }

        // ganti 10

        $piu = Piu::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'BACNO'            => ($request['BACNO'] == null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA'] == null) ? "" : $request['BNAMA'],
                'NO_BANK'          => $no_bukti2,
                'FLAG'             => 'PY',
                'GOL'               => 'Y',
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'BAYAR'            => (float) str_replace(',', '', $request['TBAYAR']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );

        // Insert Detail
        $REC    = $request->input('REC');
        $NO_FAKTUR    = $request->input('NO_FAKTUR');
        $KET    = $request->input('KET');
        $TOTAL    = $request->input('TOTAL');
        $BAYAR    = $request->input('BAYAR');
        $SISA    = $request->input('SISA');

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new PiuDetail;

                // Insert ke Database
                $detail->NO_BUKTI = $no_bukti;
                $detail->REC    = $REC[$key];
                $detail->PER    = $periode;
                $detail->FLAG    = 'PY';
                $detail->GOL    = 'Y';
                $detail->KET    = ($KET[$key] == null) ? "" :  $KET[$key];
                $detail->NO_FAKTUR    = ($NO_FAKTUR[$key] == null) ? "" :  $NO_FAKTUR[$key];
                $detail->TOTAL    = (float) str_replace(',', '', $TOTAL[$key]);
                $detail->BAYAR    = (float) str_replace(',', '', $BAYAR[$key]);
                $detail->SISA    = (float) str_replace(',', '', $SISA[$key]);
                $detail->save();
            }
        }

        //  ganti 11
        $variablell = DB::select('call piuins(?,?)', array($no_bukti, $no_bukti2));

        return redirect('/piu')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12

    public function show(Piu $piu)
    {

        $no_bukti = $piu->NO_BUKTI;
        $piuDetail = DB::table('piud')->where('NO_BUKTI', $no_bukti)->get();
        $data = [
            'header'        => $piu,
            'detail'        => $piuDetail
        ];

        return view('otransaksi_piu.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

    public function edit(Piu $piu)
    {

        $no_bukti = $piu->NO_BUKTI;
        $piuDetail = DB::table('piud')->where('NO_BUKTI', $no_bukti)->get();
        $data = [
            'header'        => $piu,
            'detail'        => $piuDetail
        ];

        return view('otransaksi_piu.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Piu $piu)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'NO_SO'       => 'required',
                'TGL'         => 'required',
                'KODEC'       => 'required',
                'BACNO'       => 'required'
            ]
        );

        // ganti 20
        $variablell = DB::select('call piudel(?,?)', array($piu['NO_BUKTI'], '0'));

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $piu->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'                => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'BACNO'            => ($request['BACNO'] == null) ? "" : $request['BACNO'],
                'BNAMA'                => ($request['BNAMA'] == null) ? "" : $request['BNAMA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'BAYAR'            => (float) str_replace(',', '', $request['TBAYAR']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );


        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');
        $NO_FAKTUR    = $request->input('NO_FAKTUR');
        $TOTAL    = $request->input('TOTAL');
        $BAYAR    = $request->input('BAYAR');
        $SISA    = $request->input('SISA');
        $KET    = $request->input('KET');

        $query = DB::table('piud')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PiuDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => 'PY',
                        'GOL'        => 'Y',
                        'NO_FAKTUR'  => ($NO_FAKTUR[$i] == null) ? "" :  $NO_FAKTUR[$i],
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'BAYAR'      => (float) str_replace(',', '', $BAYAR[$i]),
                        'SISA'       => (float) str_replace(',', '', $SISA[$i]),
                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i]
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = PiuDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],
                        'NO_FAKTUR'  => ($NO_FAKTUR[$i] == null) ? "" :  $NO_FAKTUR[$i],
                        'KET'        => ($KET[$i] == null) ? "" : $KET[$i],
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'BAYAR'      => (float) str_replace(',', '', $BAYAR[$i]),
                        'SISA'       => (float) str_replace(',', '', $SISA[$i])
                    ]
                );
            }
        }

        //  ganti 21
        $variablell = DB::select('call piuins(?,?)', array($piu['NO_BUKTI'], 'X'));

        return redirect('/piu')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Piu $piu)
    {

        $variablell = DB::select('call piudel(?,?)', array($piu['NO_BUKTI'], '1'));

        // ganti 23
        $deletePiu = Piu::find($piu->NO_ID);

        // ganti 24

        $deletePiu->delete();

        // ganti 
        return redirect('/piu')->with('status', 'Data berhasil dihapus');
    }

    public function jasperPiuTrans(Piu $piu)
    {
        $no_bukti = $piu->NO_BUKTI;

        $file     = 'piun';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("
			SELECT PIU.NO_BUKTI, PIU.TGL, PIU.NO_SO, PIU.KODEC, PIU.NAMAC, PIUD.NO_FAKTUR, PIUD.TOTAL,    
			PIUD.BAYAR 
			FROM PIU, PIUD WHERE PIU.NO_BUKTI = PIUD.NO_BUKTI AND PIU.NO_BUKTI='$no_bukti'
			ORDER BY PIU.NO_BUKTI;
		");

        $data = [];
        foreach ($query as $key => $value) {
            array_push($data, array(
                'NO_BUKTI' => $query[$key]->NO_BUKTI,
                'TGL' => $query[$key]->TGL,
                'NO_SO' => $query[$key]->NO_SO,
                'KODEC' => $query[$key]->KODEC,
                'NAMAC' => $query[$key]->NAMAC,
                'NO_FAKTUR' => $query[$key]->NO_FAKTUR,
                'TOTAL' => $query[$key]->TOTAL,
                'BAYAR' => $query[$key]->BAYAR,
            ));
        }
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}
