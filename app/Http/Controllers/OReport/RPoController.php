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

class RPoController extends Controller
{
    public function report()
    {
		
		session()->put('filter_type01', '');
		session()->put('filter_kd_brg', '');
		session()->put('filter_na_brg', '');
		session()->put('filter_kodes', '');
		session()->put('filter_namas', '');
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));

        return view('oreport_po.report')->with(['hasil' => []]);
    }
	
	
	 
	public function jasperPoReport(Request $request) 
	{
		$file 	= 'pon';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter

			if (!empty($request->kd_brg))
			{
				$filterkd_brg = " and POD.KD_BRG='".$request->kd_brg."' ";
			}
			
			if (!empty($request->kodes))
			{
				$filterkodes = " and PO.KODES='".$request->kodes."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " AND PO.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}	
			
			session()->put('filter_kd_brg', $request->kd_brg);
			session()->put('filter_na_brg', $request->na_brg);
			session()->put('filter_kodes', $request->kodes);
			session()->put('filter_namas', $request->namas);
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);

		$query = DB::SELECT("
			SELECT po.NO_BUKTI, po.TGL, po.KODES, po.NAMAS,
			pod.KD_BRG, pod.NA_BRG,  pod.SATUAN, pod.QTY, 
			pod.HARGA, pod.TOTAL, pod.KIRIM, pod.SISA  
			from po, pod WHERE po.NO_BUKTI=pod.NO_BUKTI 
			$filtertgl $filterkd_brg $filterkodes ");	
			
		

		if($request->has('filter'))
		{
			return view('oreport_po.report')->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'SATUAN' => $query[$key]->SATUAN,
				'QTY' => $query[$key]->QTY,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
