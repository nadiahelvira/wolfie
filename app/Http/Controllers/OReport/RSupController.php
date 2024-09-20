<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Sup;
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

class RSupController extends Controller
{

   public function report()
    {
		$kodes = Sup::query()->get();
		$per = Perid::query()->get();
		session()->put('filter_gol', '');
		session()->put('filter_per', '');
		
        return view('oreport_sup.report')->with(['kodes' => $kodes])->with(['per' => $per])->with(['hasil' => []]);
    }
	

	 
	public function jasperSupReport(Request $request) 
	{
		$file 	= 'suppr';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		
        if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
		if ($request->gol)
		{
			$filtergol = " and sup.GOL='".$request->gol."' ";
		}
		
		if($request['perio'])
		{
			$periode = $request['perio'];
		}
		
		$bulan = substr($periode,0,2);
		$tahun = substr($periode,3,4);
		/*            
		$query = DB::SELECT("
			SELECT sup.KODES,sup.NAMAS,supd.AW$bulan as AW,supd.MA$bulan as MA, 
			supd.KE$bulan as KE,supd.LN$bulan as LN,supd.AK$bulan as AK 
			from sup,supd 
			WHERE sup.KODES=supd.KODES and supd.YER='$tahun';
		");
		*/        
		
		$queryakum = DB::SELECT("SET @tglx:=last_day(concat('$tahun','-','$bulan','-01'));");
		$query = DB::SELECT("
		SELECT '$periode'as PERIOD, supd.KODES, supd.NAMAS, supd.NO_ID, 
		supd.AW$bulan as AW, supd.MA$bulan as MA, 
		supd.KE$bulan as KE, supd.LN$bulan as LN, supd.ak$bulan as AK,
		coalesce(xxx.SATU,0) SATU, coalesce(xxx.DUA,0) DUA, coalesce(xxx.TIGA,0) TIGA,
		coalesce(xxx.SATU,0)+coalesce(xxx.DUA,0)+coalesce(xxx.TIGA,0) as SALDO 
		from sup,supd 
		left join 
		(
		    SELECT KODES, sum(if(DATEDIFF(@tglx,TGL)<30,belix.PER$bulan-belix.PERB$bulan,0)) as SATU,
		    sum(if(DATEDIFF(@tglx,TGL)BETWEEN 30 and 60,belix.PER$bulan-belix.PERB$bulan,0)) as DUA,
		    sum(if(DATEDIFF(@tglx,TGL)>60,belix.PER$bulan-belix.PERB$bulan,0)) as TIGA 
		    from belix 
		    where belix.YER='$tahun' and belix.PER$bulan-belix.PERB$bulan<>0
		    GROUP BY KODES
		) as xxx on supd.KODES=xxx.KODES
		where sup.KODES = supd.KODES 
		#and sup.kodes >=@kodes1 and sup.kodes<=@kodes2 
		and supd.YER='$tahun' and ( supd.AW$bulan<>0 or supd.MA$bulan<>0 or supd.KE$bulan<>0 or supd.LN$bulan<>0 or supd.AK$bulan<>0 )
		$filtergol
		order by sup.KODES;
		");

		$per = Perid::query()->get();
		session()->put('filter_gol', $request->gol);
		session()->put('filter_per', $periode);
		if($request->has('filter'))
		{
			return view('oreport_sup.report')->with(['per' => $per])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'AW' => $query[$key]->AW,
				'MA' => $query[$key]->MA,
				'KE' => $query[$key]->KE,
				'LN' => $query[$key]->LN,
				'AK' => $query[$key]->AK,
				'SATU' => $query[$key]->SATU,
				'DUA' => $query[$key]->DUA,
				'TIGA' => $query[$key]->TIGA,
				'SALDO' => $query[$key]->SALDO,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
