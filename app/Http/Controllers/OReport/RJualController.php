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

class RJualController extends Controller
{

  	public function report()
    {

		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		session()->put('filter_brg1', '');
		session()->put('filter_nabrg1', '');
	
        return view('oreport_jual.report')->with(['hasil' => []]);
    }
	  

	public function jasperJualReport(Request $request) 
	{
		$file 	= 'jualn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter


			
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and JUAL.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}

			if (!empty($request->KD_BRG))
			{
				$filterbrg = " and JUALD.KD_BRG='".$request->KD_BRG."' ";
			}


			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_brg1', $request->KD_BRG);
			session()->put('filter_nabrg1', $request->NA_BRG);

			
		$query = DB::SELECT("
			SELECT JUAL.NO_BUKTI,date_format(JUAL.TGL,'%d/%m/%y') as TGL,
			JUAL.NOTES, JUALD.KD_BRG, JUALD.NA_BRG,
			JUALD.QTY, JUALD.HARGA, JUALD.TOTAL
		    from JUAL, JUALD WHERE JUAL.NO_BUKTI = JUALD.NO_BUKTI			
			$filtertgl $filterbrg ;
		");
      
		if($request->has('filter'))
		{
			return view('oreport_jual.report')->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,			
				'QTY' => $query[$key]->KG,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,			
				'NOTES' => $query[$key]->NOTES

			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}