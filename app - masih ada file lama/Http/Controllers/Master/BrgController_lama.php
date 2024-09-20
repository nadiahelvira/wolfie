<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\Master\Brg;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class BrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('master_brg.index');
    }

// ganti 4

// ganti 4
    public function browse()
    {
		$brg = DB::table('brg')->select('KD_BRG', 'NA_BRG', 'SATUAN')->where('GOL', 'Y')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($brg);
	}

	public function browses()
    {
		$brg = DB::table('brg')->select('KD_BRG', 'NA_BRG', 'SATUAN')->where('GOL', 'S')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($brg);
	}
	
	public function browsen()
    {
		$brg = DB::table('brg')->select('KD_BRG', 'NA_BRG', 'SATUAN')->where('GOL', 'Z')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($brg);
	}
	
	public function browseb()
    {
		$brg = DB::table('brg')->select('KD_BRG', 'NA_BRG', 'SATUAN')->where('GOL', 'B')->orderBy('KD_BRG', 'ASC')->get();
		return response()->json($brg);
	}
	
	

	
    public function getBrg()
    {
// ganti 5

        $brg = Brg::query();
		
// ganti 6
		
        return Datatables::of($brg)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="brg/edit/'. $row->NO_ID .'">
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="brg/delete/'. $row->NO_ID .'">
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
                            <a class="dropdown-item" href="brg/show/'. $row->NO_ID .'">
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
        return view('master_brg.create');
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
                'KD_BRG'       => 'required',
                'NA_BRG'      => 'required'
            ]
        );

        // Insert Header

// ganti 10

        $brg = Brg::create(
            [
                'KD_BRG'         => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],	
                'NA_BRG'         => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],	
				'GOL'          	 => ($request['GOL']==null) ? "" : $request['GOL'],	
                'SATUAN'         => ($request['SATUAN']==null) ? "" : $request['SATUAN'],	
				'HPRO'           => (float) str_replace(',', '', $request['HPRO']),
				'USRNM'          => Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );

//  ganti 11

        return redirect('/brg')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 
    public function show(Brg $brg)
    {

// ganti 13

        $brgData = Brg::where('NO_ID', $brg->NO_ID)->first();

// ganti 14
        return view('master_brg.show', $brgData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Brg $brg)
    {
		
// ganti 16
		
        $brgData = Brg::where('NO_ID', $brg->NO_ID)->first();

// ganti 17 
        return view('master_brg.edit', $brgData);
		

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Brg $brg )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'KD_BRG'       => 'required',
                'NA_BRG'      => 'required'
            ]
        );
		
// ganti 20

        $brg->update(
            [
				'KD_BRG'       	 => ($request['KD_BRG']==null) ? "" : $request['KD_BRG'],
                'NA_BRG'       	 => ($request['NA_BRG']==null) ? "" : $request['NA_BRG'],
				'GOL'       	 => ($request['GOL']==null) ? "" : $request['GOL'],				
                'SATUAN'       	 => ($request['SATUAN']==null) ? "" : $request['SATUAN'],
				'HPRO'           => (float) str_replace(',', '', $request['HPRO']),
				'USRNM'          => Auth::user()->username,
				'TG_SMP'         => Carbon::now()
				
				
            ]
        );


//  ganti 21

        return redirect('/brg')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Brg $brg)
    {

// ganti 23
        $deleteBrg = Brg::find($brg->NO_ID);

// ganti 24

        $deleteBrg->delete();

// ganti 
        return redirect('/brg')->with('status', 'Data berhasil dihapus');
		
		
    }
}
