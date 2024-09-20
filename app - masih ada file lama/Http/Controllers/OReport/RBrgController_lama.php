<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Brg;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

// ganti 2
class RBrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function report()
    {
// GANTI 3 //
		$kd_brg = Brg::query()->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_brg.report')->with(['kd_brg' => $kd_brg]);
		
    }
	
		public function getBrgReport(Request $request)
    {
		
		 if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
		$bulan = substr($periode,0,2);
		$tahun = substr($periode,3,4);
		
        $query = DB::table('brg')
			->join('brgd', 'brg.KD_BRG', '=', 'brgd.KD_BRG')
			->select('brg.KD_BRG','brg.NA_BRG','brgd.AW'.$bulan. ' as AW', 'brgd.MA'.$bulan. ' as MA', 
			'brgd.KE'.$bulan. ' as KE','brgd.LN'.$bulan. ' as LN', 'brgd.AK'.$bulan. ' as AK', 
			'brgd.HRT'.$bulan. ' as HRT',
			'brgd.NIW'.$bulan. ' as NIW', 'brgd.NIM'.$bulan. ' as NIM', 'brgd.NIK'.$bulan. ' as NIK',
            'brgd.NIL'.$bulan. ' as NIL','brgd.NIR'.$bulan. ' as NIR')->where('brgd.YER',$tahun)->get();
			
		//if ($request->ajax())
		//{
				//$query = $query->whereBetween('TGL', [$tglDrD, $tglSmp]);
			
			//return Datatables::of($query)->addIndexColumn()->make(true);
		//}
		return Datatables::of($query)->addIndexColumn()->make(true);
    }	  
	 



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


	
	

	
}
