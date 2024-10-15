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

   public function report(Request $request)
    {
		
		
		$tglx1 = '01-'.$request->session()->get('periode')['bulan'].'-'.$request->session()->get('periode')['tahun'] ;
        $d1 = '31';
		
		$bulan = $request->session()->get('periode')['bulan'];
		$tahun = $request->session()->get('periode')['tahun'];

		
		if ( $bulan=='04'  OR  $bulan=='06'  OR  $bulan=='09'  OR  $bulan=='11'  )
		{
			$d1 = '30';
		}
		
		if ( $bulan=='02' )
		{	
		     if ( fmod($tahun,4) == 0 )
				 $d1 = '29';
			 else
				 $d1 = '28';
		    
        }

		$tglx2 = $d1.'-'.$request->session()->get('periode')['bulan'].'-'.$request->session()->get('periode')['tahun'] ;

        

		session()->put('filter_kodes1', '');
		session()->put('filter_namas1', '');
		session()->put('filter_tglDari', $tglx1);
		session()->put('filter_tglSampai', $tglx2);


        return view('oreport_beli.report')->with(['hasil' => []]);
    }
	
	 
	public function jasperBeliReport(Request $request) 
	{
		
		$file 	= 'belin';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter

			if (!empty($request->kd_brg))
			{
				$filterkd_brg = " and BELID.KD_BRG='".$request->kd_brg."' ";
			}
			
			if (!empty($request->KODES))
			{
				$filterkodes = " and BELI.KODES='".$request->KODES."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " AND BELI.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}	

			if (!empty($request->FLAG))
			{
				$filterflag = " and BELI.FLAG ='".$request->FLAG."' ";
			}
			

			
		    $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
		    $filter_periode = ' and BELI.PER ='.$periode;
			

	
			session()->put('filter_kodes1', $request->KODES);
			session()->put('filter_namas1', $request->NAMAS);
			session()->put('filter_tglDari', $request->tglDr);
			session()->put('filter_tglSampai', $request->tglSmp);
			session()->put('filter_flag', $request->FLAG);	
			
			
			
		
		$query = DB::SELECT("
			SELECT BELI.NO_BUKTI, BELI.TGL, 
			BELI.KODES, BELI.NAMAS, BELId.KD_BRG, 
			BELId.NA_BRG, BELID.SATUAN, BELId.QTY, 
			BELId.HARGA, BELId.TOTAL  from BELI, BELId WHERE 
			BELI.NO_BUKTI=BELId.NO_BUKTI $filtertgl	
			$filterkodes $filterflag  ");	
			
			

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