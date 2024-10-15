<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Brg_st;
use App\Models\Master\Perid;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RBrg_stController extends Controller
{
	
   public function report()
    {
		
		$per = Perid::query()->get();
		session()->put('filter_per', '');

        return view('oreport_brg_st.report')->with(['per' => $per])->with(['hasil' => []]);
    }
	
   
	public function jasperBrg_stReport(Request $request) 
	{
		$file 	= 'brg_stpr';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		
        	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
		if($request['perio'])
		{
			$periode = $request['perio'];
		}
		
		$bulan = substr($periode,0,2);
		$tahun = substr($periode,3,4);
		
		$queryakum = DB::SELECT("SET @akum:=0;");
		$query = DB::SELECT("
		SELECT st_brg.KD_BRG,st_brg.NA_BRG,st_brgd.AW$bulan as AW, st_brgd.MA$bulan as MA, 
		    st_brgd.KE$bulan as KE,st_brgd.LN$bulan as LN,st_brgd.AK$bulan as AK, 
			st_brgd.HRT$bulan as HRT,st_brgd.NIW$bulan as NIW,st_brgd.NIM$bulan as NIM,st_brgd.NIK$bulan as NIK,
		st_brgd.NIL$bulan as NIL,st_brgd.NIR$bulan as NIR
		FROM st_brg,st_brgd
		WHERE st_brg.KD_BRG=st_brgd.KD_BRG and st_brgd.YER='$tahun' AND 
		( st_brgd.AW$bulan <> 0 OR  st_brgd.MA$bulan <> 0 OR st_brgd.KE$bulan <> 0 OR st_brgd.LN$bulan <> 0 OR st_brgd.AK$bulan <> 0 )
		  order by KD_BRG;
		");

		$per = Perid::query()->get();
		session()->put('filter_per', $periode);
		if($request->has('filter'))
		{
			return view('oreport_brg_st.report')->with(['per' => $per])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'AW' => $query[$key]->AW,
				'MA' => $query[$key]->MA,
				'KE' => $query[$key]->KE,
				'LN' => $query[$key]->LN,
				'AK' => $query[$key]->AK,
				'HRT' => $query[$key]->HRT,
				'HRT_2' => $query[$key]->HRT_2,
				'NIW' => $query[$key]->NIW,
				'NIM' => $query[$key]->NIM,
				'NIK' => $query[$key]->NIK,
				'NIL' => $query[$key]->NIL,
				'NIR' => $query[$key]->NIR,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
