<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Sup;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

// ganti 2
class RSupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function report()
    {
// GANTI 3 //
		$kodes = Sup::query()->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_sup.report')->with(['kodes' => $kodes]);
		
    }
	
		public function getSupReport(Request $request)
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
		
        $query = DB::table('sup')
			->join('supd', 'sup.KODES', '=', 'supd.KODES')
			->select('sup.KODES','sup.NAMAS','supd.AW'.$bulan. ' as AW', 'supd.MA'.$bulan. ' as MA', 
			'supd.KE'.$bulan. ' as KE','supd.LN'.$bulan. ' as LN', 'supd.AK'.$bulan. ' as AK')->where('supd.YER',$tahun)->get();
			
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
