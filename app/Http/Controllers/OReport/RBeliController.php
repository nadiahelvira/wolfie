<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RBeliController extends Controller
{

   public function report()
    {
		session()->put('filter_gol', '');
		session()->put('filter_kodes1', '');
		session()->put('filter_namas1', '');
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		session()->put('filter_brg1', '');
		session()->put('filter_nabrg1', '');


        return view('oreport_beli.report')->with(['hasil' => []]);
    }
	
	 
	public function jasperBeliReport(Request $request) 
	{
		$file 	= 'belin';
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

			if (!empty($request->brg1))
			{
				$filterbrg = " and beid.KD_BRG='".$request->brg1."' ";
			}
			

			session()->put('filter_gol', $request->gol);
			session()->put('filter_kodes1', $request->kodes);
			session()->put('filter_namas1', $request->NAMAS);
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_brg1', $request->brg1);
			session()->put('filter_nabrg1', $request->nabrg1);
			session()->put('filter_flag', $request->flag);
		

		if( $filtergol == 'B'){
			$query = DB::SELECT("SELECT trim(beli.NO_BUKTI) as NO_BUKTI, beli.TGL, beli.NO_PO, beli.KODES, 
									beli.NAMAS, belid.KD_BHN AS KD_BRG, belid.NA_BHN AS NA_BRG,
									belid.QTY, belid.HARGA, belid.TOTAL, beli.GOL, belid.PPN, (belid.TOTAL + belid.PPN) AS NETT 
								from beli,belid 
								WHERE beli.NO_BUKTI=belid.NO_BUKTI 
								$filtertgl $filtergol $filterkodes 
								/*order by beli.KODES,beli.NO_BUKTI*/;
							");
		
		} else {
			$query = DB::SELECT("SELECT trim(beli.NO_BUKTI) as NO_BUKTI, beli.TGL, beli.NO_PO, beli.KODES, 
									beli.NAMAS, belid.KD_BRG, belid.NA_BRG,
									belid.QTY, belid.HARGA, belid.TOTAL, beli.GOL, belid.PPN, (belid.TOTAL + belid.PPN) AS NETT 
								from beli,belid 
								WHERE beli.NO_BUKTI=belid.NO_BUKTI 
								$filtertgl $filtergol $filterkodes 
								/*order by beli.KODES,beli.NO_BUKTI*/;
							");
		}
			

		if($request->has('filter'))
		{
			return view('oreport_beli.report')->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'NO_PO' => $query[$key]->NO_PO,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'KD_BHN' => $query[$key]->KD_BHN,
				'NA_BHN' => $query[$key]->NA_BHN,
				'KG' => $query[$key]->KG,
				'QTY' => $query[$key]->QTY,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,
				'PPN' => $query[$key]->PPN,
				'NETT' => $query[$key]->NETT,
				'NOTES' => $query[$key]->NOTES,

			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}