<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Brg;
use DataTables;
use Auth;
use DB;

// ganti 2
class RStockbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function report()
    {
		
		$kd_brg = Brg::query()->get();
		//return $acno;
// GANTI 3 //
        return view('freport_stockb.report')->with(['kd_brg' => $kd_brg]);
		
    }
	
		public function getStockbReport(Request $request)
    {
		
        $query = DB::table('stockb')
			->join('stockb', 'stockb.NO_BUKTI', '=', 'stockbd.NO_BUKTI')
			->select('stockb.NO_BUKTI', 'stockb.TGL', 'stockbd.KD_BRG', 'stockbd.NA_BRG', 'stockbd.QTY', 'stockbd.KET')->get();
			
					
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			
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
