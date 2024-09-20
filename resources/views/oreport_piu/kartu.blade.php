@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kartu Piutang</h1>
                </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Kartu Piutang</li>
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
                <form method="POST" action="{{url('jasper-piu-kartu')}}">
                @csrf
					<div class="form-group row">
						<div class="col-md-1">
							<label><strong>Gol :</strong></label>
							
							<select name="gol" id="gol" class="form-control gol">
								<option value="Y" {{ session()->get('filter_gol')=='Y' ? 'selected': ''}}>Y</option>
								<option value="Z" {{ session()->get('filter_gol')=='Z' ? 'selected': ''}}>Z</option>
							</select>
						</div>
						<!--
						<div class="col-md-3">
							<label><strong>Customer :</strong></label>
							<select name="kodec" id="kodec" class="form-control kodec" style="width: 200px">
								<option value="">--Pilih Customer--</option>
								@foreach($kodec as $kodecD)
									<option value="{{$kodecD->KODEC}}">{{$kodecD->KODEC}} {{$kodecD->NAMAC}}</option>
								@endforeach
							</select>
						</div>
						-->
						<div class="col-md-2">						
							<label class="form-label">Customer</label>
							<input type="text" class="form-control kodec" id="kodec" name="kodec" placeholder="Pilih Customer" value="{{ session()->get('filter_kodec1') }}" readonly>
						</div>  
						<div class="col-md-3">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="Nama" value="{{ session()->get('filter_namac1') }}" readonly>
						</div>
					</div>

					<!-- Filter Tanggal -->
					<!--
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
					</div> -->
						
                    <button class="btn btn-primary" type="submit" id="filter" class="filter" name="filter">Filter</button>
                    <button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter" onclick="window.location='{{url("rkartup")}}'">Reset</button>
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
                            <th scope="col" style="text-align: center">Customer#</th>
                            <th scope="col" style="text-align: center">-</th>
                            <th scope="col" style="text-align: center">Total</th>
                            <th scope="col" style="text-align: center">Bayar</th>
                            <th scope="col" style="text-align: center">Saldo</th>

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
                                    "KODEC" => array(
                                        "label" => "Customer#",
                                    ),
                                    "NAMAC" => array(
                                        "label" => "-",
                                        "footerText" => "<b>Grand Total :</b>",
                                    ),
                                    "TOTAL" => array(
                                        "label" => "Total",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "BAYAR" => array(
                                        "label" => "Bayar",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
                                        "footer" => "sum",
                                        "footerText" => "<b>@value</b>",
                                    ),
                                    "SALDO" => array(
                                        "label" => "Saldo",
                                        "type" => "number",
                                        "decimals" => 2,
                                        "decimalPoint" => ".",
                                        "thousandSeparator" => ",",
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
                                            "targets" => [4,5,6],
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

<div class="modal fade" id="browseCustModal" tabindex="-1" role="dialog" aria-labelledby="browseCustModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="browseCustModalLabel">Cari Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-stripped table-bordered" id="table-cust">
                <thead>
                    <tr>
                        <th>Customer</th>
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
        function fill_datatable( kodec = '', tglDr = '', tglSmp = '')
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
                    url: "{{ url('get-piu-kartu') }}",
                    data: {
                        kodec: kodec,
                        tglDr: tglDr,
                        tglSmp: tglSmp
                    }
                },
                columns: 
                [
                    {data: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'NO_BUKTI', name: 'NO_BUKTI'},
                    {data: 'TGL', name: 'TGL'},
                    {data: 'KODEC', name: 'KODEC'},
                    {data: 'NAMAC', name: 'NAMAC'},
                    {
                        data: 'TOTAL', 
                        name: 'TOTAL',
                        render: $.fn.dataTable.render.number( ',', '.', 2, '' )
                    },	
                    {
                        data: 'BAYAR', 
                        name: 'BAYAR',
                        render: $.fn.dataTable.render.number( ',', '.', 2, '' )
                    },	
                    {
                        data: 'SALDO', 
                        name: 'SALDO',
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
                    "targets": [5,6,7]
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
                    pageKreditTotal = api
                        .column(6, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
            
                    // Update footer
                    $(api.column(5).footer()).html(pageDebetTotal.toLocaleString('en-US'));
                    $(api.column(6).footer()).html(pageKreditTotal.toLocaleString('en-US'));
                },
                
                
            });
        }
        
        $('#filter').click(function() {
            var kodec = $('#kodec').val();
            var tglDr = $('#tglDr').val();
            var tglSmp = $('#tglSmp').val();
            
            if (kodec != '' || (tglDr != '' && tglSmp != ''))
            {
                $('.datatable').DataTable().destroy();
                fill_datatable(kodec, tglDr, tglSmp);
            }
        });

        $('#resetfilter').click(function() {
            var kodec = '';
            var tglDr = '';
            var tglSmp = '';

            $('.datatable').DataTable().destroy();
            fill_datatable(kodec, tglDr, tglSmp);
        });
        */

    });

    var dTableCust;
    loadDataCust = function(){
    
        $.ajax(
        {
            type: 'GET', 		
            url: "{{url('cust/browse')}}",
            data: {
                'GOL': $('#gol').val(),
            },
            success: function( response )
            {
                resp = response;
                if(dTableCust){
                    dTableCust.clear();
                }
                for(i=0; i<resp.length; i++){
                    
                    dTableCust.row.add([
                        '<a href="javascript:void(0);" onclick="chooseCust(\''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODEC+'</a>',
                        resp[i].NAMAC,
                        resp[i].ALAMAT,
                        resp[i].KOTA,
                    ]);
                }
                dTableCust.draw();
            }
        });
    }
    
    dTableCust = $("#table-cust").DataTable({
        
    });
    
    browseCust = function(){
        loadDataCust();
        $("#browseCustModal").modal("show");
    }
    
    chooseCust = function(KODEC, NAMAC, ALAMAT, KOTA){
        $("#kodec").val(KODEC);
        $("#NAMAC").val(NAMAC);	
        $("#browseCustModal").modal("hide");
    }
    
    $("#kodec").keypress(function(e){
        if(e.keyCode == 46){
            e.preventDefault();
            browseCust();
        }
    });
</script>
@endsection
