<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Beli;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class ThutnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_thutn.index');
    }

    // ganti 4

    public function getThutn(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }


        $thutn = DB::table('beli')->select('*')->where('PER', $periode)->where('FLAG', 'TH')->where('GOL', 'Z')->orderBy('NO_BUKTI', 'ASC')->get();


        // ganti 6

        return Datatables::of($thutn)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="thutn/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="thutn/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="thutn/print/' . $row->NO_ID . '">
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
                            <a class="dropdown-item" href="thutn/show/' . $row->NO_ID . '">
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
        return view('otransaksi_thutn.create');
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
                'KODES'       => 'required'

            ]
        );

        // Insert Header

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('beli')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'TH')->where('GOL', 'Z')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'THZ' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'THZ' . $tahun . $bulan . '-0001';
        }

        // ganti 10

        $thutn = Beli::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'TOTAL1'            => (float) str_replace(',', '', $request['TOTAL']),
                'SISA'            => (float) str_replace(',', '', $request['TOTAL']),
                'FLAG'             => 'TH',
                'GOL'              => 'Z',
                'ACNOA'            => '711102',
                'NACNOA'           => 'PEND. / BIAYA LAIN2  ',
                'ACNOB'            => '211103',
                'NACNOB'           => 'HUTANG NON',
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()

            ]
        );

        //  ganti 11
        $variablell = DB::select('call thutins(?)', array($no_bukti));

        return redirect('/thutn')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12

    public function show(Beli $thutn)
    {

        // ganti 13

        $thutnData = Beli::where('NO_ID', $thutn->NO_ID)->first();

        // ganti 14
        return view('otransaksi_thutn.show', $thutnData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

    public function edit(Beli $thutn)
    {

        // ganti 16

        $thutnData = Beli::where('NO_ID', $thutn->NO_ID)->first();

        // ganti 17 
        return view('otransaksi_thutn.edit', $thutnData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Beli $thutn)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'TGL'      => 'required',
                'KODES'       => 'required'
            ]
        );

        // ganti 20
        $variablell = DB::select('call thutdel(?)', array($thutn['NO_BUKTI']));



        $thutn->update(

            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'TOTAL1'            => (float) str_replace(',', '', $request['TOTAL']),
                'SISA'            => (float) str_replace(',', '', $request['TOTAL']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );

        //  ganti 21
        $variablell = DB::select('call thutins(?)', array($thutn['NO_BUKTI']));

        return redirect('/thutn')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Beli $thutn)
    {

        $variablell = DB::select('call thutdel(?)', array($thutn['NO_BUKTI']));
        // ganti 23
        $deleteThutn = Beli::find($thutn->NO_ID);

        // ganti 24

        $deleteThutn->delete();

        // ganti 
        return redirect('/thutn')->with('status', 'Data berhasil dihapus');
    }
}
