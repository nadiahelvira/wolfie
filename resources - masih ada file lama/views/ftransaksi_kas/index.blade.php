@extends('layouts.main')
@section('styles')
<!-- <link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}"> -->
<link rel="stylesheet" href="{{asset('foxie_js_css/jquery.dataTables.min.css')}}" />

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
    
    
    th { font-size: 13px; }
    td { font-size: 13px; }
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <b class="m-0" style="font-size: 14pt;">Transaksi {{$judul}} </b>
          </div>
          <!-- /.col -->
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

                <input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden>                

                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
											
                            <th scope="col" style="text-align: center">No</th>
				     		<th scope="col" style="text-align: center">-</th>							
                            <th scope="col" style="text-align: left">Bukti#</th>
                            <th scope="col" style="text-align: left">Tgl</th>
                            <th scope="col" style="text-align: left">Cash#</th>
                            <th scope="col" style="text-align: left">-</th>
							<th scope="col" style="text-align: left">Ket</th>
                            <th scope="col" style="text-align: right">Jumlah</th>
							<th scope="col" style="text-align: center">Posted</th>
							<th scope="col" style="text-align: center">User</th>
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
            autoWidth: false,
            'scrollX': true,
            'scrollY': '400px',				
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: '{{ route('get-kas') }}',
				data: {
					'flagz': "{{$flagz}}",
				},
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
                {data: 'BACNO', name: 'BACNO'},				
                {data: 'BNAMA', name: 'BNAMA'},	
				{data: 'KET', name: 'KET'},
                {
					data: 'JUMLAH', 
					name: 'JUMLAH',
					render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				},
                { data: 'POSTED', name: 'POSTED',
                  render : function(data, type, row, meta) {
                    if(row['POSTED']=="0"){
                        return '';
                    }else{
                        return '<input type="checkbox" checked style="pointer-events: none;">';
                    }
                  }
                },
                { data: 'USRNM', name: 'USRNM'},

				
            ],

            columnDefs: [
                {
                    "className": "dt-center", 
                    "targets": [0,8],
                },			
				{
					targets: 3,
					render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
				},
				{
                    "className": "dt-right", 
                    "targets": 7
                }
				
              ],
            lengthMenu: [
                [8, 10, 20, 50, 100, -1],
                [8, 10, 20, 50, 100, "All"]
            ],
			
            dom: "<'row'<'col-md-6'><'col-md-6'>>" +
            "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
            "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
			stateSave:true,
		

        });
		
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('kas/edit?flagz='.$flagz.'&idx=0&tipx=new')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
    });
	
</script>
@endsection

