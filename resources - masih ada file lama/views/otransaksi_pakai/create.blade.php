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
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            	<h1 class="m-0">Tambah Pemakaian Baru {{$JUDUL}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pakai?JNSPK={{$JNSPK}}">Transaksi Pemakaian {{$JUDUL}}</a></li>
                <li class="breadcrumb-item active">Add</li>
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
								<div class="col-md-2" align="right">
                                    <label for="NO_BUKTI" class="form-label">No Bukti</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="JNSPK" value="{{$JNSPK}}" hidden>
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti" value="+" readonly>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">OK#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_OK" id="NO_OK" name="NO_OK" placeholder="No Order Kerja" readonly>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">SO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="No Sales Order" readonly>
                                </div>
                                <div class="col-md-1" align="right">
									<label style="color:red;font-size:20px">* </label>
                                    <label class="form-label">Proses</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_PRSH" id="KD_PRSH" name="KD_PRSH" placeholder="Kode Proses" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PRS" id="NO_PRS" name="NO_PRS" placeholder="No Proses" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Barang</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Barang#" readonly>
                                </div>
                                <div class="col-md-1" align="right">			
                                    <label class="form-label">FO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_FO" id="NO_FO" name="NO_FO" placeholder="No Formula" readonly>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_PRSH" id="NA_PRSH" name="NA_PRSH" placeholder="Nama Proses" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama Barang" readonly>
                                </div>
                            </div>

							@if ($JNSPK == 'PW')
                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Bahan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BHN_H" id="KD_BHN_H" name="KD_BHN_H" placeholder="Bahan#" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control NA_BHN_H" id="NA_BHN_H" name="NA_BHN_H" placeholder="Nama Bahan" readonly>
                                </div>
                            </div>
                    		@endif
							
                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Qty In</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control QTYI" id="QTYI" name="QTYI" onclick="select()" onkeyup="hitung()" value=0>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">Qty Out</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control QTYO" id="QTYO" name="QTYO" onclick="select()" onkeyup="hitung()" value=0>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">Satuan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUANH" id="SATUANH" name="SATUANH" placeholder="Satuan" readonly>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-8">
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
                                <tbody id="detailPakai">
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
											<input name="QTY[]" onclick="select()" onkeyup="hitung()" value=0 id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary"> <input name="QTYX[]" value=0 id="QTX0" type="text" class="form-control QTYX text-primary" readonly hidden>
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
	
	
	
	<div class="modal fade" id="browseOkModal" tabindex="-1" role="dialog" aria-labelledby="browseOkModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseOkModalLabel">Cari Order Kerja</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-ok">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Kode Proses</th>
						<th>Proses</th>
						<th>Kode</th>
						<th>Nama</th>
						<th>Qty</th>
						<th>FO#</th>
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
	
	<div class="modal fade" id="browseXdModal" tabindex="-1" role="dialog" aria-labelledby="browseXdModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseXdModalLabel">Lihat Proses</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-xd">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Urutan</th>
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
		$("#QTYI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#QTYO").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
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
 		var dTableOk;
		loadDataOk = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('pakai/browseOk')}}",
				data: {
					flag: "{{$JNSPK}}",
				},
				success: function( response )
				{
					resp = response;
					if(dTableOk){
						dTableOk.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableOk.row.add([
							'<a href="javascript:void(0);" onclick="chooseOk(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KD_PRS+'\', \''+resp[i].NA_PRS+'\', \''+resp[i].NO_PRS+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',  \''+resp[i].KD_BHN+'\',  \''+resp[i].NA_BHN+'\',  \''+resp[i].PROSES+'\',  \''+resp[i].NO_SO+'\',  \''+resp[i].NO_FO+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KD_PRS,
							resp[i].NA_PRS,
							@if ($JNSPK == 'PK')
								resp[i].KD_BRG,
								resp[i].NA_BRG,
                    		@endif
							@if ($JNSPK == 'PW')
								resp[i].KD_BHN,
								resp[i].NA_BHN,
                    		@endif
							Intl.NumberFormat('en-US').format(resp[i].PROSES),	
							resp[i].NO_FO,
						]);
					}
					dTableOk.draw();
				}
			});
		}
		
		dTableOk = $("#table-ok").DataTable({
            columnDefs: [
                {
                    "className": "dt-right", 
                    "targets": 5,
                },			
				
            ],
		});
		
		browseOk = function(){
			loadDataOk();
			$("#browseOkModal").modal("show");
		}
		
		chooseOk = function(NO_BUKTI, KD_PRS, NA_PRS, NO_PRS, SATUAN, KD_BRG, NA_BRG, KD_BHN, NA_BHN, PROSES, NO_SO, NO_FO){
			$("#NO_OK").val(NO_BUKTI);
			$("#KD_PRSH").val(KD_PRS);
			$("#NA_PRSH").val(NA_PRS);
			$("#NO_PRS").val(NO_PRS);
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);
			@if ($JNSPK == 'PW')
				$("#KD_BHN_H").val(KD_BHN);
				$("#NA_BHN_H").val(NA_BHN);
			@endif
			$("#QTYI").val(PROSES);		
			$("#SATUANH").val(SATUAN);		
			$("#NO_SO").val(NO_SO);		
			$("#NO_FO").val(NO_FO);			
			$("#browseOkModal").modal("hide");
			$("#QTYI").autoNumeric('update');
			$("#QTYO").autoNumeric('update');
			// getFod(NO_FO);
			if (NO_PRS=='1')
			{
				cekOrderkWIP(function(data) {
					if(data)
					{
						alert("Masih ada order kerja WIP yang belum diproses!");
					}
				});
			}
		}
		
		$("#NO_OK").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseOk();
			}
		}); 
