@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kartu Stok Bahan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Kartu Stok Bahan</li>
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
                    <form method="POST" action="{{url('jasper-stok-kartu-st')}}">
                    @csrf
                    <div class="form-group row">

                        <div class="col-md-1" align="right"><strong>Barang :</strong></div>
                        <div class="col-md-2">
                            <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Kode" value="{{ session()->get('filter_kdbrg1') }}" >                      
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama" value="{{ session()->get('filter_nabrg1') }}" readonly >
                        </div>
                    </div>
                    
                    
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
                    <button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter" onclick="window.location='{{url("rkarstk")}}'">Reset</button>
                    <button class="btn btn-warning" type="submit" id="cetak" class="cetak" formtarget="_blank">Cetak</button>
                    </form>
                    <div style="margin-bottom: 15px;"></div>
                    
                    <!-- PASTE DIBAWAH INI -->
                    <!-- DISINI BATAS AWAL KOOLREPORT-->
                    <div class="report-content">
                        <?php
                        use \koolreport\datagrid\DataTables;

                        if($hasil)
                        {
                            DataTables::create(array(
                                "dataSource" => $hasil,
                                "name" => "example",
                                "fastRender" => true,
                                "fixedHeader" => true,
                                "showFooter" => true,
                                "showFooter" => "bottom",
                                "columns" => array(
                                    "NO_BUKTI" => array(
                                        "label" => "Bukti"
                                    ),
                                    "TGL" => array(
                                        "label" => "Tgl",
                                        "type"=>"datetime",
                                        "format"=>"Y-m-d",
                                        "displayFormat"=>"d/m/Y" ,
                                    ),
                                    "KD_BRG" => array(
                                        "label" => "Barang#"
                                    ),
                                    "NA_BRG" => array(
                                        "label" => "-"
                                    ),
                                    "URAIAN" => array(
                                        "label" => "Uraian",
                                        "footerText"=>"Grand Total :",
                                    ),
                                    "AWAL" => array(
                                        "label" => "Awal",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                    ),
                                    "MASUK" => array(
                                        "label" => "Masuk",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                    ),
                                    "KELUAR" => array(
                                        "label" => "Keluar",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                    ),
                                    "LAIN" => array(
                                        "label" => "Lain",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                    ),
                                    "SALDO" => array(
                                        "label" => "Saldo",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
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
                                            "targets" => [5,6,7,8],
                                        ),
                                    ),
                                    "order" => [],
                                    "paging" => true,
                                    "searching" => true,
                                    "colReorder" => true,
                                    "fixedHeader" => true,
                                    "select" => true,
                                    "showFooter" => true,
                                    "showFooter" => "bottom",
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
                                )
                            ));
                        }
                        ?>
                    </div>
                   
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
	
	
	<div class="modal fade" id="browseBarangModal" tabindex="-1" role="dialog" aria-labelledby="browseBarangModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBarangModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bbarang">
				<thead>
					<tr>
						<th>Item#</th>
						<th>Nama</th>
						
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
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {

		$('.date').datepicker({  
			dateFormat: 'dd-mm-yy'
		}); 
		
		var dTableBBarang;
		var rowidBarang;
		loadDataBBarang = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('brg_st/browse')}}",
				data: 
				{
				     KD_BRG : $('#KD_BRG').val(),		   
				},
				
				
				success: function( response )
				{
					resp = response;
					if(dTableBBarang){
						dTableBBarang.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBarang.row.add([
							'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+
							'\',\''+resp[i].NA_BRG+'\',\''+resp[i].SATUAN+
							'\' )">'+resp[i].KD_BRG+'</a>',
							resp[i].NA_BRG,
							resp[i].SATUAN,
						
						]);
					}
					dTableBBarang.draw();
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});
		
		browseBarang = function(){
			loadDataBBarang();
			$("#browseBarangModal").modal("show");
		}
		
		chooseBarang = function(KD_BRG, NA_BRG, SATUAN ){
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);
			$("#browseBarangModal").modal("hide");
		}
		
		
		$("#KD_BRG").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(0);
			}
		}); 
		
		
    });
    
   

</script>
@endsection

