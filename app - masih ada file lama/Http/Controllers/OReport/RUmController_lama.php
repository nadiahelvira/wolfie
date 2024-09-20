<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Sup;
use DataTables;
use Auth;
use DB;

// ganti 2
class RUmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function report()
    {
// GANTI 3 //
		$kodes = Sup::orderBy('KODES')->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_um.report')->with(['kodes' => $kodes]);
		
    }
	
		public function getUmReport(Request $request)
    {
        $query = DB::table('beli')
			->select('NO_BUKTI','TGL','NO_PO', 'KODES','NAMAS','BACNO', 'BNAMA', 'TOTAL1', 'NOTES', 'GOL' )->where('FLAG', 'UM')->get();
			
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			if (!empty($request->GOL))
			{
				$query = $query->where('GOL', $request->GOL);
			}
			
			if (!empty($request->kodec))
			{
				$query = $query->where('KODES', $request->KODES);
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmp]);
			}
			
			return Datatables::of($query)->addIndexColumn()->make(true);
		}
		
    }	  
	 



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


	
	

	
}
