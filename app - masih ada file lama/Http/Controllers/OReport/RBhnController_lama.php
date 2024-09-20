<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Bhn;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

// ganti 2
class RBhnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function report()
    {
// GANTI 3 //
		$kd_bhn = Bhn::query()->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_bhn.report')->with(['kd_bhn' => $kd_bhn]);
		
    }
	
		public function getBhnReport(Request $request)
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
		
        $query = DB::table('bhn')
			->join('bhnd', 'bhn.KD_BHN', '=', 'bhnd.KD_BHN')
			->select('bhn.KD_BHN','bhn.NA_BHN','bhnd.AW'.$bulan. ' as AW', 'bhnd.MA'.$bulan. ' as MA', 
			'bhnd.KE'.$bulan. ' as KE','bhnd.LN'.$bulan. ' as LN', 'bhnd.AK'.$bulan. ' as AK', 
			'bhnd.HRT'.$bulan. ' as HRT',
			'bhnd.NIW'.$bulan. ' as NIW', 'bhnd.NIM'.$bulan. ' as NIM', 'bhnd.NIK'.$bulan. ' as NIK',
            'bhnd.NIL'.$bulan. ' as NIL','bhnd.NIR'.$bulan. ' as NIR')->where('bhnd.YER',$tahun)->get();
			
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
