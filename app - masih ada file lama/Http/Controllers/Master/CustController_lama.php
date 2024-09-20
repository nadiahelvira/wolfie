<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\Master\Cust;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class CustController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('master_cust.index');
    }

// ganti 4
    public function browse()
    {
		$cust = DB::table('cust')->select('KODEC', 'NAMAC', 'ALAMAT', 'KOTA')->where('GOL', 'Y')->orderBy('KODEC', 'ASC')->get();
		return response()->json($cust);
	}
	
	public function browses()
    {
		$cust = DB::table('cust')->select('KODEC', 'NAMAC', 'ALAMAT', 'KOTA')->where('GOL', 'S')->orderBy('KODEC', 'ASC')->get();
		return response()->json($cust);
	}
	
	public function browsen()
    {
		$cust = DB::table('cust')->select('KODEC', 'NAMAC', 'ALAMAT', 'KOTA')->where('GOL', 'Z')->orderBy('KODEC', 'ASC')->get();
		return response()->json($cust);
	}
	
	public function browseb()
    {
		$cust = DB::table('cust')->select('KODEC', 'NAMAC', 'ALAMAT', 'KOTA')->where('GOL', 'B')->orderBy('KODEC', 'ASC')->get();
		return response()->json($cust);
	}
	
	
    public function getCust()
    {
// ganti 5

        $cust = Cust::query();
		
// ganti 6
		
        return Datatables::of($cust)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="cust/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="cust/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="cust/show/'. $row->NO_ID .'">
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
        return view('master_cust.create');
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
                'KODEC'       => 'required',
                'NAMAC'      => 'required'
            ]
        );

        // Insert Header

// ganti 10

        $cust = Cust::create(
            [
                'KODEC'         => ($request['KODEC']==null) ? "" : $request['KODEC'],
                'NAMAC'         => ($request['NAMAC']==null) ? "" : $request['NAMAC'],
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
				'LIM'        	=> ($request['LIM']==null) ? "" : $request['LIM'],
				'HARI'        	=> ($request['HARI']==null) ? "" : $request['HARI'],
				'USRNM'      	=> Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );

//  ganti 11

        return redirect('/cust')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Cust $cust)
    {

// ganti 13

        $custData = Cust::where('NO_ID', $cust->NO_ID)->first();

// ganti 14
        return view('master_cust.show', $custData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Cust $cust)
    {
		
// ganti 16
		
        $custData = Cust::where('NO_ID', $cust->NO_ID)->first();

// ganti 17 
        return view('master_cust.edit', $custData);
			

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Cust $cust )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'KODEC'       => 'required',
                'NAMAC'      => 'required'
            ]
        );
		
// ganti 20

        $cust->update(
            [

                'NAMAC'         => $request['NAMAC'],
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
				'LIM'        	=> (float) str_replace(',', '', $request['LIM']),
				'HARI'        	=> (float) str_replace(',', '', $request['HARI']),
				'USRNM'      	=> Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );


//  ganti 21

        return redirect('/cust')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Cust $cust)
    {

// ganti 23
        $deleteCust = Cust::find($cust->NO_ID);

// ganti 24

        $deleteCust->delete();

// ganti 
        return redirect('/cust')->with('status', 'Data berhasil dihapus');
		
		
    }
}
