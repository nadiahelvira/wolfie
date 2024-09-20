<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Kik;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

// ganti 2
class KikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('otransaksi_kik.index');
    }

// ganti 4

    public function getKik(Request $request)
    {
// ganti 5

	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}


         $kik = DB::table('kik')->select('*')->where('PER', $periode)->orderBy('NO_BUKTI', 'ASC')->get();

		
// ganti 6
		
        return Datatables::of($kik)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="kik/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="kik/print/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="kik/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="kik/show/'. $row->NO_ID .'">
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
        return view('otransaksi_kik.create');
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
                'TGL'      => 'required',
                'KODES'       => 'required',
                'KD_BRG'      => 'required'

            ]
        );
		
		
		// Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('po')->select('NO_BUKTI')->where('PER', $periode)->where('GOL', 'Y')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'KI'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'KI'.$tahun.$bulan.'-0001';
        }

        // Insert Header

// ganti 10

        $kik = Kik::create(
            [
                'NO_BUKTI'       => $no_bukti,
                'TGL'            => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'            => $periode,	
                'KD_BRG'         =>($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'         =>($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
                'SATUAN'       	 => ($request['SATUAN']==null) ? "" : $request['SATAUAN'],
                'KODES'          => ($request['KODES']==null) ? "" : $request['KODES'],
                'NAMAS'          => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
                'KG'       		 => ($request['KG']==null) ? "" : $request['KG'],
                'HARGA'      	 => (float) str_replace(',', '', $request['HARGA']),
                'TOTAL'          => (float) str_replace(',', '', $request['TTOTAL']),				
				'USRNM'          => Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );

//  ganti 11

        return redirect('/kik')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Kik $kik)
    {

// ganti 13

        $kikData = Kik::where('NO_ID', $kik->NO_ID)->first();

// ganti 14
        return view('otransaksi_kik.show', $kikData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Kik $kik)
    {
		
// ganti 16
		
        $kikData = Kik::where('NO_ID', $kik->NO_ID)->first();

// ganti 17 
        return view('otransaksi_kik.edit', $kikData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Kik $kik )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'KODES'       => 'required',
                'KD_BRG'      => 'required'
            ]
        );
		
// ganti 20

        $kik->update(
            [

                'TGL'         => $request['TGL'],		
                'KD_BRG'         => $request['KD_BRG'],
                'NA_BRG'         => $request['NA_BRG'],
                'SATUAN'       => $request['SATUAN'],
                'KODES'         => $request['KODES'],
                'NAMAS'         => $request['NAMAS'],
                'KG'       => $request['KG'],
                'HARGA'       => $request['HARGA'],
                'TOTAL'       => $request['TOTAL'],		
            ]
        );


//  ganti 21

        return redirect('/kik')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Kik $kik)
    {

// ganti 23
        $deleteKik = Kik::find($kik->NO_ID);

// ganti 24

        $deleteKik->delete();

// ganti 
        return redirect('/kik')->with('status', 'Data berhasil dihapus');
		
		
    }
}
