<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Jual;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class UjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_uj.index');
    }

    // ganti 4

    public function getUj(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        //           $thut = DB::table('beli')->select('*')->where('PER', $periode)->where('FLAG', 'TH')->orderBy('NO_BUKTI', 'ASC')->get();

        $uj = DB::table('jual')->select('*')->where('PER', $periode)->where('FLAG', 'UJ')->where('GOL', 'Y')->orderBy('NO_BUKTI', 'ASC')->get();


        // ganti 6

        return Datatables::of($uj)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="uj/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="uj/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="uj/print/' . $row->NO_ID . '">
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
                            <a class="dropdown-item" href="uj/show/' . $row->NO_ID . '">
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
        return view('otransaksi_uj.create');
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
                'NO_BUKTI'       => 'required',
                'TGL'      => 'required',
                'KODEC'       => 'required'

            ]
        );

        // Insert Header

        // ganti 10

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('jual')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'UJ')->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'UJY' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'UJY' . $tahun . $bulan . '-0001';
        }


        $typebayar = substr($request['BNAMA'],0,1);

		
		if ( $typebayar != 'K' )
        {
			
			$bulan    = session()->get('periode')['bulan'];
			$tahun    = substr(session()->get('periode')['tahun'], -2);
			$query = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBM')->orderByDesc('NO_BUKTI')->limit(1)->get();

			if ($query != '[]') {
				$query = substr($query[0]->NO_BUKTI, -4);
				$query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
				$no_bukti2 = 'BBM' . $tahun . $bulan . '-' . $query;
			} else {
				$no_bukti2 = 'BBM' . $tahun . $bulan . '-0001';
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

        $uj = Jual::create(
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
                'FLAG'             => 'UJ',
                'GOL'               => 'Y',
                'ACNOB'            => '116103',
                'NACNOB'           => 'UANG MUKA PEMBELIAN NON',
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL1'           => (float) str_replace(',', '', $request['TOTAL1']),
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'SISA'             => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'GOL'              => 'Y',
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()

            ]
        );
        //  ganti 11
        $variablell = DB::select('call ujins(?,?)', array($no_bukti, $no_bukti2));

        return redirect('/uj')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12

    public function show(Jual $uj)
    {

        // ganti 13

        $ujData = Jual::where('NO_ID', $uj->NO_ID)->first();

        // ganti 14
        return view('otransaksi_uj.show', $ujData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

    public function edit(Jual $uj)
    {

        // ganti 16

        $ujData = Jual::where('NO_ID', $uj->NO_ID)->first();

        // ganti 17 
        return view('otransaksi_uj.edit', $ujData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Jual $uj)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'TGL'      => 'required',
                'KODEC'       => 'required'
            ]
        );

        // ganti 20
        $variablell = DB::select('call ujdel(?,?)', array($uj['NO_BUKTI'], '0'));


        $uj->update(

            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL1'           => (float) str_replace(',', '', $request['TOTAL1']),
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'SISA'             => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );


        //  ganti 21
        $variablell = DB::select('call ujins(?,?)', array($uj['NO_BUKTI'], 'X'));

        return redirect('/uj')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Jual $uj)
    {

        $variablell = DB::select('call ujdel(?,?)', array($uj['NO_BUKTI'], '1'));



        // ganti 23
        $deleteUj = Jual::find($uj->NO_ID);

        // ganti 24

        $deleteUj->delete();

        // ganti 
        return redirect('/uj')->with('status', 'Data berhasil dihapus');
    }
}
