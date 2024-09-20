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

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;


// ganti 2
class RThutController extends Controller
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
        return view('oreport_thut.report')->with(['kodes' => $kodes]);
		
    }
	
		public function getThutReport(Request $request)
    {
        $query = DB::table('beli')
			->select('NO_BUKTI','TGL','NO_PO', 'KODES','NAMAS', 'TOTAL', 'NOTES', 'GOL' )->where('FLAG', 'TH')->get();
			
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			if (!empty($request->gol))
			{
				$query = $query->where('GOL', $request->gol);
			}
			
			if (!empty($request->kodes))
			{
				$query = $query->where('KODES', $request->kodes);
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


	public function jasperThutReport(Request $request) 
	{
		$file 	= 'thutn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodes))
			{
				$filterkodes = " and KODES='".$request->kodes."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT NO_BUKTI,TGL,NO_PO,KODES,NAMAS,TOTAL,NOTES,GOL from beli WHERE FLAG='TH' $filtertgl $filtergol $filterkodes;
		");

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'NO_PO' => $query[$key]->NO_PO,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'BAYAR' => $query[$key]->TOTAL,
				'NOTES' => $query[$key]->NOTES,
				'GOL' => $query[$key]->GOL,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	

	
}
