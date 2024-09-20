<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Cust;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

// ganti 2
class RCustController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function report()
    {
// GANTI 3 //
		$kodec = Cust::query()->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_cust.report')->with(['kodec' => $kodec]);
		
    }
	
		public function getCustReport(Request $request)
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
		
        $query = DB::table('cust')
			->join('custd', 'cust.KODEC', '=', 'custd.KODEC')
			->select('cust.KODEC','cust.NAMAC','custd.AW'.$bulan. ' as AW', 'custd.MA'.$bulan. ' as MA', 
			'custd.KE'.$bulan. ' as KE','custd.LN'.$bulan. ' as LN', 'custd.AK'.$bulan. ' as AK')->where('custd.YER',$tahun)->get();
			
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
