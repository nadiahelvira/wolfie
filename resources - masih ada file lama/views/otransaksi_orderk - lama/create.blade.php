@extends('layouts.main')


<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
    }
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            	<h1 class="m-0">Tambah Order Kerja {{$JUDUL}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/orderk">Transaksi Order Kerja {{$JUDUL}}</a></li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
            </div>
        </div>
        </div>
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="store" id="entri" method="POST">
                        @csrf
                        {{-- <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#data" data-toggle="tab">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dokumen" data-toggle="tab">Dokumen</a>
                            </li>
                        </ul> --}}
        
                        <div class="tab-content mt-3">
                            <div class="form-group row">
								<div class="col-md-2" align="left">
                                    <label for="NO_BUKTI" class="form-label">No Bukti</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="JNSOK" value="{{$JNSOK}}" hidden>
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti" value="+" readonly>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Customer</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="No Customer" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}" >
                                </div>
                                <div class="col-md-1" align="right">
                                    <label for="JTEMPO" class="form-label">Jtempo</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="JTEMPO" name="JTEMPO" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}">
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="Nama Customer" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="left">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">SO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="No Sales Order" readonly> <input type="text" class="form-control ID_SOD" id="ID_SOD" name="ID_SOD" readonly hidden>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">Seri#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SERI" id="NO_SERI" name="NO_SERI" placeholder="No Seri" readonly>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" placeholder="Alamat Customer" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label class="form-label">Barang</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Barang#" readonly>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">Satuan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUANH" id="SATUANH" name="SATUANH" placeholder="Satuan" readonly>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" placeholder="Kota Customer" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama Barang" readonly>
                                </div>
                            </div>
							
							@if ($JNSOK == 'OW')
                            <div class="form-group row">
                                <div class="col-md-2" align="left">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">Bahan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BHN_H" id="KD_BHN_H" name="KD_BHN_H" placeholder="Bahan#" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_BHN_H" id="NA_BHN_H" name="NA_BHN_H" placeholder="Nama Bahan" readonly>
                                </div>
                            </div>
                    		@endif

                            <div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label class="form-label">Qty</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" onkeyup="hitung()" class="form-control QTYH" id="QTYH" name="QTYH" value=0 {{ ($JNSOK == "OK") ? 'readonly' : '' }}>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="left">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">FO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_FO" id="NO_FO" name="NO_FO" placeholder="No Formula" readonly>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes">
                                </div>
                            </div>
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" width="75px">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label class="form-label">Kode</label></th>
                                        <th style="text-align: center;">Bahan</th>
                                        <th style="text-align: center;">Stn</th>
										<th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
										<th style="text-align: center;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrderk">
                                    <tr>
                                        <td>
                                            <input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" style="text-align: center;" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN0" type="text" class="form-control KD_BHN" placeholder="Bahan#" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN0" type="text" class="form-control NA_BHN" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN" placeholder="Satuan" readonly required>
                                        </td>
										<td>
											<input name="QTY[]" onclick="select()" onkeyup="hitung()" value="0" id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly> <input name="QTYX[]" value=0 id="QTX0" type="text" class="form-control QTYX text-primary" readonly hidden>
										</td>   
                                        
										<td>
                                            <input name="KET[]" id="KET0" type="text" class="form-control KET" placeholder="Ket" required>
                                        </td>
										
										<td>
										
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
								<tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="0" readonly></td>
                                    <td></td>
                                </tfoot>
                            </table>     
                            <div class="col-md-2 row">
                                <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
                            </div>							
                        </div>

                        <div class="mt-3">
                            <button type="button" onclick="simpan()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
                            <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
	
	
	
	<div class="modal fade" id="browseSoModal" tabindex="-1" role="dialog" aria-labelledby="browseSoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSoModalLabel">Cari Sales Order</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-so">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<th>Customer</th>
						<th>Kode</th>
						<th>Barang</th>
						<th>Qty</th>
						<th>Satuan</th>
						<th>Seri#</th>
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

	<div class="modal fade" id="browseFoModal" tabindex="-1" role="dialog" aria-labelledby="browseFoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseFoModalLabel">Cari Formula</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-fo">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Kode</th>
						<th>Nama</th>
						<th>Notes</th>
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

	<div class="modal fade" id="browsePrsModal" tabindex="-1" role="dialog" aria-labelledby="browsePrsModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePrsModalLabel">Lihat Proses</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-prs">
				<thead>
					<tr>
						<th>Kode</th>
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
	
	<div class="modal fade" id="browseBhnModal" tabindex="-1" role="dialog" aria-labelledby="browseBhnModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBhnModalLabel">Lihat Proses</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bhn">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Jenis</th>
						<th>Satuan</th>
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

