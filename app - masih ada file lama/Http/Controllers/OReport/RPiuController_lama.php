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
class RPiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

 	public function report()
    {
// GANTI 3 //
		$kodec = Cust::orderBy('KODEC')->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_piu.report')->with(['kodec' => $kodec]);
		
    }
	
		public function getPiuReport(Request $request)
    {
        $query = DB::table('piu')
			->join('piud', 'piu.NO_BUKTI', '=', 'piud.NO_BUKTI')
			->select('piu.NO_BUKTI','piu.NO_SO','piu.TGL', 'piu.KODEC','piu.NAMAC','piud.NO_FAKTUR','piud.TOTAL','piud.BAYAR','piud.SISA','piu.GOL')->get();
			
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

	public function jasperPiuReport(Request $request) 
	{
		$file 	= 'piun';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and piu.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodec))
			{
				$filterkodec = " and piu.KODEC='".$request->kodec."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and piu.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT piu.NO_BUKTI,piu.NO_SO,piu.TGL,piu.KODEC,piu.NAMAC,piud.NO_FAKTUR,piud.TOTAL,piud.BAYAR,piud.SISA,piu.GOL from piu,piud WHERE piu.NO_BUKTI=piud.NO_BUKTI  $filtertgl $filtergol $filterkodec;
		");
        
		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'NO_SO' => $query[$key]->NO_SO,
				'TGL' => $query[$key]->TGL,
				'KODEC' => $query[$key]->KODEC,
				'NAMAC' => $query[$key]->NAMAC,
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
