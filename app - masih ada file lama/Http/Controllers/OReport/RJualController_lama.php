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

// ganti 2
class RJualController extends Controller
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
        return view('oreport_jual.report')->with(['kodec' => $kodec]);
		
    }
	
		public function getJualReport(Request $request)
    {
        $query = DB::table('jual')
			->join('juald', 'jual.NO_BUKTI', '=', 'juald.NO_BUKTI')
			->select('jual.NO_BUKTI','jual.TGL','jual.NO_JUAL', 'jual.KODEC','jual.NAMAC','juald.KD_BRG','juald.NA_BRG','jual.TOTAL_QTY','juald.HARGA','jual.TOTAL')->get();
			
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			if (!empty($request->gol))
			{
				$query = $query->where('GOL', $request->gol);
			}
			
			if (!empty($request->kodec))
			{
				$query = $query->where('KODEC', $request->kodec);
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmpD]);
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


	public function jasperJualReport(Request $request) 
	{
		$file 	= 'jual';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
	
			// Check Filter
			if (!empty($request->gol))
			{
				$filtergol = " and jual.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodec))
			{
				$filterkodec = " and jual.KODEC='".$request->kodec."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " and hut.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
		$query = DB::SELECT("
			SELECT jual.NO_BUKTI,jual.TGL,jual.NO_JUAL, jual.KODEC,jual.NAMAC,juald.KD_BRG,juald.NA_BRG,jual.TOTAL_QTY,juald.HARGA,jual.TOTAL,jual.GOL from juald,juald WHERE jual.NO_BUKTI=jual.NO_BUKTI $filtertgl $filtergol $filterkodec /*order by jual.KODEC,jual.NO_BUKTI*/;
		");
		

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KODEC' => $query[$key]->KODEC,
				'NAMAC' => $query[$key]->NAMAC,
				'NO_JUAL' => $query[$key]->NO_JUAL,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'TOTAL_QTY' => $query[$key]->TOTAL_QTY,
				'HARGA' => $query[$key]->HARGA,
				'TOTAL' => $query[$key]->TOTAL,
				'GOL' => $query[$key]->GOL,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}

	

	
}
