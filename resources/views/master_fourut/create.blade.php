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
            <h1 class="m-0">Tambah Master Formula</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/fo">Transaksi Master Formula</a></li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="store" method="POST">
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
								<div class="col-md-2">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti#" value="+" readonly>
                                </div>
							</div>	
        
							<div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red;font-size:20px">* </label>									
                                    <label for="KD_BRG" class="form-label">Kode</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Masukkan Kode" readonly >
                                </div>
								
								<div class="col-md-2">
                                    <label for="NA_BRG" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                   <input class="form-control date" id="NA_BRG" name="NA_BRG" placeholder="Masukkan Nama" readonly>
                                </div>
                            </div>

							
							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES">
                                </div>
								
								<div class="col-md-6">
									<input type="checkbox" class="form-check-input" id="AKTIF" name="AKTIF" value="1" checked>
									<label for="AKTIF">Aktif</label>
										
								</div>
        
                            </div>
							
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_PRS" class="form-label">Kode Proses</label></th>
                                        <th style="text-align: center;">Nama Proses</th>
										<th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BHN" class="form-label">Kode Bahan</label></th>
                                        <th style="text-align: center;">Nama Bahan</th>
										<th style="text-align: center;">Satuan</th>
										<th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
										<td>
                                            <input name="KD_PRS[]" id="KD_PRS0" type="text" class="form-control KD_PRS" readonly  required>
                                        </td>
                                        <td>
                                            <input name="NA_PRS[]" id="NA_PRS0" type="text" class="form-control NA_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN0" type="text" class="form-control KD_BHN" readonly  required>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN0" type="text" class="form-control NA_BHN" readonly required>
                                        </td>
										<td>
                                            <input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="0" id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary"></td>
                                        
										<td>
                                            <input name="KET[]" id="KET0" type="text" class="form-control KET" required>
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
                            <button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
                            <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
	

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



	<div class="modal fade" id="browseProsesModal" tabindex="-1" role="dialog" aria-labelledby="browseProsesModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseProsesModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bproses">
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



	<div class="modal fade" id="browseBahanModal" tabindex="-1" role="dialog" aria-labelledby="browseBahanModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBahanModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bbahan">
				<thead>
					<tr>
						<th>Item#</th>
						<th>Nama</th>
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
<!-- TAMBAH 1 -->
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

	var idrow = 1;
	var baris = 1;
	
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

// TAMBAH HITUNG
	$(document).ready(function() {

		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
	<!--		$("#QTYC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});    -->
	<!--		$("#QTYR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});    -->
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
		
		


		
//////////////////////////////////////////////////////////////////////
	
	
		var dTableBBarang;
		var rowidBarang;
		loadDataBBarang = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('brg/browse')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBBarang){
						dTableBBarang.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBarang.row.add([
							'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\',\''+resp[i].NA_BRG+'\', \''+resp[i].SATUAN+'\' )">'+resp[i].KD_BRG+'</a>',
							resp[i].NA_BRG,
							resp[i].SATUAN,
						]);
					}
					dTableBBarang.draw();
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		})
		
		browseBarang = function(){
			loadDataBBarang();
			$("#browseBarangModal").modal("show");
		}
		
		chooseBarang = function(KD_BRG,NA_BRG,SATUAN){
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);
			$("#SATUAN").val(SATUAN);
			$("#browseBarangModal").modal("hide");
		}
		
		
		$("#KD_BRG").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(0);
			}
		})
		
	
	
		var dTableBProses;
		var rowidProses;
		loadDataBProses = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('prs/browseb')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBProses){
						dTableBProses.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBProses.row.add([
							'<a href="javascript:void(0);" onclick="chooseProses(\''+resp[i].KD_PRS+'\',\''+resp[i].NA_PRS+'\')">'+resp[i].KD_PRS+'</a>',
							resp[i].NA_PRS,
						]);
					}
					dTableBProses.draw();
				}
			});
		}
		
		dTableBProses = $("#table-bproses").DataTable({
			
		});
		
		browseProses = function(rid){
			rowidProses = rid;
			loadDataBProses();
			$("#browseProsesModal").modal("show");
		}
		
		chooseProses = function(KD_PRS,NA_PRS){
			$("#KD_PRS"+rowidProses).val(KD_PRS);
			$("#NA_PRS"+rowidProses).val(NA_PRS);
			$("#browseProsesModal").modal("hide");
		}
		
		
		$("#KD_PRS0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseProses(0);
			}
		})


	
 		var dTableBBahan;
		var rowidBahan;
		loadDataBBahan = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('bhn/browseb')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBBahan){
						dTableBBahan.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBahan.row.add([
							'<a href="javascript:void(0);" onclick="chooseBahan(\''+resp[i].KD_BHN+'\',\''+resp[i].NA_BHN+'\', \''+resp[i].SATUAN+'\' )">'+resp[i].KD_BHN+'</a>',
							resp[i].NA_BHN,
							resp[i].SATUAN,
						]);
					}
					dTableBBahan.draw();
				}
			});
		}
		
		dTableBBahan = $("#table-bbahan").DataTable({
			
		})
		
		browseBahan = function(rid){
			rowidBahan = rid;
			loadDataBBahan();
			$("#browseBahanModal").modal("show");
		}
		
		chooseBahan = function(KD_BHN,NA_BHN,SATUAN){
			$("#KD_BHN"+rowidBahan).val(KD_BHN);
			$("#NA_BHN"+rowidBahan).val(NA_BHN);
			$("#SATUAN"+rowidBahan).val(SATUAN);
			$("#browseBahanModal").modal("hide");
		}
		
		
		$("#KD_BHN0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBahan(0);
			}
		}) 
	});



