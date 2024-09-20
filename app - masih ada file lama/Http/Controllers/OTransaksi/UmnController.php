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
class UmnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('otransaksi_umn.index');
    }

    // ganti 4

    public function getUmn(Request $request)
    {
        // ganti 5

        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        //           $thut = DB::table('beli')->select('*')->where('PER', $periode)->where('FLAG', 'TH')->orderBy('NO_BUKTI', 'ASC')->get();

        $umn = DB::table('beli')->select('*')->where('PER', $periode)->where('FLAG', 'UM')->where('GOL', 'Z')->orderBy('NO_BUKTI', 'ASC')->get();


        // ganti 6

        return Datatables::of($umn)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="umn/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="umn/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="umn/print/' . $row->NO_ID . '">
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
                            <a class="dropdown-item" href="umn/show/' . $row->NO_ID . '">
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
        return view('otransaksi_umn.create');
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

        // ganti 10

        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('beli')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'UM')->where('GOL', 'Z')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'UMZ' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'UMZ' . $tahun . $bulan . '-0001';
        }



        $typebayar = substr($request['BNAMA'],0,1);
		
		if ( $typebayar != 'K' )
        {	
	
            $bulan    = session()->get('periode')['bulan'];
            $tahun    = substr(session()->get('periode')['tahun'], -2);
            $query2 = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBK')->orderByDesc('NO_BUKTI')->limit(1)->get();

            if ($query2 != '[]') {
                $query2 = substr($query2[0]->NO_BUKTI, -4);
                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti2 = 'BBK' . $tahun . $bulan . '-' . $query2;
            } else {
                $no_bukti2 = 'BBK' . $tahun . $bulan . '-0001';
            }
        
		} 
		else
        {

			$bulan    = session()->get('periode')['bulan'];
            $tahun    = substr(session()->get('periode')['tahun'], -2);
            $query2 = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKK')->orderByDesc('NO_BUKTI')->limit(1)->get();

            if ($query2 != '[]') {
                $query2 = substr($query2[0]->NO_BUKTI, -4);
                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti2 = 'BKK' . $tahun . $bulan . '-' . $query2;
            } else {
                $no_bukti2 = 'BKK' . $tahun . $bulan . '-0001';
            }
			
			
        }	
		
        // ganti 10

        $um = Beli::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
                'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'BACNO'            => ($request['BACNO'] == null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA'] == null) ? "" : $request['BNAMA'],
                'NO_BANK'          => $no_bukti2,
                'FLAG'             => 'UM',
                'GOL'               => 'Z',
                'ACNOA'            => '116103',
                'NACNOA'           => 'UANG MUKA PEMBELIAN NON',
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL1'           => (float) str_replace(',', '', $request['TOTAL1']),
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'SISA'             => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()

            ]
        );

        //  ganti 11
        $variablell = DB::select('call umins(?,?)', array($no_bukti, $no_bukti2));

        return redirect('/umn')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12

    public function show(Beli $umn)
    {

        // ganti 13

        $umnData = Beli::where('NO_ID', $umn->NO_ID)->first();

        // ganti 14
        return view('otransaksi_umn.show', $umnData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

    public function edit(Beli $umn)
    {

        // ganti 16

        $umnData = Beli::where('NO_ID', $umn->NO_ID)->first();

        // ganti 17 
        return view('otransaksi_umn.edit', $umnData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Beli $umn)
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
        $variablell = DB::select('call umdel(?,?)', array($umn['NO_BUKTI'], '0'));



        $umn->update(

            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_PO'            => ($request['NO_PO'] == null) ? "" : $request['NO_PO'],
                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL1'           => (float) str_replace(',', '', $request['TOTAL1']),
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'SISA'             => (float) str_replace(',', '', $request['TOTAL1']) * -1,
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now()
            ]
        );


        //  ganti 21
        $variablell = DB::select('call umins(?,?)', array($umn['NO_BUKTI'], 'X'));


        return redirect('/umn')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Beli $umn)
    {

        $variablell = DB::select('call umdel(?,?)', array($umn['NO_BUKTI'], '1'));


        // ganti 23
        $deleteUmn = Beli::find($umn->NO_ID);

        // ganti 24

        $deleteUmn->delete();

        // ganti 
        return redirect('/umn')->with('status', 'Data berhasil dihapus');
    }
}
