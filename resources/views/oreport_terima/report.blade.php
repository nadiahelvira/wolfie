@extends('layouts.main')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Laporan Terima Gudang </h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active">Laporan Terima Gudang </li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content">
		<div class="container-fluid">
		<div class="row">
			<div class="col-12">
			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{url('jasper-terima-report')}}">
					@csrf
					<div class="form-group row">


						<div class="col-md-2">						
							<label class="form-label">Suplier</label>
							<input type="text" class="form-control kodes" id="kodes" name="kodes" placeholder="Pilih Suplier" value="{{ session()->get('filter_kodes1') }}" readonly>
						</div>  
						<div class="col-md-3">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS" placeholder="Nama" value="{{ session()->get('filter_namas1') }}" readonly>
						</div>
					</div>
					
					
					<!-- Filter Tanggal -->
					<div class="form-group row">
						<div class="col-md-3">
							<input class="form-control date tglDr" id="tglDr" name="tglDr"
							type="text" autocomplete="off" value="{{ session()->get('filter_tglDari') }}"> 
						</div>
						<div>s.d.</div> 
						<div class="col-md-3">
							<input class="form-control date tglSmp" id="tglSmp" name="tglSmp"
							type="text" autocomplete="off" value="{{ session()->get('filter_tglSampai') }}">
						</div>
					</div>
					
                    <button class="btn btn-primary" type="submit" id="filter" class="filter" name="filter">Filter</button>
                    <button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter" onclick="window.location='{{url("rterima")}}'">Reset</button>
					<button class="btn btn-warning" type="submit" id="cetak" class="cetak" formtarget="_blank">Cetak</button>
					</form>
					<div style="margin-bottom: 15px;"></div>
					<!--
					<table class="table table-fixed table-striped table-border table-hover nowrap datatable">
						<thead class="table-dark">
							<tr>
								<th scope="col" style="text-align: center">#</th>
								<th scope="col" style="text-align: left">Bukti#</th>
								<th scope="col" style="text-align: left">Tgl</th>
								<th scope="col" style="text-align: left">SO#</th>
								<th scope="col" style="text-align: left">Customer#</th>
								<th scope="col" style="text-align: left">-</th>
								<th scope="col" style="text-align: left">Barang</th>
								<th scope="col" style="text-align: left">-</th>
								<th scope="col" style="text-align: right">Kg</th>
								<th scope="col" style="text-align: right">Harga</th>
								<th scope="col" style="text-align: right">Total</th>
							</tr>
						</thead>
						<tbody>
						</tbody> 
					</table> -->
					
                    <!-- PASTE DIBAWAH INI -->
                    <!-- DISINI BATAS AWAL KOOLREPORT-->
                    <div class="report-content" col-md-12>
                        <?php
                        use \koolreport\datagrid\DataTables;

                        if($hasil)
                        {
                            DataTables::create(array(
                                "dataSource" => $hasil,
                                "name" => "example",
                                "fastRender" => true,
                                "fixedHeader" => true,
                                'scrollX' => true,
                                "showFooter" => true,
                                "showFooter" => "bottom",
                                "columns" => array(
                                    "NO_BUKTI" => array(
                                        "label" => "Bukti#",
                                    ),
                                    "TGL" => array(
                                        "label" => "Tanggal",
                                    ),
                                    "NO_BL" => array(
                                        "label" => "Beli#",
                                    ),
                                    "NO_PO" => array(
                                        "label" => "PO#",
                                    ),
                                    "KODES" => array(
                                        "label" => "Suplier#",
                                    ),
                                    "NAMAS" => array(
                                        "label" => "-",
                                    ),

                                    "KD_BRG" => array(
                                        "label" => "Barang#",
                                    ),
                                    "NA_BRG" => array(
                                        "label" => "-",
                                        "footerText" => "<b>Grand Total :</b>",
                                    ),
									"TRUCK" => array(
                                        "label" => "Truck#",
                                    ),
                                    "KG1" => array(
                                        "label" => "Kg1",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "SUSUT" => array(
                                        "label" => "Susut",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "KG" => array(
                                        "label" => "Kg",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
									
                                    "RPRATE" => array(
                                        "label" => "Rprate",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "RPTOTAL" => array(
                                        "label" => "RpTotal",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
									
									"AJU" => array(
                                        "label" => "AJU#",
                                    ),
                                    "EMKL" => array(
                                        "label" => "Emkl",
                                    ),
									"BL" => array(
                                        "label" => "BL#",
                                    ),
                                    "GUDANG" => array(
                                        "label" => "Gudang",
                                    ),
									"NO_CONT" => array(
                                        "label" => "Comt#",
                                    ),
                                    "SEAL" => array(
                                        "label" => "Seal",
                                    ),
									
                                ),
                                "cssClass" => array(
                                    "table" => "table table-hover table-striped table-bordered compact",
                                    "th" => "label-title",
                                    "td" => "detail",
                                    "tf" => "footerCss"
                                ),
                                "options" => array(
                                    "columnDefs"=>array(
                                        array(
                                            "className" => "dt-right", 
                                            "targets" => [8,9,10],
                                        ),
                                    ),
                                    "order" => [],
                                    "paging" => true,
                                    // "pageLength" => 12,
                                    "searching" => true,
                                    "colReorder" => true,
                                    "select" => true,
                                    "dom" => 'Blfrtip', // B e dilangi
                                    // "dom" => '<"row"<col-md-6"B><"col-md-6"f>> <"row"<"col-md-12"t>><"row"<"col-md-12">>',
                                    "buttons" => array(
                                        array(
                                            "extend" => 'collection',
                                            "text" => 'Export',
                                            "buttons" => [
                                                'copy',
                                                'excel',
                                                'csv',
                                                'pdf',
                                                'print'
                                            ],
                                        ),
                                    ),
                                ),
                            ));
                        }
                        ?>
                    </div>
                    <!-- DISINI BATAS AKHIR KOOLREPORT-->

				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>

<div class="modal fade" id="browseSupModal" tabindex="-1" role="dialog" aria-labelledby="browseSupModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="browseCustModalLabel">Cari Suplier</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-sup">
				<thead>
					<tr>
						<th>Suplier#</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Kota</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>

@endsection

@section('javascripts')
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>
<script>
	$(document).ready(function() {
		
		$('.date').datepicker({  
			dateFormat: 'dd-mm-yy'
		}); 
		
	});
	
	var dTableSup;
	loadDataSup = function(){
	
		$.ajax(
		{
			type: 'GET', 		
			url: "{{url('sup/browse')}}",
			data: {
				'GOL': 'Y',
			},
			success: function( response )
			{
				resp = response;
				if(dTableSup){
					dTableSup.clear();
				}
				for(i=0; i<resp.length; i++){
					
					dTableSup.row.add([
						'<a href="javascript:void(0);" onclick="chooseCust(\''+resp[i].KODES+'\',  \''+resp[i].NAMAS+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODES+'</a>',
						resp[i].NAMAS,
						resp[i].ALAMAT,
						resp[i].KOTA,
					]);
				}
				dTableSup.draw();
			}
		});
	}
	
	dTableSup = $("#table-sup").DataTable({
		
	});
	
	browseSup = function(){
		loadDataSup();
		$("#browseSupModal").modal("show");
	}
	
	chooseCust = function(KODES, NAMAS, ALAMAT, KOTA){
		$("#kodes").val(KODES);
		$("#NAMAS").val(NAMAS);	
		$("#browseSupModal").modal("hide");
	}
	
	$("#kodes").keypress(function(e){
		if(e.keyCode == 46){
			e.preventDefault();
			browseSup();
		}
	}); 
	
	
	
</script>
@endsection
