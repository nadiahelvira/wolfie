<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Master\Sup;
use App\Models\Master\Perid;

use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RKartuhController extends Controller
{

    public function kartu()
    {
		$sup = Sup::where('KODES', '<>','ZZ')->get();
		$per = Perid::query()->get();
		session()->put('filter_kodes1', '');
		session()->put('filter_namas1', '');
		session()->put('filter_tglDari', date("d-m-Y"));
		session()->put('filter_tglSampai', date("d-m-Y"));
		
        return view('oreport_hut.kartu')->with(['per' => $per])->with(['hasil' => []]);
    }
 
	 
	public function sisa()
    {
		$sup = Sup::where('KODES', '<>','ZZ')->get();
		$per = Perid::query()->get();
				
		session()->put('filter_kodes', '');
		session()->put('filter_namas', '');
		// session()->put('filter_tglDari', date("d-m-Y"));
		// session()->put('filter_tglSampai', date("d-m-Y"));
		session()->put('filter_periode', session()->get('periode')['bulan']. '/' . session()->get('periode')['tahun']);
		session()->put('filter_flag', '');
		
        return view('oreport_hut.sisa')->with(['per' => $per])->with(['hasil' => []]);
    }
	
	

	public function jasperHutSisaReport(Request $request) 
	{
		$file 	= 'sisah';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			$periode = date("m/Y", strtotime($request['tglDr']));
			$bulan = date("m", strtotime($request['tglDr']));
			$tahun = date("Y", strtotime($request['tglDr']));
			$tgawal = $tahun.'-'.$bulan.'-01';
			
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
			if(!empty($request->perio))
			{
				$periode = $request->perio;
			}
			$bulan = substr($periode,0,2);
			$tahun = substr($periode,3,4);
			
			$filterkodes1='';
			if (!empty($request->KODES))
			{
				$filterkodes1 = " and KODES='".$request->KODES."' ";
			}
			
			
			//session()->put('filter_gol', $request->gol);
			session()->put('filter_kodes', $request->KODES);
			session()->put('filter_namas', $request->NAMAS);
			// session()->put('filter_tglDari', $request->tglDr);
			// session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_perio', $request->perio);
			session()->put('filter_lebih30', $request->lebih30);
			session()->put('filter_flag', $request->flag);

		$query = DB::SELECT("
        	SELECT NO_BUKTI, TGL, trim(KODES) as KODES, NAMAS, (PER$bulan-PERB$bulan) as SISA, FLAG
			from bh_belix WHERE PER$bulan-PERB$bulan<>0 $filterkodes 
			order by KODES,NO_BUKTI;
		");
		
		
		
				
		$per = Perid::query()->get();
		session()->put('filter_per', $periode);
		
		if($request->has('filter'))
		{
			return view('oreport_hut.sisa')->with(['per' => $per])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => date("d/m/Y", strtotime($query[$key]->TGL)),
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'TOTAL' => $query[$key]->SISA,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
	public function jasperHutKartu(Request $request) 
	{
		
		$file 	= 'kartuh';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            		$tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            		$tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			//$periode = date("m/Y", strtotime($request['tglDr']));
			//$bulan = date("m", strtotime($request['tglDr']));
			//$tahun = date("Y", strtotime($request['tglDr']));
			$tgawal = $tahun.'-'.$bulan.'-01';
			
			$periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
     		$bulan = substr($periode,0,2);
	    	$tahun = substr($periode,3,4);
		
			$sup_bh = '';
			$filterkodes1='';
			if (!empty($request->KODES))
			{
				$filterkodes1 = " and KODES='".$request->KODES."' ";
			}

			//session()->put('filter_gol', $request->gol);
			session()->put('filter_kodes', $request->KODES);
			session()->put('filter_namas', $request->NAMAS);
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
		
		$queryakum = DB::SELECT("SET @akum:=0;");
		$query = DB::SELECT("
        	SELECT *,@akum:=@akum+TOTAL-BAYAR SALDO from
		(

			SELECT NO_BUKTI, TGL, KODES, NAMAS, PER$bulan AS TOTAL, 0 AS BAYAR 
			from bh_belix where bh_belix.YER='$tahun' and PER$bulan<>0 $filterbelix union all

			SELECT NO_BUKTI, TGL, KODES, NAMAS, 0 AS TOTAL, BAYAR  
			from bh_hut where PER='$periode' $filter_kodes1
			
		) as  kartuh;
		");


		
		$per = Perid::query()->get();
		session()->put('filter_per', $periode);
		
		if($request->has('filter'))
		{
			return view('oreport_hut.kartu')->with(['per' => $per])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODES' => $query[$key]->KODES,
				'NAMAS' => $query[$key]->NAMAS,
				'TOTAL' => $query[$key]->TOTAL,
				'BAYAR' => $query[$key]->BAYAR,
				'SALDO' => $query[$key]->SALDO,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}

}