//////////////////////////////////////////////////////////////////////////////////////////////////
		var dTableXd;
		loadDataXd = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('pakai/browseXd')}}",
				data: {
					nobukti: $("#NO_OK").val(),
				},
				success: function( resp )
				{
					if(dTableXd){
						dTableXd.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableXd.row.add([
							'<a href="javascript:void(0);" onclick="chooseXd(\''+resp[i].KD_PRS+'\',  \''+resp[i].NA_PRS+'\', \''+resp[i].NO_PRS+'\')">'+resp[i].KD_PRS+'</a>',
							resp[i].NA_PRS,
							resp[i].NO_PRS,
						]);
					}
					dTableXd.draw();
				}
			});
		}
		
		dTableXd = $("#table-xd").DataTable({
			"ordering": false,
		});
		
		browseXd = function(){
			loadDataXd();
			$("#browseXdModal").modal("show");
			if (NO_PRS=='1')
			{
				cekOrderkWIP(function(data) {
					if(data)
					{
						alert("Masih ada order kerja WIP yang belum diproses!");
					}
				});
			}
			else
			{
				getFod($("#NO_FO").val());
			}
		}
		
		chooseXd = function(KD_PRS, NA_PRS, NO_PRS){
			$("#KD_PRSH").val(KD_PRS);
			$("#NA_PRSH").val(NA_PRS);			
			$("#NO_PRS").val(NO_PRS);
			$("#browseXdModal").modal("hide");
			getFod($("#NO_FO").val());
		}
		
		$("#KD_PRSH").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseXd();
			}
		}); 
///////////////////////////////////////////////////////////////////////////////////////////////////
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
		loadDataBhn = function(){
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
							'<a href="javascript:void(0);" onclick="chooseBhn(\''+resp[i].KD_BHN+'\',  \''+resp[i].NA_BHN+'\',  \''+resp[i].SATUAN+'\')">'+resp[i].KD_BHN+'</a>',
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
			loadDataBhn();
			$("#browseBhnModal").modal("show");
		}
		
		chooseBhn = function(KD_BHN,NA_BHN,SATUAN){
			$("#KD_BHN"+rowidBhn).val(KD_BHN);
			$("#NA_BHN"+rowidBhn).val(NA_BHN);		
			$("#SATUAN"+rowidBhn).val(SATUAN);		
			$("#browseBhnModal").modal("hide");
		}
		
		$("#KD_BHN0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBhn(0);
			}
		}); 
	});
