	@extends('layouts.main')

	@section('content')
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
<!-- GANTI 1 -->
				<h1 class="m-0">Laporan Suplier</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
<!-- GANTI 2 -->
				<li class="breadcrumb-item active">Laporan Suplier</li>
				</ol>
			</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
			<div class="row">
				<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="form-group nowrap">
							<label><strong>Proses :</strong></label>
<!-- GANTI 2.1 -->
							<!--
							<select name="acno" id="acno" class="form-control acno" style="width: 200px">
								<option value="">--Pilih Bahan--</option>
								<option value="1000">Kas</option>
								<option value="1100">Bank</option>
							</select>
							-->
						</div>
						<button class="btn btn-primary" type="button" id="filter" class="filter">Filter</button>
						<button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter">Reset</button>
						<div style="margin-bottom: 15px;"></div>
						<table class="table table-fixed table-striped table-border table-hover nowrap datatable">
							<thead class="table-dark">
								<tr>
<!-- GANTI 3 -->
									<th scope="col" style="text-align: center">#</th>
									<th scope="col" style="text-align: center">Kode</th>
									<th scope="col" style="text-align: center">-</th>
									<th scope="col" style="text-align: center">Awal</th>
									<th scope="col" style="text-align: center">Beli</th>
									<th scope="col" style="text-align: center">Bayar</th>
									<th scope="col" style="text-align: center">Lain</th>
									<th scope="col" style="text-align: center">Akhir</th>
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
			fill_datatable();
// GANTI 3.1 SESUAI GANTI 2.1
		//	function fill_datatable( acno = '')
		function fill_datatable()	
		{
				var dataTable = $('.datatable').DataTable({
					dom: '<"row"<"col-4"B>>ltip',
					processing: true,
					serverSide: true,
					autoWidth: true,
					'scrollY': '400px',
					"order": [[ 0, "asc" ]],
					ajax: 
					{
// GANTI 4 SESUAI resources -routes - web - GANTI 1
						url: '{{ route('get-sup-report') }}',
						//data: {
// GANTI 4.1 SESUAI GANTI 2.1
						//	acno: acno
						//}
					},
					columns: 
					[
// GANTI 5 SESUAI DENGAN GANTI 3
						{data: 'DT_RowIndex', orderable: false, searchable: false },
						{data: 'KODES', name: 'KODES'},
						{data: 'NAMAS', name: 'NAMAS'},
                        {
					      data: 'AW', 
					      name: 'AW',
					      render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				        },
						{
					      data: 'MA', 
					      name: 'MA',
					      render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				        },						
						{
					      data: 'KE', 
					      name: 'KE',
					      render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				        },
						{
					      data: 'LN', 
					      name: 'LN',
					      render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				        },
						{
					      data: 'AK', 
					      name: 'AK',
					      render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				        }
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
                    "targets": [3,4,5,6,7]
                    }
					
					],
					
					
        drawCallback: function () {
      var api = this.api();
      $( api.column( 3 ).footer() ).html(
        'Aw : ' + api.column( 3, {page:'current'} ).data().sum()
      );
	  $( api.column( 4 ).footer() ).html(
        'Ma : ' + api.column( 4, {page:'current'} ).data().sum()
      );
	  $( api.column( 5 ).footer() ).html(
        'Ke : ' + api.column( 5, {page:'current'} ).data().sum()
      );
	  $( api.column( 6 ).footer() ).html(
        'Ln : ' + api.column( 6, {page:'current'} ).data().sum()
      );
	  $( api.column( 7 ).footer() ).html(
        'Ak : ' + api.column( 7, {page:'current'} ).data().sum()
      );
    }
				});
			}
			
			$('#filter').click(function() {
// GANTI 5.1 SESUAI GANTI 2.1
				//var acno = $('#acno').val();
				//if (acno != '')
				//{
				//	$('.datatable').DataTable().destroy();
					fill_datatable();
				//}
			});
			$('#resetfilter').click(function() {
				//var acno = '';

				//$('.datatable').DataTable().destroy();
				//fill_datatable(acno);
// BATAS GANTI 5.1
			});
		});
	</script>
	@endsection