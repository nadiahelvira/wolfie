<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Cust;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RPiuController extends Controller
{
 	public function report()
    {
		$kodec = Cust::orderBy('KODEC')->get();
		session()->put('filter_kodec1', '');
		session()->put('filter_namac1', '');
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		
        return view('oreport_piu.report')->with(['kodec' => $kodec])->with(['hasil' => []]);
    }
	

	public function jasperPiuReport(Request $request) 
	{
		$file 	= 'piun';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter

			
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
			
			
			session()->put('filter_kodec1', $request->kodec);
			session()->put('filter_namac1', $request->NAMAC);
			
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);

		$query = DB::SELECT("

			SELECT piu.NO_BUKTI,piu.TGL,piu.KODEC,piu.NAMAC,
			piud.NO_FAKTUR,piud.TOTAL,piud.BAYAR,piud.SISA		
			from piu,piud WHERE piu.NO_BUKTI=piud.NO_BUKTI  $filtertgl $filterkodec
		

		");

		if($request->has('filter'))
		{
			return view('oreport_piu.report')->with(['hasil' => $query]);
		}
        
		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODEC' => $query[$key]->KODEC,
				'NAMAC' => $query[$key]->NAMAC,
				'NO_FAKTUR' => $query[$key]->NO_FAKTUR,
				'TOTAL' => $query[$key]->TOTAL,
				'BAYAR' => $query[$key]->BAYAR,
				'SISA' => $query[$key]->SISA,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
