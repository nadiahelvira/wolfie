<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Master\Brg;
// ganti 1

use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

// ganti 2
class RKarstkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function kartu()
    {
		session()->put('filter_brg1', '');
		session()->put('filter_nabrg1', '');
		session()->put('filter_brg2', '');
		session()->put('filter_nabrg2', '');
		session()->put('filter_tglDr', now()->format('d-m-Y'));
		session()->put('filter_tglSmp', now()->format('d-m-Y'));
		$brg = Brg::orderBy('KD_BRG', 'ASC')->get();
// GANTI 3 //
        return view('oreport_brg.kartu')->with(['brg' => $brg])->with(['hasil' => []]);
		
    }
	


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function jasperStokKartu(Request $request) 
	{
		$file 	= 'karstk';
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
			$filterbrg = " AND KD_BRG<>'' " ;
			$filterterima = " AND jl_terimad.KD_BRG<>'' " ;
			$filterjual = " AND jl_juald.KD_BRG<>'' " ;
			$filterstockb = " AND jl_stockd.KD_BRG<>'' " ;
			$filtersurat = " AND jl_suratd.KD_BRG<>'' " ;
		
			if($request->KD_BRG)
			{
				$filterbrg = " AND KD_BRG = '".$request->KD_BRG."'  " ;
				$filterterima = " AND jl_terimad.KD_BRG = '".$request->KD_BRG."' " ;
				$filterjual = " AND jl_juald.KD_BRG = '".$request->KD_BRG."' " ;
				$filterstockb = " AND jl_stockd.KD_BRG = '".$request->KD_BRG."'  " ;
				$filtersurat = " AND jl_suratd.KD_BRG = '".$request->KD_BRG."'  " ;

			}
            $tgawal = $tahun.'-'.$bulan.'-01';
		

		$queryakum = DB::SELECT("SET @akum:=0;");
		$query = DB::SELECT("
        	SELECT *, if(@kdbrg<>KD_BRG,@akum:=AWAL+MASUK-KELUAR,@akum:=@akum+AWAL+MASUK-KELUAR) as SALDO,@kdbrg:=KD_BRG as ganti, URUTAN from
		(
			SELECT ' ' AS NO_BUKTI, '$tglDrD'  AS TGL, KD_BRG AS KD_BRG, NA_BRG AS NA_BRG, 
			'SALDO AWAL' URAIAN, 
			SUM(AWAL) AS AWAL, 0 MASUK, 0 KELUAR, 0 AS LAIN, 1 as URUTAN
			from
			(
				SELECT KD_BRG AS KD_BRG, NA_BRG AS NA_BRG, AW$bulan AS AWAL 
				from jl_brgd WHERE YER='$tahun' $filterbrg
				
				UNION ALL
				
				SELECT jl_terimad.KD_BRG, jl_terimad.NA_BRG, 
				jl_terimad.QTY AS AWAL 
				from jl_terima, jl_terimad where jl_terima.NO_BUKTI = jl_terimad.NO_BUKTI 
				and jl_terima.TGL<'$tglDrD' 
				$filterterima and jl_terima.PER='$periode' and 
				jl_terima.FLAG ='HP' and jl_terimad.QTY <> 0 
				
				union all
				
				SELECT jl_terimad.KD_BRG, jl_terimad.NA_BRG, 
				( jl_terimad.QTY * -1 ) AS AWAL 
				from jl_terima, jl_terimad where jl_terima.NO_BUKTI = jl_terimad.NO_BUKTI 
				and jl_terima.TGL<'$tglDrD' 
				$filterterima and jl_terima.PER='$periode' and 
				jl_terima.FLAG <> 'HP' and jl_terimad.QTY <> 0 

				union all

				SELECT jl_juald.KD_BRG, jl_juald.NA_BRG, 
				jl_juald.QTY * -1  AS AWAL 
				from jl_jual, jl_juald where jl_jual.NO_BUKTI = jl_juald.NO_BUKTI 
				and jl_jual.TGL<'$tglDrD' 
				$filterjual and jl_jual.PER='$periode' 
				and jl_juald.QTY <> 0 

				union all

				SELECT jl_suratd.KD_BRG, jl_suratd.NA_BRG, 
				jl_suratd.QTY * -1  AS AWAL 
				from jl_surat, jl_suratd where jl_surat.NO_BUKTI = jl_suratd.NO_BUKTI 
				and jl_surat.TGL<'$tglDrD' 
				$filtersurat and jl_surat.PER='$periode' 
				and jl_suratd.QTY <> 0 
				
				
				union all

				SELECT jl_stockd.KD_BRG, jl_stockd.NA_BRG, 
				jl_stockd.QTY AS AWAL 
				from jl_stock, jl_stockd where jl_stock.NO_BUKTI = jl_stockd.NO_BUKTI 
				and jl_stock.TGL<'$tglDrD' 
				$filterstock and jl_stock.PER='$periode' 
				and jl_stockd.QTY <> 0 

				
			) as AWAL00
			group by KD_BRG
			
			UNION ALL

			SELECT jl_terima.NO_BUKTI, jl_terima.TGL, jl_terimad.KD_BRG, jl_terimad.NA_BRG,
			'HASIL PRODUKSI' AS URAIAN, 
			0 AWAL, jl_terimad.QTY AS MASUK, 0 AS KELUAR, 
			0 AS LAIN,  2 as URUTAN 
			from jl_terima, jl_terimad where 
			jl_terima.NO_BUKTI = jl_terimad.NO_BUKTI and
			jl_terima.TGL BETWEEN '$tglDrD' and '$tglSmpD' $filterterima 
			and jl_terimad.QTY <> 0 and jl_terima.FLAG ='HP' and jl_terima.PER='$periode' 
		
			UNION ALL

			SELECT jl_terima.NO_BUKTI, jl_terima.TGL, jl_terimad.KD_BRG, jl_terimad.NA_BRG,
			'RETUR HASIL PRODUKSI' AS URAIAN, 
			0 AWAL, 0 AS MASUK, jl_terimad.QTY AS KELUAR, 
			0 AS LAIN,  2 as URUTAN 
			from jl_terima, jl_terimad where 
			jl_terima.NO_BUKTI = jl_terimad.NO_BUKTI and
			jl_terima.TGL BETWEEN '$tglDrD' and '$tglSmpD' $filterterima 
			and jl_terimad.QTY <> 0 and jl_terima.FLAG <>'HP' and jl_terima.PER='$periode' 
			

			UNION ALL

			SELECT jl_surat.NO_BUKTI, jl_surat.TGL, jl_suratd.KD_BRG, jl_suratd.NA_BRG,
			'SURAT JALAN' AS URAIAN, 
			0 AWAL, 0 AS MASUK, jl_suratd.QTY AS KELUAR, 
			0 AS LAIN,  2 as URUTAN
			from jl_surat, jl_suratd where 
			jl_surat.NO_BUKTI = jl_suratd.NO_BUKTI and
			jl_surat.TGL BETWEEN '$tglDrD' and '$tglSmpD' $filtersurat 
			and jl_suratd.QTY <> 0 and jl_surat.PER='$periode' 
			
			UNION ALL

			SELECT jl_jual.NO_BUKTI, jl_jual.TGL, jl_juald.KD_BRG, jl_juald.NA_BRG,
			'PENJUALAN' AS URAIAN, 
			0 AWAL, 0 AS MASUK, jl_juald.QTY AS KELUAR, 
			0 AS LAIN,  2 as URUTAN 
			from jl_jual, jl_juald where 
			jl_jual.NO_BUKTI = jl_juald.NO_BUKTI and
			jl_jual.TGL BETWEEN '$tglDrD' and '$tglSmpD' $filterjual 
			and jl_juald.QTY <> 0 and jl_jual.PER='$periode' 
			
			UNION ALL

			SELECT jl_stock.NO_BUKTI, jl_stock.TGL, jl_stockd.KD_BRG, jl_stockd.NA_BRG,
			'KOREKSI STOCK ' AS URAIAN, 
			0 AWAL, 0 AS MASUK, jl_stockd.QTY AS KELUAR, 
			0 AS LAIN,  2 as URUTAN 
			from jl_stock, jl_stockd where 
			jl_stock.NO_BUKTI = jl_stockd.NO_BUKTI and
			jl_stock.TGL BETWEEN '$tglDrD' and '$tglSmpD' $filterstock 
			and jl_stockd.QTY <> 0 and jl_stock.PER='$periode' 
			

			
			order by KD_BRG, TGL, NO_BUKTI, URUTAN ASC
			
		) as kartustok  ;
		");

		$brg = Brg::where('KD_BRG', '<>','ZZ')->get();
		if($request->has('filter'))
		{
			return view('oreport_brg.kartu')->with(['brg' => $brg])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KD_BRG' => $query[$key]->KD_BRG,
				'NA_BRG' => $query[$key]->NA_BRG,
				'URAIAN' => $query[$key]->URAIAN,
				'AWAL' => $query[$key]->AWAL,
				'MASUK' => $query[$key]->MASUK,
				'KELUAR' => $query[$key]->KELUAR,
				'LAIN' => $query[$key]->LAIN,
				'AKHIR' => $query[$key]->SALDO,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