@section('footer-scripts')
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
	var idrow = 1;
	var baris = 1;
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).ready(function() {
		$("#QTYH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
///////////////////////////////////////////////////////////////////////
		
 		var dTableSo;
		loadDataSo = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('orderk/browseSo')}}",
				success: function( response )
				{
					resp = response;
					if(dTableSo){
						dTableSo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableSo.row.add([
							'<a href="javascript:void(0);" onclick="chooseSo(\''+resp[i].NO_ID+'\', \''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\', \''+resp[i].NAMAC+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',  \''+resp[i].QTY+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].NO_SERI+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].TGL,
							resp[i].NAMAC,
							resp[i].KD_BRG,
							resp[i].NA_BRG,
							Intl.NumberFormat('en-US').format(resp[i].QTY),	
							resp[i].SATUAN,
							resp[i].NO_SERI,
						]);
					}
					dTableSo.draw();
				}
			});
		}
		
		dTableSo = $("#table-so").DataTable({
            columnDefs: [
				{
				targets: 1,
				render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
				},
			],
		});
		
		browseSo = function(){
			loadDataSo();
			$("#browseSoModal").modal("show");
		}
		
		chooseSo = function(NO_ID, NO_BUKTI, KODEC, NAMAC, ALAMAT, KOTA, KD_BRG, NA_BRG, QTY, SATUAN, NO_SERI){
			$("#ID_SOD").val(NO_ID);
            $("#NO_SO").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#ALAMAT").val(ALAMAT);			
			$("#KOTA").val(KOTA);
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);
			$("#QTYH").val(QTY);		
			$("#SATUANH").val(SATUAN);		
			$("#NO_SERI").val(NO_SERI);			
			$("#browseSoModal").modal("hide");
		}
		
		$("#NO_SO").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseSo();
			}
		}); 
////////////////////////////////////////////////////////////
		var dTableFo;
		loadDataFo = function(){
			var kode = "{{$JNSOK}}"=="OK" ? $("#KD_BRG").val() : $("#KD_BHN_H").val();
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('orderk/browseFo')}}",
				data: {
					kdbrg: kode,
				},
				success: function( response )
				{
					resp = response;
					if(dTableFo){
						dTableFo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableFo.row.add([
							'<a href="javascript:void(0);" onclick="chooseFo(\''+resp[i].NO_BUKTI+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KD_BRG,
							resp[i].NA_BRG,
							resp[i].NOTES,
						]);
					}
					dTableFo.draw();
				}
			});
		}
		
		dTableFo = $("#table-fo").DataTable({

		});
		
		browseFo = function(){
			loadDataFo();
			$("#browseFoModal").modal("show");
		}
		
		chooseFo = function(NO_BUKTI){
			$("#NO_FO").val(NO_BUKTI);	
			$("#browseFoModal").modal("hide");
			getFod(NO_BUKTI);
		}
		
		$("#NO_FO").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseFo();
			}
		}); 
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var dTablePrs;
		var rowidPrs;
		loadDataPrs = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('pakai/browsePrs')}}",
				success: function( response )
				{
					resp = response;
					if(dTablePrs){
						dTablePrs.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTablePrs.row.add([
							'<a href="javascript:void(0);" onclick="choosePrs(\''+resp[i].KD_PRS+'\',  \''+resp[i].NA_PRS+'\')">'+resp[i].KD_PRS+'</a>',
							resp[i].NA_PRS,
						]);
					}
					dTablePrs.draw();
				}
			});
		}
		
		dTablePrs = $("#table-prs").DataTable({
			
		});
		
		browsePrs = function(rid){
			rowidPrs = rid;
			loadDataPrs();
			$("#browsePrsModal").modal("show");
		}
		
		choosePrs = function(KD_PRS,NA_PRS){
			$("#KD_PRS"+rowidPrs).val(KD_PRS);
			$("#NA_PRS"+rowidPrs).val(NA_PRS);		
			$("#browsePrsModal").modal("hide");
		}
		
		$("#KD_PRS0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browsePrs(0);
			}
		}); 
