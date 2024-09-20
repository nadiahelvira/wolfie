<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Brg;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RStockaController extends Controller
{

    public function report()
    {
		$kd_brg = Brg::query()->get();
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		session()->put('filter_type', '');

        return view('oreport_stocka.report')->with(['kd_brg' => $kd_brg])->with(['hasil' => []]);
    }
	
	public function getStockaReport(Request $request)
    {
			
 		$query = DB::table('stocka')
		->select('NO_BUKTI', 'TGL', 'KD_BRG', 'NA_BRG', 'KG', 'NOTES')->get();
		
					
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            		$tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
    			$tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			
			if (!empty($request->kd_brg))
			{
				$query = $query->where('KD_BRG', $request->kd_brg);
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmp]);
			}
			
			return Datatables::of($query)->addIndexColumn()->make(true);
		}
		
    }	  
	 
	public function jasperStockaReport(Request $request) 
	{
		$file 	= 'stockn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            		$tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            		$tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
            $filterkdbrg='';
			if (!empty($request->kd_brg))
			{
				$filterkdbrg = " and KD_BRG='".$request->kd_brg."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$filtertgl = " where TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
            $filtertype='';
			if (!empty($request->type))
			{
				$filtertype = " and TYPE='".$request->type."' ";
			}

			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_posted', $request->posted);
			session()->put('filter_type', $request->type);
		
		$query = DB::SELECT("
		    SELECT NO_BUKTI, TGL, KD_BRG, NA_BRG, KG, NOTES 
            from stocka
            $filtertgl $filterkdbrg $filtertype;
		");

		if($request->has('filter'))
		{
			return view('oreport_stocka.report')->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'KG' => $query[$key]->KG,
				'NOTES' => $query[$key]->NOTES,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
