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


include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;


// ganti 2
class RBeliController extends Controller
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
        return view('oreport_beli.report')->with(['kodes' => $kodes]);
		
    }
	
	public function getBeliReport(Request $request)
    {
        $query = DB::table('beli')
			->join('belid', 'beli.NO_BUKTI', '=', 'belid.NO_BUKTI')
			->select('beli.NO_BUKTI','beli.TGL','beli.NO_PO', 'beli.KODES','beli.NAMAS','belid.KD_BHN','belid.NA_BHN','belid.QTY','belid.HARGA','belid.TOTAL', 'beli.GOL')->get();
			
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


	
	public function jasperBeliReport(Request $request) 
	{
		$file 	= 'beli';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
	
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and beli.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodes))
			{
				$filterkodes = " and beli.KODES='".$request->kodes."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and beli.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT beli.NO_BUKTI,beli.TGL,beli.NO_PO, beli.KODES,beli.NAMAS,belid.KD_BHN,belid.NA_BHN,
			belid.QTY,belid.HARGA,belid.TOTAL, beli.GOL from beli,belid WHERE beli.NO_BUKTI=belid.NO_BUKTI 
			$filtertgl $filtergol $filterkodes 
			/*order by beli.KODES,beli.NO_BUKTI*/;
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
				'KD_BHN' => $query[$key]->KD_BHN,
				'NA_BHN' => $query[$key]->NA_BHN,
				'QTY' => $query[$key]->QTY,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,
				'KET' => $query[$key]->KET,
				'GOL' => $query[$key]->GOL,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	

	

	
	

	
}
