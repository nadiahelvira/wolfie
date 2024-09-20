<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Cust;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;


// ganti 2
class RSoController extends Controller
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
        return view('oreport_so.report')->with(['kodec' => $kodec]);
		
    }
	
		public function getSoReport(Request $request)
    {
        $query = DB::table('so')
			->join('sod', 'so.NO_BUKTI', '=', 'sod.NO_BUKTI')
			->select('so.NO_BUKTI', 'so.TGL', 'so.KODEC', 'so.NAMAC', 'sod.KD_BRG', 'sod.NA_BRG', 'sod.QTY', 'sod.HARGA', 'sod.TOTAL', 'sod.KET', 'so.GOL')
			->get();
			
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
			
			if (!empty($request->kodec))
			{
				$query = $query->where('KODEC', $request->kodec);
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

	
	public function jasperSoReport(Request $request) 
	{
		$file 	= 'so';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
	
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and so.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodec))
			{
				$filterkodec = " and so.KODEC='".$request->kodec."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and so.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT so.NO_BUKTI, so.TGL, so.KODEC, so.NAMAC, sod.KD_BRG, sod.NA_BRG, sod.QTY, sod.HARGA, sod.TOTAL, sod.KET, so.GOL from so,sod WHERE so.NO_BUKTI=sod.NO_BUKTI $filtertgl $filtergol $filterkodec /*order by so.KODEC,so.NO_BUKTI*/;
		"); 
		
		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODEC' => $query[$key]->KODEC,
				'NAMAC' => $query[$key]->NAMAC,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'QTY' => $query[$key]->QTY,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,
				'NOTES' => $query[$key]->NOTES,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	

	
	

	
}