<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Terima;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class HasilproController extends Controller
{
    public function index()
    {
        return view('otransaksi_hasilpro.index');
    }

    public function browsePakai()
    {
		$pakai = DB::SELECT("SELECT A.NO_BUKTI, A.NO_ORDER, A.KODEC, A.NAMAC, A.NO_SO, A.KD_BRG, A.NA_BRG, A.QTY_OUT, A.NO_SERI, A.SATUAN, A.NOTES from pakai A, orderkxd B where A.NO_TERIMA ='' and a.QTY_OUT>0 AND A.NO_ORDER=B.NO_BUKTI  AND A.NO_PRS=B.NO_PRS #AND B.AKHIR=1");
		return response()->json($pakai);
	}

    public function getHasilpro(Request $request)
    {
        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $hasilpro = DB::table('terima')->select('*')->where('PER', $periode)->where('FLAG', 'HP')->orderBy('NO_BUKTI', 'ASC')->get();

        return Datatables::of($hasilpro)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational")) {
                    $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="hasilpro/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="hasilpro/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="hasilpro/print/' . $row->NO_ID . '">
                                    <i class="fa fa-print" aria-hidden="true"></i>
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
                            <a class="dropdown-item" href="hasilpro/show/' . $row->NO_ID . '">
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

    public function create()
    {
        return view('otransaksi_hasilpro.create');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'NO_BUKTI'  => 'required',
                'TGL'       => 'required',
                'NO_PAKAI'  => 'required',
            ]
        );

        // Insert Header
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);
        $query = DB::table('terima')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'HP')->orderByDesc('NO_BUKTI')->limit(1)->get();

        if ($query != '[]') {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'HP' . $tahun . $bulan . '-' . $query;
        } else {
            $no_bukti = 'HP' . $tahun . $bulan . '-0001';
        }

        $hasilpro = Terima::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'FLAG'             => 'HP',
                'PER'              => $periode,
                'NO_PAKAI'         => ($request['NO_PAKAI'] == null) ? "" : $request['NO_PAKAI'],
                'HASIL'            => (float) str_replace(',', '', $request['HASIL']),
                'NO_ORDER'         => ($request['NO_OK'] == null) ? "" : $request['NO_OK'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG'] == null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],
                'QTY'              => (float) str_replace(',', '', $request['QTY']),
                'SATUAN'           => ($request['SATUAN'] == null) ? "" : $request['SATUAN'],
                'NO_SERI'          => ($request['NO_SERI'] == null) ? "" : $request['NO_SERI'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
            ]
        );

        // DB::select("call terimains('$no_bukti')");
        return redirect('/hasilpro')->with('status', 'Data Hasil Produksi '.$no_bukti.' berhasil ditambahkan');
    }

    public function show(Terima $hasilpro)
    {
        $hasilproData = Terima::where('NO_ID', $hasilpro->NO_ID)->first();
        return view('otransaksi_hasilpro.show', $hasilproData);
    }

    public function edit(Terima $hasilpro)
    {
        $hasilproData = Terima::where('NO_ID', $hasilpro->NO_ID)->first();
        return view('otransaksi_hasilpro.edit', $hasilproData);
    }

    public function update(Request $request, Terima $hasilpro)
    {
        $this->validate(
            $request,
            [
                'NO_BUKTI'  => 'required',
                'TGL'       => 'required',
                'NO_PAKAI'  => 'required',
            ]
        );

        // DB::select("call terimadel('$hasilpro->NO_BUKTI')");

        $hasilpro->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_PAKAI'         => ($request['NO_PAKAI'] == null) ? "" : $request['NO_PAKAI'],
                'HASIL'            => (float) str_replace(',', '', $request['HASIL']),
                'NO_ORDER'         => ($request['NO_OK'] == null) ? "" : $request['NO_OK'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'NO_SO'            => ($request['NO_SO'] == null) ? "" : $request['NO_SO'],
                'KD_BRG'           => ($request['KD_BRG'] == null) ? "" : $request['KD_BRG'],
                'NA_BRG'           => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],
                'QTY'              => (float) str_replace(',', '', $request['QTY']),
                'SATUAN'           => ($request['SATUAN'] == null) ? "" : $request['SATUAN'],
                'NO_SERI'          => ($request['NO_SERI'] == null) ? "" : $request['NO_SERI'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
            ]
        );

        // DB::select("call terimains('$hasilpro->NO_BUKTI')");
        return redirect('/hasilpro')->with('status', 'Data '.$request->NO_BUKTI.' berhasil diedit');
    }

    public function destroy(Terima $hasilpro)
    {
        // DB::select("call terimadel('$hasilpro->NO_BUKTI')");
        Terima::find($hasilpro->NO_ID)->delete();

        return redirect('/hasilpro')->with('status', 'Data '.$hasilpro->NO_BUKTI.' berhasil dihapus');
    }
}
