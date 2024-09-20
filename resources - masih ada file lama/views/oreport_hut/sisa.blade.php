@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sisa Hutang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Sisa Hutang</li>
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
                    <form method="POST" action="{{url('jasper-hutsisa-report')}}">
                    @csrf
                        <div class="form-group row">
							<div class="col-md-2">
                                <label><strong>Periode :</strong></label>
                                <input type="text" class="form-control perio" id="perio" name="perio" placeholder="mm/yyyy" value="{{ session()->get('filter_perio') }}">
							</div>
							<div class="col-md-2">
								<label><strong>Jenis :</strong></label>
								
								<select name="flag" id="flag" class="form-control flag">
								    <option value="">Semua</option>
									<option value="BELI" {{ session()->get('filter_flag')=='BELI' ? 'selected': ''}}>Beli</option>
									<option value="UM" {{ session()->get('filter_flag')=='UM' ? 'selected': ''}}>UM</option>
									<option value="THUT" {{ session()->get('filter_flag')=='THUT' ? 'selected': ''}}>T.Hut</option>
								</select>
							</div>
                        </div>
						
						<div class="form-group row">
							<div class="col-md-1">
								<label><strong>Gol :</strong></label>
								
								<select name="gol" id="gol" class="form-control gol">
									<option value="Y" {{ session()->get('filter_gol')=='Y' ? 'selected': ''}}>Y</option>
									<option value="Z" {{ session()->get('filter_gol')=='Z' ? 'selected': ''}}>Z</option>
								</select>
							</div>
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
						<!-- <div class="form-group row">
							<div class="col-md-3">
								<input class="form-control date tglDr" id="tglDr" name="tglDr"
								type="text" autocomplete="off" value="{{ session()->get('filter_tglDari') }}"> 
							</div>
							<div>s.d.</div> 
							<div class="col-md-3">
								<input class="form-control date tglSmp" id="tglSmp" name="tglSmp"
								type="text" autocomplete="off" value="{{ session()->get('filter_tglSampai') }}">
							</div>
						</div> -->
						
						<button class="btn btn-primary" type="submit" id="filter" class="filter" name="filter">Filter</button>
						<button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter" onclick="window.location='{{url("rsisahut")}}'">Reset</button>
						<button class="btn btn-warning" type="submit" id="cetak" class="cetak" formtarget="_blank">Cetak</button>
                    </form>
                    <div style="margin-bottom: 15px;"></div>
                    <!--
                    <table class="table table-fixed table-striped table-border table-hover nowrap datatable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="text-align: center">#</th>
                                <th scope="col" style="text-align: center">Bukti</th>
                                <th scope="col" style="text-align: center">Tgl</th>
                                <th scope="col" style="text-align: center">Suplier#</th>
                                <th scope="col" style="text-align: center">-</th>
                                <th scope="col" style="text-align: center">Sisa</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody> 
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
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
                                    "KODES" => array(
                                        "label" => "Suplier#",
                                    ),
                                    "NAMAS" => array(
                                        "label" => "-",
                                        "footerText" => "<b>Grand Total :</b>",
                                    ),
                                    "SISA" => array(
                                        "label" => "Sisa",
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
                                            "targets" => [4],
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

	<div class="modal fade" id="browseSuplierModal" tabindex="-1" role="dialog" aria-labelledby="browseSuplierModalLabel" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="browseSuplierModalLabel">Cari Suplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-stripped table-bordered" id="table-bsuplier">
					<thead>
						<tr>
							<th>Suplier</th>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
        }); 
        /*
        function fill_datatable( kodes = '', tglDr = '', tglSmp = '')
        {
            var dataTable = $('.datatable').DataTable({
                dom: '<"row"<"col-4"B>>fltip',
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                processing: true,
                serverSide: true,
                autoWidth: true,
                //'scrollX': true,
                'scrollY': '400px',
                "order": [[ 0, "asc" ]],
                ajax: 
                {
                    url: "{{ url('get-hut-sisa') }}",
                    data: {
                        kodes: kodes,
                        tglDr: tglDr,
                        tglSmp: tglSmp
                    }
                },
                columns: 
                [
                    {data: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'NO_BUKTI', name: 'NO_BUKTI'},
                    {data: 'TGL', name: 'TGL'},
                    {data: 'KODES', name: 'KODES'},
                    {data: 'NAMAS', name: 'NAMAS'},
                    {
                     data: 'SISA', 
                     name: 'SISA',
                     render: $.fn.dataTable.render.number( ',', '.', 2, '' )
                    },	
                 ],
                 
                 columnDefs: [
                  {
                    "className": "dt-center", 
                    "targets": 0
                  },
                  {
                    targets: 2,
                    render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
                  },
                  {
                    "className": "dt-right", 
                    "targets": [5]
                  }
               
                 ],
                
                ///////////////////////////////////////////////////
                
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
         
                    // Total over this page
                    pageDebetTotal = api
                        .column(5, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
         
                    // Update footer
                    $(api.column(5).footer()).html(pageDebetTotal.toLocaleString('en-US'));
                    //$(api.column(6).footer()).html(pageKreditTotal.toLocaleString('en-US'));
                },
                
                
            });
        }
        
        $('#filter').click(function() {
            var kodes = $('#kodes').val();
            var tglDr = $('#tglDr').val();
            var tglSmp = $('#tglSmp').val();
            
            if (kodes != '' || (tglDr != '' && tglSmp != ''))
            {
                $('.datatable').DataTable().destroy();
                fill_datatable(kodes, tglDr, tglSmp);
            }
        });

        $('#resetfilter').click(function() {
            var kodes = '';
            var tglDr = '';
            var tglSmp = '';

            $('.datatable').DataTable().destroy();
            fill_datatable(kodes, tglDr, tglSmp);
        }); */

    });
    
		var dTableBSuplier;
		loadDataBSuplier = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: "{{url('sup/browse')}}",
				data: {
					'GOL': $('#gol').val(),
				},
				success: function( response )
				{
					resp = response;
					if(dTableBSuplier){
						dTableBSuplier.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSuplier.row.add([
							'<a href="javascript:void(0);" onclick="chooseSuplier(\''+resp[i].KODES+'\',  \''+resp[i].NAMAS+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODES+'</a>',
							resp[i].NAMAS,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableBSuplier.draw();
				}
			});
		}
		
		dTableBSuplier = $("#table-bsuplier").DataTable({
			
		});
		
		browseSuplier = function(){
			loadDataBSuplier();
			$("#browseSuplierModal").modal("show");
		}
		
		chooseSuplier = function(KODES,NAMAS, ALAMAT, KOTA){
			$("#kodes").val(KODES);
			$("#NAMAS").val(NAMAS);	
			$("#browseSuplierModal").modal("hide");
		}
		
		$("#kodes").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseSuplier();
			}
		}); 
</script>
@endsection
