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
            <h1 class="m-0">Tambah Sales Order Baru</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/so">Transaksi Sales Order </a></li>
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
                                    <label for="NO_BUKTI" class="form-label">Nomor Bukti</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti" value="+" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}" >
								
                                </div>
                            </div>

							
							<div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="KODEC" class="form-label">Customer</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Masukkan Customer" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="Nama" readonly>
                                </div>
                            </div>
							
							
							 <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="ALAMAT" class="form-label">Alamat</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" placeholder="Masukkan Alamat" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="KOTA" class="form-label">Kota</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" placeholder="KOTA" readonly>
                                </div>
                            </div>

							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES">
                                </div>
        

                            </div>
							
						
                     
							<hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BRG" class="form-label">Kode Barang</label></th>
                                        <th style="text-align: center;">Nama</th>
                                        <th style="text-align: center;">Stn</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Harga</th>
										<th style="text-align: center;">Total</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BRG[]" id="KD_BRG0" type="text" class="form-control KD_BRG " required>
                                        </td>
                                        <td>
                                            <input name="NA_BRG[]" id="NA_BRG0" type="text" class="form-control NA_BRG" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN" required>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="0" id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary"></td>                         
										<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" value="0" id="HARGA0" type="text" style="text-align: right"  class="form-control HARGA text-primary"></td>
										<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="0" id="TOTAL0" type="text" style="text-align: right"  class="form-control TOTAL text-primary" readonly></td>
                                        
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
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="0" readonly></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="0" readonly></td>
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
	
	
	<div class="modal fade" id="browseCustomerModal" tabindex="-1" role="dialog" aria-labelledby="browseCustomerModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustomerModalLabel">Cari Customer</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bcustomer">
				<thead>
					<tr>
						<th>Customer#</th>
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

@section('footer-scripts')
<!-- TAMBAH 1 -->
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

	var idrow = 1;
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

// TAMBAH HITUNG
	$(document).ready(function() {

		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
///////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		
		//CHOOSE Bacno
 		var dTableBCustomer;
		loadDataBCustomer = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('cust/browse')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBCustomer){
						dTableBCustomer.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBCustomer.row.add([
							'<a href="javascript:void(0);" onclick="chooseCustomer(\''+resp[i].KODEC+'\',\''+resp[i].NAMAC+'\')">'+resp[i].KODEC+'</a>',
							resp[i].NAMAC,
						]);
					}
					dTableBCustomer.draw();
				}
			});
		}
		
		dTableBCustomer = $("#table-bcustomer").DataTable({
			
		});
		
		browseCustomer = function(){
			loadDataBCustomer();
			$("#browseCustomerModal").modal("show");
		}
		
		chooseCustomer = function(KODEC,NAMAC){
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#browseCustomerModal").modal("hide");
		}
		
		$("#KODEC").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseCustomer();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		



		
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
							'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\',\''+resp[i].NA_BRG+'\')">'+resp[i].KD_BRG+'</a>',
							resp[i].NA_BRG,
						]);
					}
					dTableBBarang.draw();
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});
		
		browseBarang = function(rid){
			rowidBarang = rid;
			loadDataBBarang();
			$("#browseBarangModal").modal("show");
		}
		
		chooseBarang = function(KD_BRG, NA_BRG){
			$("#KD_BRG"+rowidBarang).val(KD_BRG);
			$("#NA_BRG"+rowidBarang).val(NA_BRG);
			$("#browseBarangModal").modal("hide");
		}
		
		
		$("#KD_BRG0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(0);
			}
		}); 
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
		var TTOTAL = 0;

		var total_row = idrow;
		for (i=0;i<total_row;i++) {};


		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat($(this).val().replace(/,/g, ''));
			var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
		
            var TOTALX = HARGAX * QTYX;
			z.find('.TOTAL').val(TOTALX);
			
		    z.find('.TOTAL').autoNumeric('update');
		
            TTOTAL_QTY +=QTYX;
            TTOTAL += TOTALX;
			
		});
		
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;
		if(isNaN(TTOTAL)) TTOTAL = 0;


		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		$('#TTOTAL').val(numberWithCommas(TTOTAL));


		$("#TTOTAL_QTY").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
		
	}

    function tambah() {

        var x = document.getElementById('datatable').insertRow(idrow + 1);
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
        td2.innerHTML = "<input name='KD_BRG[]' data-rowid='"+idrow+"'  id=KD_BRG" + idrow + " type='text' class='form-control KD_BRG'  required>";
        td3.innerHTML = "<input name='NA_BRG[]'   id=NA_BRG" + idrow + " type='text' class='form-control  NA_BRG' required readonly>";
        td4.innerHTML = "<input name='SATUAN[]'   id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' required>";
		td5.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY  text-primary' required>";
		td6.innerHTML = "<input name='HARGA[]' onclick='select()' onkeyup='hitung()' value='0' id=HARGA" + idrow + " type='text' style='text-align: right' class='form-control HARGA  text-primary' required>";
 		td7.innerHTML = "<input name='TOTAL[]' onclick='select()' onkeyup='hitung()' value='0' id=TOTAL" + idrow + " type='text' style='text-align: right' class='form-control TOTAL  text-primary' required readonly>";
        td8.innerHTML = "<input name='KET[]'   id=KET" + idrow + " type='text' class='form-control  KET' required>";
		td9.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$("#KD_BRG"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(eval($(this).data("rowid")));
			}
		}); 
		
		idrow++;
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
