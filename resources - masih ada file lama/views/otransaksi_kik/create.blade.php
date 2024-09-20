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
            <h1 class="m-0">Tambah Pembelian Baru</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/beli">Transaksi Pembelian</a></li>
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
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti#" value="+" readonly >
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


                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NO_PO" class="form-label">PO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PO" id="NO_PO" name="NO_PO" placeholder="Masukkan PO">
                                </div>
							</div>
							

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODES" class="form-label">Suplier#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Masukkan Suplier">
                                </div>
							</div>
							
                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="NAMAS" class="form-label">-</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NAMAS" id="NAMAS"name="NAMAS" placeholder="-" readonly>
                                </div>
							</div>
							

							
                            <div class="form-group row">   
                                <div class="col-md-2">
                                    <label for="KD_BRG" class="form-label">Barang#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Masukkan Barang">
                                </div>
							</div>
							
							
                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="NA_BRG" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG"name="NA_BRG" placeholder="-" readonly>
                                </div>
							</div>	

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KG" class="form-label">Kg#</label>
                                </div>
                                <div class="col-md-2">
                                       <input type="text" class="form-control KG" onclick="select()" onkeyup="hitung()" style="text-align: right" id="KG" name="KG" placeholder="Masukkan Kg" value="0" >
                                </div>
							</div>
							
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="HARGA" class="form-label">Harga</label>
                                </div>
                                <div class="col-md-2">
                                      <input type="text" class="form-control HARGA" onclick="select()" onkeyup="hitung()" style="text-align: right" id="HARGA" name="HARGA" placeholder="Masukkan Harga" value="0">
                                </div>
							</div>
		
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="TOTAL" class="form-label">Total</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control TOTAL" style="text-align: right" id="TOTAL" name="TOTAL" placeholder="Masukkan Total" value="0" readonly>
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
							
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="RPRATE" class="form-label">RpRate</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control RPRATE" onclick="select()" onkeyup="hitung()" style="text-align: right" id="RPRATE" name="RPRATE" placeholder="Masukkan Rprate" value="1">
                                </div>
							</div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="RPHARGA" class="form-label">RpHarga</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control RPHARGA" style="text-align: right" id="RPHARGA" name="RPHARGA" placeholder="Masukkan Rpharga" value="0" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="RPTOTAL" class="form-label">RpTotal</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control RPTOTAL" style="text-align: right" id="RPTOTAL" name="RPTOTAL" placeholder="Masukkan RpTotal" value="0" readonly>
                                </div>
         				                        
                            </div>
         				                        
        
        
                            <hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            
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
@endsection

@section('footer-scripts')

<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>

<script>
    var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
		
		
		
		$("#harga").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#kg").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#rprate").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#total").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#rptotal").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#rpharga").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
			
		});
		
		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
        });
		
		$('#kg').keyup(function(){
           hitung();
        });
		
		$('#harga').keyup(function(){
           hitung();
        });
		
		$('#rprate').keyup(function(){
           hitung();
        });
		
    });



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
		// hitung();
	}

	function hitung() {
		var kg = parseFloat($('#kg').val().replace(/,/g, ''));
		var harga = parseFloat($('#harga').val().replace(/,/g, ''));
		var rprate = parseFloat($('#rprate').val().replace(/,/g, ''));
		
		var total = kg*harga;		
		var rptotal = kg*harga*rprate;
		var rpharga = harga*rprate;
		
		if(isNaN(total)) total = 0;
		if(isNaN(rptotal)) rptotal = 0;
		if(isNaN(rpharga)) rpharga = 0;

		$('#total').val(numberWithCommas(total));
		$('#rptotal').val(numberWithCommas(rptotal));
		$('#rpharga').val(numberWithCommas(rpharga));

		$('#total').autoNumeric('update');
		$('#rptotal').autoNumeric('update');
		$('#rpharga').autoNumeric('update');
	}
	
</script>


<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection

