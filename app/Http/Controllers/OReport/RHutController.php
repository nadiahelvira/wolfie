<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Sup;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RHutController extends Controller
{

  	public function report()
    {
		
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		session()->put('filter_kodes1', '');


        return view('oreport_hut.report')->with(['hasil' => []]);
    }
	
	

	public function jasperHutReport(Request $request) 
	{
		$file 	= 'hutn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
			

			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and HUT.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			

				if (!empty($request->kodes1))
			{
				$filterkodes1 = " and HUT.KODES='".$request->KODES."' ";
			}
			
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_kodes1', $request->KODES);
		
      		$query = DB::SELECT("
		     	SELECT HUT.NO_BUKTI,date_format(HUT.TGL,'%d/%m/%y') as TGL,
			    HUT.KODES, HUT.NAMAS, HUTD.NO_FAKTUR, HUTD.TOTAL,
			    HUTD.BAYAR
		        from HUT, HUTD WHERE HUT.NO_BUKTI = HUTD.NO_BUKTI 
		     	$filtertgl $filterkodes1 		
			     ;
		     ");
		

		

		if($request->has('filter'))
		{
			return view('oreport_hut.report')->with(['hasil' => $query]);
		}
        
		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,			
				'NO_FAKTUR' => $query[$key]->NO_FAKTUR,
				'TOTAL' => $query[$key]->TOTAL,
				'BAYAR' => $query[$key]->BAYAR
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}