@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Edit Penjualan {{$header->NO_BUKTI}}</h1>	
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/jual')}}">Penjualan</a></li>
                <li class="breadcrumb-item active">Edit {{$header->NO_BUKTI}}</li>
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
                    <form action="{{url('/jual/update/'.$header->NO_ID)}}" method="POST">
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
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}">
                                </div>
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{$header->TGL}}">

                                </div>
                            </div>
 
 
                            <div class="form-group row">
								<div class="col-md-2">
                                    <label for="NO_SJ" class="form-label">Sj#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_SJ" id="NO_SJ" name="NO_SJ" placeholder="Masukkan Sj#" >
                                </div>
                            
                            </div>
							
							
							<div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="KODEC" class="form-label">Customer</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Masukkan Customer#">
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="NAMAC" readonly>
                                </div>
                            </div>
							
							
							 <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="ALAMAT" class="form-label">Alamat</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" placeholder="Masukkan Alamat">
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
                                    <label for="TRUCK" class="form-label">Truck</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TRUCK" id="TRUCK" name="TRUCK" placeholder="Masukkan Truck">
                                </div>
        
                                <div class="col-md-2">
                                    <label for="SOPIR" class="form-label">Sopir</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control SOPIR" id="SOPIR" name="SOPIR" placeholder="SOPIR" readonly>
                                </div>
                            </div>
                            
														
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan notes">
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
                                        <th style="text-align: center;">Satuan</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Harga</th>
										<th style="text-align: center;">Total</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
										
                                            <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$sod->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
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
										<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="0" id="TOTAL0" type="text" style="text-align: right"  class="form-control TOTAL text-primary"></td>
                                        
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
                                    <td><input class="form-control TJUMLAH  text-primary font-weight-bold" style="text-align: right"  id="TJUMLAH" name="TJUMLAH" value="0" readonly></td>
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
	
	
	
	<div class="modal fade" id="browseAccountModal" tabindex="-1" role="dialog" aria-labelledby="browseAccountModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAccountModalLabel">Cari Account</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-baccount">
				<thead>
					<tr>
						<th>Account#</th>
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


	<div class="modal fade" id="browseAccount1Modal" tabindex="-1" role="dialog" aria-labelledby="browseAccount1ModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAccount1ModalLabel">Cari Account</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-baccount1">
				<thead>
					<tr>
						<th>Account#</th>
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
    var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
    });

    // TAMBAH HITUNG
	$(document).ready(function() {

		$("#TJUMLAH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
 		var dTableBAccount1;
		loadDataBAccount1 = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBAccount1){
						dTableBAccount1.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAccount1.row.add([
							'<a href="javascript:void(0);" onclick="chooseAccount1(\''+resp[i].ACNO+'\',\''+resp[i].NAMA+'\')">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAccount1.draw();
				}
			});
		}
		
		dTableBAccount1 = $("#table-baccount1").DataTable({
			
		});
		
		browseAccount1 = function(){
			loadDataBAccount1();
			$("#browseAccount1Modal").modal("show");
		}
		
		chooseAccount1 = function(acno,nama){
			$("#bacno").val(acno);
			$("#bnama").val(nama);
			$("#browseAccount1Modal").modal("hide");
		}
		
		$("#bacno").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount1();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////
		



		
//////////////////////////////////////////////////////////////////////
		
 		var dTableBAccount;
		var rowidAccount;
		loadDataBAccount = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('account/browse')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBAccount){
						dTableBAccount.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAccount.row.add([
							'<a href="javascript:void(0);" onclick="chooseAccount(\''+resp[i].ACNO+'\',\''+resp[i].NAMA+'\')">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAccount.draw();
				}
			});
		}
		
		dTableBAccount = $("#table-baccount").DataTable({
			
		});
		
		browseAccount = function(rid){
			rowidAccount = rid;
			loadDataBAccount();
			$("#browseAccountModal").modal("show");
		}
		
		chooseAccount = function(acno,nama){
			$("#ACNO"+rowidAccount).val(acno);
			$("#NACNO"+rowidAccount).val(nama);
			$("#browseAccountModal").modal("hide");
		}
		
		
		$("#ACNO0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount(0);
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
		var TJUMLAH = 0;


		var total_row = idrow;
		for (i=0;i<total_row;i++) {};

		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});
		

		if(isNaN(TJUMLAH)) TJUMLAH = 0;


		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));


		$("#TJUMLAH").autoNumeric('update');

	}

    function tambah() {

        var x = document.getElementById('datatable').insertRow(idrow + 1);
        var td1 = x.insertCell(0);
        var td2 = x.insertCell(1);
        var td3 = x.insertCell(2);
        var td4 = x.insertCell(3);
        var td5 = x.insertCell(4);
        var td6 = x.insertCell(5);
        //var td6 = x.insertCell(5);

        td1.innerHTML = "<input name='NO_ID[]' id='NO_ID"+idrow+"' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
        //<input name="LAT[]" id="LAT0" type="text" class="form-control LAT  " required>
        td2.innerHTML = "<input name='ACNO[]' data-rowid='"+idrow+"'  id=ACNO" + idrow + " type='text' class='form-control ACNO'  required>";
        td3.innerHTML = "<input name='NACNO[]'   id=NACNO" + idrow + " type='text' class='form-control  NACNO' required readonly>";
        td4.innerHTML = "<input name='URAIAN[]'   id=URAIAN" + idrow + " type='text' class='form-control  URAIAN' required>";
		td5.innerHTML = "<input name='JUMLAH[]' onclick='select()' onkeyup='hitung()' value='0' id=JUMLAH" + idrow + " type='text' style='text-align: right' class='form-control JUMLAH  text-primary' required>";
        td6.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$("#ACNO"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount(eval($(this).data("rowid")));
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

