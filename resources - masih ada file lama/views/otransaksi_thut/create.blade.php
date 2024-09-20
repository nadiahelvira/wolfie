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
            <h1 class="m-0">Tambah Transaksi Hutang</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/thut">Transaksi Hutang</a></li>
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
                    <form action="store" id="entri"  method="POST">
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
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti#" value="+" readonly>
                                </div>
                            </div>

                            <div class="form-group row">							
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}"  >
								
                                </div>
                            </div>
 <!--       
                            <div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red">*</label>									
                                    <label for="NO_PO" class="form-label">PO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PO" id="NO_PO" name="NO_PO" placeholder="Masukkan PO#" readonly>
                                </div>
							</div>
							
-->

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODES" class="form-label">Suplier#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Masukkan Suplier" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="NAMAS" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS"name="NAMAS" placeholder="-" readonly>
                                </div>
							</div>							
							
	

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODEC" class="form-label">Tujuan#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Masukkan Tujuan" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC"name="NAMAC" placeholder="-" readonly>
                                </div>
							</div>	

                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="TRUCK" class="form-label">Truck</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TRUCK" id="TRUCK" name="TRUCK" placeholder="-" >
                                </div>
							</div>	

							<div class="form-group row">							
                                <div class="col-md-2">
                                    <label for="TGL_KRM" class="form-label">Tgl-Kirim</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date" id="TGL_KRM" name="TGL_KRM" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}"  >
								
                                </div>
                            </div>
							
							<div class="form-group row">							
                                <div class="col-md-2">
                                    <label for="TGL_BKR" class="form-label">Tgl_Bongkar</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date" id="TGL_BKR" name="TGL_BKR" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}"  >
								
                                </div>
                            </div>


                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="KG" class="form-label">Kg</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control KG" id="KG" name="KG" placeholder="KG" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>

                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="HARGA" class="form-label">Harga</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control HARGA" id="HARGA" name="HARGA" placeholder="HARGA" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>
							

                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="TOTAL1" class="form-label">Total1</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control TOTAL1" id="TOTAL1" name="TOTAL1" placeholder="TOTAL1" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right" readonly>
                                </div>
										
							</div>

							
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="B_INAP" class="form-label">B-Inap</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control B_INAP" id="B_INAP" name="B_INAP" placeholder="B_INAP" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>
							

                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="B_BON" class="form-label">B-Bon</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control B_BON" id="B_BON" name="B_BON" placeholder="B_BON" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>


                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="B_MSOL" class="form-label">B-Solar</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control B_MSOL" id="B_MSOL" name="B_MSOL" placeholder="B_MSOL" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>


                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="B_LAIN" class="form-label">B-Lain</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control B_LAIN" id="B_LAIN" name="B_LAIN" placeholder="B_LAIN" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
										
							</div>

							
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="TOTAL" class="form-label">Total</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control TOTAL" id="TOTAL" name="TOTAL" placeholder="TOTAL" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right" readonly>
                                </div>
										
							</div>
				
				
                            <div class="form-group row">				
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes">
                                </div>
							</div>
							
							
        
                            <hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            
                        </div>
        
                        <div class="mt-3">
                            <button type="button" onclick="simpan()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
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

	
	<div class="modal fade" id="browseSuplierModal" tabindex="-1" role="dialog" aria-labelledby="browseSuplierModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSuplierModalLabel">Cari Suplier</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bsuplier">
				<thead>
					<tr>
						<th>Suplier</th>
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




	<div class="modal fade" id="browseTruckModal" tabindex="-1" role="dialog" aria-labelledby="browseTruckModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustomerModalLabel">Cari Truck</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-btruck">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nopol</th>
						<th>Sopir</th>
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

    var target;
	var idrow = 1;
    
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}


    $(document).ready(function () {
		
		$("#KG").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#HARGA").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TOTAL1").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#B_INAP").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});				
		$("#B_BON").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#B_MSOL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});				
		$("#B_LAIN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});	
		$("#TOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
			
		});
		
		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
        });
		
		hitung=function() {
		
			var KGX = parseFloat($('#KG').val().replace(/,/g, ''));
			var HARGAX = parseFloat($('#HARGA').val().replace(/,/g, ''));
		
            var TOTAL1X = HARGAX * KGX;
			$('#TOTAL1').val(numberWithCommas(TOTAL1X));
		    $("#TOTAL1").autoNumeric('update');
			
			var B_INAPX = parseFloat($('#B_INAP').val().replace(/,/g, ''));
			var B_BONX = parseFloat($('#B_BON').val().replace(/,/g, ''));
			var B_LAINX = parseFloat($('#B_LAIN').val().replace(/,/g, ''));
			var B_MSOLX = parseFloat($('#B_MSOL').val().replace(/,/g, ''));
			
 	        var TOTALX = TOTAL1X + B_INAPX - B_BONX + B_MSOLX + B_LAINX;		
			$('#TOTAL').val(numberWithCommas(TOTALX));
		    $("#TOTAL").autoNumeric('update');	
		
		
		}			
		
		
		
		//CHOOSE Bacno
 		var dTableBSuplier;
		loadDataBSuplier = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('sup/browse')}}',
				data: {
					'GOL': 'Y',
				},
				success: function( response )
				{
					resp = response;
					if(dTableBSuplier){
						dTableBSuplier.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSuplier.row.add([
							'<a href="javascript:void(0);" onclick="chooseSuplier(\''+resp[i].KODES+'\',  \''+resp[i].NAMAS+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODES+'</a>',
							resp[i].NAMAS,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableBSuplier.draw();
				}
			});
		}
		
		dTableBSuplier = $("#table-bsuplier").DataTable({
			
		});
		
		browseSuplier = function(){
			 loadDataBSuplier();
			$("#browseSuplierModal").modal("show");
		}
		
		chooseSuplier = function(KODES,NAMAS, ALAMAT, KOTA){
			$("#KODES").val(KODES);
			$("#NAMAS").val(NAMAS);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);			
			$("#browseSuplierModal").modal("hide");
		}
		
		$("#KODES").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseSuplier();
			}
		}); 
		
