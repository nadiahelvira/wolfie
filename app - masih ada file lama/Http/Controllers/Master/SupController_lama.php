<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Sup;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class SupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_sup.index');
    }
	
	
    public function browse()
    {
		$sup = DB::table('sup')->select('KODES', 'NAMAS', 'ALAMAT', 'KOTA')->where('GOL', 'Y')->orderBy('KODES', 'ASC')->get();
		return response()->json($sup);
	}

    public function browses()
    {
		$sup = DB::table('sup')->select('KODES', 'NAMAS', 'ALAMAT', 'KOTA')->where('GOL', 'S')->orderBy('KODES', 'ASC')->get();
		return response()->json($sup);
	}

	public function browsen()
    {
		$sup = DB::table('sup')->select('KODES', 'NAMAS', 'ALAMAT', 'KOTA')->where('GOL', 'Z')->orderBy('KODES', 'ASC')->get();
		return response()->json($sup);
	}
	
	public function browseb()
    {
		$sup = DB::table('sup')->select('KODES', 'NAMAS', 'ALAMAT', 'KOTA')->where('GOL', 'B')->orderBy('KODES', 'ASC')->get();
		return response()->json($sup);
	}
	
    public function getSup()
    {
        $sup = Sup::query();
        return Datatables::of($sup)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="sup/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="sup/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="sup/show/'. $row->NO_ID .'">
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
        return view('master_sup.create');
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
// GANTI 8 SESUAI NAMA KOLOM DI NAVICAT //
        [
                'KODES'       => 'required',
                'NAMAS'      => 'required'
            ]
        );

        // Insert Header

        $sup = Sup::create(
            [
                'KODES'         => ($request['KODES']==null) ? "" : $request['KODES'],
                'NAMAS'         => ($request['NAMAS']==null) ? "" : $request['NAMAS'],
				'GOL'         	=> ($request['GOL']==null) ? "" : $request['GOL'],
                'ALAMAT'       	=> ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
                'KOTA'        	=> ($request['KOTA']==null) ? "" : $request['KOTA'],
				'TELPON1'       => ($request['TELPON1']==null) ? "" : $request['TELPON1'],
				'FAX'        	=> ($request['FAX']==null) ? "" : $request['FAX'],
				'HP'        	=> ($request['HP']==null) ? "" : $request['HP'],
				'AKT'        	=> ($request['AKT']==null) ? "" : $request['AKT'],
				'KONTAK'        => ($request['KONTAK']==null) ? "" : $request['KONTAK'],
				'EMAIL'       	=> ($request['EMAIL']==null) ? "" : $request['EMAIL'],
				'NPWP'        	=> ($request['NPWP']==null) ? "" : $request['NPWP'],
				'KET'        	=> ($request['KET']==null) ? "" : $request['KET'],
				'BANK'        	=> ($request['BANK']==null) ? "" : $request['BANK'],
				'BANK_CAB'      => ($request['BANK_CAB']==null) ? "" : $request['BANK_CAB'],
				'BANK_KOTA'     => ($request['BANK_KOTA']==null) ? "" : $request['BANK_KOTA'],
				'BANK_NAMA'     => ($request['BANK_NAMA']==null) ? "" : $request['BANK_NAMA'],
				'BANK_REK'      => ($request['BANK_REK']==null) ? "" : $request['BANK_REK'],
				'HARI'        	=> (float) str_replace(',', '', $request['HARI']),
				'USRNM'      	=> Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );


        return redirect('/sup')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
    public function show(Sup $sup)
    {

        $supData = Sup::where('NO_ID', $sup->NO_ID)->first();
        return view('master_sup.show', $supData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
    public function edit(Sup $sup)
    {
        $supData = Sup::where('KODES', $sup->KODES)->first();
        return view('master_sup.edit', $supData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sup $sup)
    {
		
        $this->validate($request,
        [
                'KODES'       => 'required',
                'NAMAS'      => 'required'
            ]
        );
		

        $sup->update(
            [

                'NAMAS'       	=> $request['NAMAS'],
				'GOL'         	=> ($request['GOL']==null) ? "" : $request['GOL'],
                'ALAMAT'       	=> ($request['ALAMAT']==null) ? "" : $request['ALAMAT'],
                'KOTA'        	=> ($request['KOTA']==null) ? "" : $request['KOTA'],
				'TELPON1'       => ($request['TELPON1']==null) ? "" : $request['TELPON1'],
				'FAX'        	=> ($request['FAX']==null) ? "" : $request['FAX'],
				'HP'        	=> ($request['HP']==null) ? "" : $request['HP'],
				'AKT'        	=> ($request['AKT']==null) ? "" : $request['AKT'],
				'KONTAK'        => ($request['KONTAK']==null) ? "" : $request['KONTAK'],
				'EMAIL'       	=> ($request['EMAIL']==null) ? "" : $request['EMAIL'],
				'NPWP'        	=> ($request['NPWP']==null) ? "" : $request['NPWP'],
				'KET'        	=> ($request['KET']==null) ? "" : $request['KET'],
				'BANK'        	=> ($request['BANK']==null) ? "" : $request['BANK'],
				'BANK_CAB'      => ($request['BANK_CAB']==null) ? "" : $request['BANK_CAB'],
				'BANK_KOTA'     => ($request['BANK_KOTA']==null) ? "" : $request['BANK_KOTA'],
				'BANK_NAMA'     => ($request['BANK_NAMA']==null) ? "" : $request['BANK_NAMA'],
				'BANK_REK'      => ($request['BANK_REK']==null) ? "" : $request['BANK_REK'],
				'HARI'        	=> (float) str_replace(',', '', $request['HARI']),
				'USRNM'      	=> Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );


        return redirect('/sup')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sup $sup)
    {
        $deleteSup = Sup::find($sup->NO_ID);
        $deleteSup->delete();

        return redirect('/sup')->with('status', 'Data berhasil dihapus');
		
		
    }
}