////////////////////////////////////////////////////////////////////////////////////
 		var dTableBhn;
		var rowidBhn;
		loadDataBhn = function(rid){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('pakai/browseBhn')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBhn){
						dTableBhn.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBhn.row.add([
							'<a href="javascript:void(0);" onclick="chooseBhn(\''+resp[i].KD_BHN+'\',  \''+resp[i].NA_BHN+'\',  \''+resp[i].SATUAN+'\',  \''+rid+'\')">'+resp[i].KD_BHN+'</a>',
							resp[i].NA_BHN,
							resp[i].JENIS,
							resp[i].SATUAN,
						]);
					}
					dTableBhn.draw();
				}
			});
		}
		
		dTableBhn = $("#table-bhn").DataTable({
			
		});
		
		browseBhn = function(rid){
			rowidBhn = rid;
			loadDataBhn(rid);
			$("#browseBhnModal").modal("show");
		}
		
		chooseBhn = function(KD_BHN,NA_BHN,SATUAN,rid){
			if(rid=='Y')
			{
				$("#KD_BHN_H").val(KD_BHN);
				$("#NA_BHN_H").val(NA_BHN);	
			}
			else
			{
				$("#KD_BHN"+rowidBhn).val(KD_BHN);
				$("#NA_BHN"+rowidBhn).val(NA_BHN);		
				$("#SATUAN"+rowidBhn).val(SATUAN);	
			}		
			$("#browseBhnModal").modal("hide");
		}
		
		$("#KD_BHN0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBhn(0);
			}
		}); 

		$("#KD_BHN_H").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBhn('Y');
			}
		}); 
	});