//////////////////////////////////////////////////////////////////////////

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
							'<a href="javascript:void(0);" onclick="chooseCustomer(\''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODEC+'</a>',
							resp[i].NAMAC,
							resp[i].ALAMAT,
							resp[i].KOTA,
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
		
		chooseCustomer = function(KODEC,NAMAC,ALAMAT, KOTA){
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);
			$("#browseCustomerModal").modal("hide");
		}
		
		$("#KODEC").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseCustomer();
			}
		}); 

//////////////////////////////////////////////////////////

	//CHOOSE Bacno
 		var dTableBTruck;
		loadDataBTruck = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('truck/browse')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBTruck){
						dTableBTruck.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBTruck.row.add([
							'<a href="javascript:void(0);" onclick="chooseTruck(\''+resp[i].KODE+'\',  \''+resp[i].NOPOL+'\', \''+resp[i].SOPIR+'\')">'+resp[i].KODE+'</a>',
							resp[i].NOPOL,
							resp[i].SOPIR,
						]);
					}
					dTableBCustomer.draw();
				}
			});
		}
		
		dTableBTruck = $("#table-btruck").DataTable({
			
		});
		
		browseTruck = function(){
			loadDataBTruck();
			$("#browseTruckModal").modal("show");
		}
		
		chooseCustomer = function(KODE, NOPOL){
			$("#TRUCK").val(NOPOL);
			$("#KD_TRUCK").val(KODE);
			$("#browseTruckModal").modal("hide");
		}
		
		$("#TRUCK").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseTruck();
			}
		}); 




//CH
		
		
		
		
    });



 function simpan() {
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
			if ( $('#KODES').val()=='' ) 
          	{			
			    check = '1';
				alert("Suplier# Harus diisi.");
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
	
	
</script>

<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection

