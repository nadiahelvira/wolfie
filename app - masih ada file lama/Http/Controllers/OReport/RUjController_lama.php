<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Cust;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class RUjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function report()
    {
// GANTI 3 //
		$kodec = Cust::orderBy('KODEC')->get();
		//return $acno;
// GANTI 3 //
        return view('oreport_uj.report')->with(['kodec' => $kodec]);
		
    }
	
		public function getUjReport(Request $request)
    {
        $query = DB::table('jual')
			->select('NO_BUKTI','TGL','NO_SO', 'KODEC','NAMAC','BACNO', 'BNAMA', 'TOTAL1', 'NOTES', 'GOL' )->where('FLAG', 'UJ')->get();
			
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			if (!empty($request->GOL))
			{
				$query = $query->where('GOL', $request->GOL);
			}
			
			if (!empty($request->kodec))
			{
				$query = $query->where('KODEC', $request->KODEC);
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmp]);
			}
			
			return Datatables::of($query)->addIndexColumn()->make(true);
		}
		
    }	  
	 	 
	 


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


	
	public function jasperUjReport(Request $request) 
	{
		$file 	= 'ujn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		$tglDrD = date("Y-m-d", strtotime($request->tglDr));
		$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
		$acno = $request->acno;
		
		$query = DB::SELECT("
			SELECT bank.NO_BUKTI,bank.TGL,bankd.DEBET,bankd.KREDIT,bankd.ACNO,bankd.NACNO 
			FROM bank, bankd 
			WHERE bank.NO_BUKTI=bankd.NO_BUKTI and bank.BACNO='$acno' and bank.TGL between '$tglDrD' and '$tglSmpD' 
			ORDER BY bank.NO_BUKTI;
		");

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'DEBET' => $query[$key]->DEBET,
				'KREDIT' => $query[$key]->KREDIT,
				'ACNO' => $query[$key]->ACNO,
				'URAIAN' => $query[$key]->NACNO,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	

	
}