//////////////////////////////////////////////////////////////////


	function simpan() {

		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
			if ( $('#BACNO').val()=='' ) 
            {			
			    check = '1';
				alert("Bank Harus diisi.");
			}
			

			if ( tgl.substring(3,5) != bulanPer ) 
			{
				
				check = '1';
				alert("Bulan tidak sama dengan Periode");
			}	
			

			if ( tgl.substring(tgl.length-4) != tahunPer )
			{
				check = '1';
				alert("Tahun tidak sama dengan Periode");
				
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


		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTY = parseFloat(z.find('.QTY').val().replace(/,/g, ''));
		
            //var QTYX  = QTYRX - QTYCX;
			//z.find('.QTY').val(QTYX);
			
		    //z.find('.QTY').autoNumeric('update');
		
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
        var td8 = x.insertCell(7);
        var td9 = x.insertCell(8); 
		//var td6 = x.insertCell(5);

        td1.innerHTML = "<input name='REC[]'    id=REC" + idrow + " type='text' class='REC form-control '  onkeypress='return tabE(this,event)' readonly>";
        //<input name="LAT[]" id="LAT0" type="text" class="form-control LAT  " required>
        td2.innerHTML = "<input name='KD_PRS[]' data-rowid='"+idrow+"'  id=KD_PRS" + idrow + " type='text' class='form-control KD_PRS' readonly required>";
        td3.innerHTML = "<input name='NA_PRS[]'   id=NA_PRS" + idrow + " type='text' class='form-control  NA_PRS' required readonly>";
        td4.innerHTML = "<input name='KD_BHN[]' data-rowid='"+idrow+"'  id=KD_BHN" + idrow + " type='text' class='form-control KD_BHN' readonly required>";
		td5.innerHTML = "<input name='NA_BHN[]'   id=NA_BHN" + idrow + " type='text' class='form-control  NA_BHN' required readonly>";
		td6.innerHTML = "<input name='SATUAN[]'   id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' required readonly>";
 		td7.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY text-primary' required>";
        td8.innerHTML = "<input name='KET[]'   id=KET" + idrow + " type='text' class='form-control  KET' required>";
		td9.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		<!--	$("#QTYC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});   -->
		<!--	$("#QTYR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});   -->
		}
		
		$("#KD_PRS"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseProses(eval($(this).data("rowid")));
			}
		}); 
			
		$("#KD_BHN"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBahan(eval($(this).data("rowid")));
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


<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection