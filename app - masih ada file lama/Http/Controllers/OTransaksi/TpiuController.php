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
class TpiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_tpiu.index');
    }

    // ganti 4

    public function getTpiu(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $tpiu = DB::table('jual')->select('*')->where('PER', $periode)->where('FLAG', 'TP')->where('GOL', 'Y')->orderBy('NO_BUKTI', 'ASC')->get();


        // ganti 6

        return Datatables::of($tpiu)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="tpiu/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="tpiu/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="tpiu/print/' . $row->NO_ID . '">
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
                            <a class="dropdown-item" href="tpiu/show/' . $row->NO_ID . '">
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
        return view('otransaksi_tpiu.create');
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

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('jual')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'TP')->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'TPY' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'TPY' . $tahun . $bulan . '-0001';
        }

        // ganti 10

        $tpiu = Jual::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'TOTAL1'            => (float) str_replace(',', '', $request['TOTAL']),
                'SISA'            => (float) str_replace(',', '', $request['TOTAL']),
                'FLAG'             => 'TP',
                'GOL'              => 'Y',
                'ACNOA'            => '113101',
                'NACNOA'           => 'PIUTANG USAHA ',
                'ACNOB'            => '711102',
                'NACNOB'           => 'PEND. / BIAYA LAIN2',
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()

            ]
        );


        // ganti 10


        //  ganti 11
        $variablell = DB::select('call tpiuins(?)', array($no_bukti));
        return redirect('/tpiu')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12

    public function show(Jual $tpiu)
    {

        // ganti 13

        $tpiuData = Jual::where('NO_ID', $tpiu->NO_ID)->first();

        // ganti 14
        return view('otransaksi_tpiu.show', $tpiuData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

    public function edit(Jual $tpiu)
    {

        // ganti 16

        $tpiuData = Jual::where('NO_ID', $tpiu->NO_ID)->first();

        // ganti 17 
        return view('otransaksi_tpiu.edit', $tpiuData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Jual $tpiu)
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
        $variablell = DB::select('call tpiudel(?)', array($tpiu['NO_BUKTI']));

        $tpiu->update(

            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'TOTAL1'            => (float) str_replace(',', '', $request['TOTAL']),
                'SISA'            => (float) str_replace(',', '', $request['TOTAL']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );


        //  ganti 21
        $variablell = DB::select('call tpiuins(?)', array($tpiu['NO_BUKTI']));

        return redirect('/tpiu')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Jual $tpiu)
    {

        $variablell = DB::select('call tpiudel(?)', array($tpiu['NO_BUKTI']));

        // ganti 23
        $deleteTpiu = Jual::find($tpiu->NO_ID);

        // ganti 24

        $deleteTpiu->delete();

        // ganti 
        return redirect('/tpiu')->with('status', 'Data berhasil dihapus');
    }
}