////////////////////////////////////////////////////////////////////////////////////
	function getFod(bukti)
	{
		$.ajax(
			{
				type: 'GET',    
				url: "{{url('orderk/browseFod')}}",
				data: {
					nobukti: bukti,
				},
				success: function( resp )
				{
					var html = '';
					for(i=0; i<resp.length; i++){
						html+=`<tr>
                                    <td><input name='REC[]' id='REC${i}' value=${resp[i].REC+1} type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly></td>
                                    <td><input name='KD_BHN[]' data-rowid=${i} id='KD_BHN${i}' value="${resp[i].KD_BHN}" type='text' class='form-control KD_BHN' required readonly></td>
                                    <td><input name='NA_BHN[]' data-rowid=${i} id='NA_BHN${i}' value="${resp[i].NA_BHN}" type='text' class='form-control  NA_BHN' required readonly></td>
                                    <td><input name='SATUAN[]' data-rowid=${i} id='SATUAN${i}' value="${resp[i].SATUAN}" type='text' class='form-control  SATUAN' placeholder="Satuan" required readonly></td>
                                    <td><input name='QTY[]' onclick='select()' onkeyup='hitung()' id='QTY${i}' value="${resp[i].QTY*$("#QTYH").val()}" type='text' style='text-align: right' class='form-control QTY text-primary' readonly required> <input name='QTYX[]' id=QTYX${i} value="${resp[i].QTY}" type='text' class='form-control QTYX text-primary' readonly hidden></td>
                                    <td><input name='KET[]' id='KET${i}' value="${resp[i].KET}" type='text' class='form-control  KET' required></td>
                                    <td><button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button></td>
                                </tr>`;
					}
					$('#detailOrderk').html(html);
					$(".QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".QTY").autoNumeric('update');
					/*
					$(".KD_BHN").each(function() {
						var getid = $(this).attr('id');
						var noid = getid.substring(6,11);

						$("#KD_BHN"+noid).keypress(function(e){
							if(e.keyCode == 46){
								e.preventDefault();
								browseBhn(noid);
							}
						}); 
					});*/

					idrow=resp.length;
					baris=resp.length;

					nomor();
				}
			});
	}

	function simpan() {
		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
        var check = '0';
		
		$(".KD_PRS").each(function() {
			var kdprs = $(this).val();
			if(kdprs=='')
			{
				var val = $(this).parents("tr").remove();
				baris--;
				nomor();
			}
		});

		if ( $('#NO_SO').val()=='' ) 
		{			
			check = '1';
			alert("SO Harus diisi.");
		}
		if ( $('#NO_FO').val()=='' ) 
		{			
			check = '1';
			alert("Formula Harus diisi.");
		}
		if ( tgl.substring(3,5) != bulanPer ) 
		{
			check = '1';
			alert("Bulan ("+tgl+") tidak sama dengan Periode");
		}	
		if ( tgl.substring(tgl.length-4) != tahunPer )
		{
			check = '1';
			alert("Tahun ("+tgl+") tidak sama dengan Periode");
		}	 
		if ("{{$JNSOK}}"=="OW" && $('#KD_BHN_H').val()=="")
		{
			check = '1';
			alert("*Bahan Harus diisi.");
		}
	
		if ( check == '0' )
		{
			document.getElementById("entri").submit();  
		}
	}

    function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		hitung();
	}

    function hitung() {
		var TTOTAL_QTY = 0;
		var QTYH = parseFloat($("#QTYH").val().replace(/,/g, ''));

		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat(z.find('.QTYX').val().replace(/,/g, ''));

            var QTY = QTYH * QTYX;
			z.find('.QTY').val(QTY);
		    z.find('.QTY').autoNumeric('update');
		
            TTOTAL_QTY +=QTY;	
		});
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		

		$("#TTOTAL_QTY").autoNumeric('update');
	}

    function tambah() {
        var x = document.getElementById('datatable').insertRow(baris + 1);
        var td1 = x.insertCell(0);
        var td2 = x.insertCell(1);
        var td3 = x.insertCell(2);
        var td4 = x.insertCell(3);
        var td5 = x.insertCell(4);
        var td6 = x.insertCell(5);
        var td7 = x.insertCell(6);

        td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control '  onkeypress='return tabE(this,event)' readonly>";
        // td2.innerHTML = "<input name='KD_PRS[]' data-rowid='"+idrow+"'  id=KD_PRS" + idrow + " type='text' class='form-control KD_PRS' placeholder='Proses#' required readonly>";
        // td3.innerHTML = "<input name='NA_PRS[]' id=NA_PRS" + idrow + " type='text' class='form-control  NA_PRS' required readonly>";
        td2.innerHTML = "<input name='KD_BHN[]' data-rowid='"+idrow+"'  id=KD_BHN" + idrow + " type='text' class='form-control KD_BHN' placeholder='Bahan#' required readonly>";
        td3.innerHTML = "<input name='NA_BHN[]' id=NA_BHN" + idrow + " type='text' class='form-control  NA_BHN' required readonly>";
        td4.innerHTML = "<input name='SATUAN[]' id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' placeholder='Satuan' required readonly>";
		// td7.innerHTML = "<input name='QTYA[]' onclick='select()' onkeyup='hitung()' value='0' id=QTYA" + idrow + " type='text' style='text-align: right' class='form-control QTYA  text-primary' readonly required>";
		td5.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY  text-primary' readonly required> <input name='QTYX[]' value='0' id=QTYX" + idrow + " type='text' class='form-control QTYX  text-primary' readonly hidden>";
        td6.innerHTML = "<input name='KET[]' id=KET" + idrow + " type='text' class='form-control  KET' placeholder='Ket' required>";
		td7.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) 
		{
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		// $("#KD_PRS"+idrow).keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browsePrs(eval($(this).data("rowid")));
		// 	}
		// }); 

		$("#KD_BHN"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBhn(eval($(this).data("rowid")));
			}
		}); 
		
		idrow++;
		baris++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
     }
</script>

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection

