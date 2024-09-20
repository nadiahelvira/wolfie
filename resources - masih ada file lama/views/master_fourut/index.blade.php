@extends('layouts.main')
@section('styles')
<!-- DataTables -->
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
		        <h1 class="m-0">Master Urut Formula</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Master Urut Formula</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="text-align: center">No</th>
                            <th scope="col" style="text-align: center">-</th>
                            <th scope="col" style="text-align: Left">FO#</th>							
                            <th scope="col" style="text-align: left">Barang#</th>
                            <th scope="col" style="text-align: left">Nama</th>
							              <th scope="col" style="text-align: left">Notes</th>
                        </tr>
                    </thead>
    
                     <tbody>
                    </tbody> 
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascripts')
<script src="{{url('http://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js') }}"></script>

<script>
  $(document).ready(function() {
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: "{{ route('get-fourut') }}"
            },
            columns: 
            [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'action',name: 'action'},
                {data: 'NO_BUKTI', name: 'NO_BUKTI'},
                {data: 'KD_BRG', name: 'KD_BRG'},
                {data: 'NA_BRG', name: 'NA_BRG'},
				        {data: 'NOTES', name: 'NOTES'},
            ],

            columnDefs: 
            [
                {
                    "className": "dt-center", 
                    "targets": 0
                }
            ],
            lengthMenu: 
            [
                [8, 10, 20, 50, 100, -1],
                [8, 10, 20, 50, 100, "All"]
            ],
        dom: "<'row'<'col-md-6'><'col-md-6'>>" +
            "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
            "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        });
        // $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('fourut/create')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
    });
</script>
@endsection
