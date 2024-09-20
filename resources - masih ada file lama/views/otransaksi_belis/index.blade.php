@extends('layouts.main')
@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}">
@endsection


<style>
    .card-body {
        padding: 5px 10px !important;
    }

    .table thead {
        background-color: #c6e2ff;
        color: #000;
    }

    .datatable tbody td {
        padding: 5px !important;
    }

    .datatable {
        border-right: solid 2px #000;
        border-left: solid 2px #000;
    }

    .table tbody:nth-child(2) {
        background-color: #ffe4e1;
    }

    .btn-secondary {
        background-color: #42047e !important;
    }
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Transaksi Pembelian Non</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Transaksi Pembelian Non</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
			  
			  
                
                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
											
                            <th scope="col" style="text-align: center">#</th>										
                            <th scope="col" style="text-align: center">--</th>
							<th scope="col" style="text-align: center">Bukti#</th>
                            <th scope="col" style="text-align: center">Tgl</th>
                            <th scope="col" style="text-align: center">Po#</th>
							<th scope="col" style="text-align: center">Kode#</th>
							<th scope="col" style="text-align: center">Suplier</th>
							<th scope="col" style="text-align: center">Total_Qty</th>
                            <th scope="col" style="text-align: center">Total</th>
							<th scope="col" style="text-align: center">Ppn</th>
                            <th scope="col" style="text-align: center">Netto</th>
							<th scope="col" style="text-align: center">Notes</th>>
							
							
                        </tr>
                    </thead>
    
                     <tbody>
                         
                    </tbody> 
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('javascripts')

<script>
  $(document).ready(function() {
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
			'scrollX': true,
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: '{{ route('get-belin') }}'
            },
            columns: 
            [
                {  data: 'DT_RowIndex', orderable: false, searchable: false },
				
			    {
				data: 'action',
				name: 'action'
			    },
				
                {data: 'NO_BUKTI', name: 'NO_BUKTI'},
                {data: 'TGL', name: 'TGL'},
				{data: 'NO_PO', name: 'NO_PO'},
                {data: 'KODES', name: 'KODES'},
				{data: 'NAMAS', name: 'NAMAS'},
				{
					data: 'TOTAL_QTY',
					name: 'TOTAL_QTY',
					render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				},				
                {
					data: 'TOTAL', 
					name: 'TOTAL',
					render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				},
				
                {
					data: 'PPN', 
					name: 'PPN',
					render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				},	
                {
					data: 'NETT', 
					name: 'NETT',
					render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				},	
                {data: 'NOTES', name: 'NOTES'}	
				
				
            ],

            columnDefs: 
			[
                {
                    "className": "dt-center", 
                    "targets":[0,5,6,7]
                },			
				{
                    "className": "dt-right", 
                    "targets":[9,10,11,12]
                },				
				{
					targets: 3,
					render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
				}
				
            ],
        lengthMenu: [
                [8, 10, 20, 50, 100, -1],
                [8, 10, 20, 50, 100, "All"]
            ],
        dom: "<'row'<'col-md-6'><'col-md-6'>>" +
            "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
            "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        });
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('kas/create')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
    });
</script>
@endsection