	@extends('layouts.main')

	@section('content')
	<div class="content-wrapper">
		<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Laporan Perincian Bahan Baku</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active">Laporan Perincian Bahan Baku </li>
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
					    <form method="POST" action="{{url('jasper-brg-st-report')}}">
					    @csrf
						<div class="form-group nowrap">
							<label><strong>Periode :</strong></label>
							 <select name="perio" id="perio" class="form-control perio" style="width: 200px">
								<option value="">--Pilih Periode--</option>
								@foreach($per as $perD)
									<option value="{{$perD->PERIO}}" {{ session()->get('filter_per')== $perD->PERIO ? 'selected' : '' }}>{{$perD->PERIO}}</option>
								@endforeach
							</select> 
							<!--
							<select name="acno" id="acno" class="form-control acno" style="width: 200px">
								<option value="">--Pilih Bahan--</option>
								<option value="1000">Kas</option>
								<option value="1100">Bank</option>
							</select>
							-->
						</div>
						<button class="btn btn-primary" type="submit" id="filter" class="filter" name="filter">Filter</button>
						<button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter" onclick="window.location='{{url("rbrg_st")}}'">Reset</button>
						<button class="btn btn-warning" type="submit" id="cetak" class="cetak" formtarget="_blank">Cetak</button>
						</form>
						<div style="margin-bottom: 15px;"></div>
		
						
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
                                    "KD_BRG" => array(
                                        "label" => "Barang#",
                                    ),
                                    "NA_BRG" => array(
                                        "label" => "-",
                                        "footerText" => "<b>Grand Total :</b>",
                                    ),
                                    "AW" => array(
                                        "label" => "Awal",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "MA" => array(
                                        "label" => "Masuk",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "KE" => array(
                                        "label" => "Keluar",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "LN" => array(
                                        "label" => "Lain",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "AK" => array(
                                        "label" => "Akhir",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "HRT" => array(
                                        "label" => "H-Rata",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "HRT_2" => array(
                                        "label" => "H-Rata 2",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "NIW" => array(
                                        "label" => "N-Awal",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "NIM" => array(
                                        "label" => "N-Masuk",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "NIK" => array(
                                        "label" => "N-Keluar",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "NIL" => array(
                                        "label" => "N-Lain",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "NIR" => array(
                                        "label" => "N-Akhir",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
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
                                            "targets" => [2,3,4,5,6,7,8,9,10,11,12,13],
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
	@endsection

	@section('javascripts')
	<script>

	</script>
	@endsection