////////////////////////////////////////////////////////////////////////////////////
	function getFod(bukti)
	{
		$.ajax(
			{
				type: 'GET',    
				url: "{{url('orderk/browseFodPrs')}}",
				data: {
					NO_FO : $("#NO_FO").val(),
					KD_PRSH : $("#KD_PRSH").val(),
				},
				success: function( resp )
				{
					var html = '';
					for(i=0; i<resp.length; i++){
						html+=`<tr>
                                    <td><input name='REC[]' id=REC${i} value=${resp[i].REC+1} type='text' class='REC form-control' onkeypress='return tabE(this,event)' style='text-align: center;' readonly></td>
                                    <td><input name='KD_BHN[]' data-rowid=${i} id=KD_BHN${i} value="${resp[i].KD_BHN}" type='text' class='form-control KD_BHN' required readonly></td>
                                    <td><input name='NA_BHN[]' data-rowid=${i} id=NA_BHN${i} value="${resp[i].NA_BHN}" type='text' class='form-control  NA_BHN' required readonly></td>
                                    <td><input name='SATUAN[]' data-rowid=${i} id=SATUAN${i} value="${resp[i].SATUAN}" type='text' class='form-control  SATUAN' placeholder="Satuan" required readonly></td>
                                    <td><input name='QTY[]' onclick='select()' onkeyup='hitung()' id=QTY${i} value="${resp[i].QTY*$("#QTYI").val()}" type='text' style='text-align: right' class='form-control QTY text-primary' required> <input name='QTYX[]' id=QTYX${i} value="${resp[i].QTY}" type='text' class='form-control QTYX text-primary' readonly hidden></td>
                                    <td><input name='KET[]' id=KET${i} value="${resp[i].KET}" type='text' class='form-control  KET' required></td>
                                    <td><button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button></td>
                                </tr>`;
					}
					$('#detailPakai').html(html);
					$(".QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".QTY").autoNumeric('update');
					idrow=resp.length;
					baris=resp.length;

					nomor();
				}
			});
	}
	
	function cekOrderkWIP(func){
		$.ajax(
		{
			type: 'GET',    
			url: "{{url('pakai/cekOrderkWIP')}}",
			data: {
				'no_so': $("#NO_SO").val(),
			},
			success: function(resp)
			{
				if($.trim(resp)!='')
				{
            		func(resp[0].NO_BUKTI);
				}
			},
			// error: function(errorThrown){
			// 	alert(errorThrown);
			// }     
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

		if ( $('#NO_OK').val()=='' ) 
		{			
			check = '1';
			alert("Order Kerja Harus diisi.");
		}
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
	
		if ( check == '0' )
		{
			cekOrderkWIP(function(data) {
				if(data)
				{
					alert("Masih ada order kerja WIP yang belum diproses!");
				}
				else
				{
					document.getElementById("entri").submit();  
				}
			});
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
		var QTYI = parseFloat($("#QTYI").val().replace(/,/g, ''));

		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat(z.find('.QTYX').val().replace(/,/g, ''));

            var QTY = QTYI * QTYX;
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

        td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control '  onkeypress='return tabE(this,event)' style='text-align: center;' readonly>";
        // td2.innerHTML = "<input name='KD_PRS[]' data-rowid='"+idrow+"' id=KD_PRS" + idrow + " type='text' class='form-control KD_PRS' placeholder='Proses#' required readonly>";
        // td3.innerHTML = "<input name='NA_PRS[]' id=NA_PRS" + idrow + " type='text' class='form-control  NA_PRS' required readonly>";
        td2.innerHTML = "<input name='KD_BHN[]' data-rowid='"+idrow+"' id=KD_BHN" + idrow + " type='text' class='form-control KD_BHN' placeholder='Bahan#' required readonly>";
        td3.innerHTML = "<input name='NA_BHN[]' id=NA_BHN" + idrow + " type='text' class='form-control  NA_BHN' required readonly>";
        td4.innerHTML = "<input name='SATUAN[]' id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' placeholder='Satuan' required readonly>";
		td5.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY  text-primary' placeholder='Qty' required> <input name='QTYX[]' value='0' id=QTYX" + idrow + " type='text' class='form-control QTYX  text-primary' readonly hidden>";
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
