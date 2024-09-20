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
class RHutController extends Controller
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
        return view('oreport_hut.report')->with(['kodes' => $kodes]);
		
    }
	
		public function getHutReport(Request $request)
    {
        	$query = DB::table('hut')
			->join('hutd', 'hut.NO_BUKTI', '=', 'hutd.NO_BUKTI')
			->select('hut.NO_BUKTI','hut.TGL', 'hut.KODES','hut.NAMAS','hutd.NO_FAKTUR','hutd.TOTAL','hutd.BAYAR','hutd.SISA','hut.GOL')->get();
			
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
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmpD]);
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


	public function jasperHutReport(Request $request) 
	{
		$file 	= 'hut';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
	
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and hut.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodes))
			{
				$filterkodes = " and hut.KODES='".$request->kodes."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and hut.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT hut.NO_BUKTI,hut.NO_PO,hut.TGL,hut.KODES,hut.NAMAS,hutd.NO_FAKTUR,hutd.TOTAL,hutd.BAYAR,hutd.SISA,hut.GOL from hut,hutd WHERE hut.NO_BUKTI=hutd.NO_BUKTI $filtertgl $filtergol $filterkodes;
		");
		

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'NO_PO' => $query[$key]->NO_PO,
				'TGL' => $query[$key]->TGL,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'NO_FAKTUR' => $query[$key]->NO_FAKTUR,
				'TOTAL' => $query[$key]->TOTAL,
				'BAYAR' => $query[$key]->BAYAR,
				'SISA' => $query[$key]->SISA,
				'GOL' => $query[$key]->GOL,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	

	
}
