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
            <h1 class="m-0">Tambah Hasil Produksi Baru</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/hasilpro">Hasil Produksi</a></li>
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
								<div align="right" class="col-md-2">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti#" value="+" readonly>
                                </div>
                            </div>

                            <div class="form-group row">							
                                <div align="right" class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}">
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div align="right" class="col-md-2">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">Pakai#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PAKAI" id="NO_PAKAI" name="NO_PAKAI" placeholder="No Pakai" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">Hasil</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control HASIL" id="HASIL" name="HASIL" placeholder="Hasil" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
							</div>

                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">OK#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_OK" id="NO_OK" name="NO_OK" placeholder="No Order Kerja" readonly>
                                </div>
							</div>

                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label for="KODEC" class="form-label">Customer#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Kode Customer" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">        
                                <div align="right" class="col-md-2">
                                    <label for="NAMAC" class="form-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NAMAC" id="NAMAC"name="NAMAC" placeholder="Nama Customer" readonly>
                                </div>
							</div>			
							
                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">SO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="No Sales Order" readonly>
                                </div>
							</div>

                            <div class="form-group row">
                                <div align="right" class="col-md-2">							
                                    <label class="form-label">Barang#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Kode Barang" readonly>
                                </div>
							</div>	
								
							<div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama Barang" readonly>
                                </div>
                            </div>
								
                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">Qty</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control QTY" id="QTY" name="QTY" placeholder="QTY" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
                                </div>
								
                                <div align="right" class="col-md-1">
                                    <label class="form-label">Satuan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN" id="SATUAN" name="SATUAN" placeholder="Satuan" readonly>
                                </div>
							</div>

                            <div class="form-group row">
                                <div align="right" class="col-md-2">
                                    <label class="form-label">Seri#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SERI" id="NO_SERI" name="NO_SERI" placeholder="No Seri" readonly>
                                </div>
							</div>

                            <div class="form-group row">				
                                <div align="right" class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes">
                                </div>
							</div>
                        </div>
        
						<hr style="margin-top: 30px; margin-buttom: 30px">

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
    <!-- /.content -->

	<div class="modal fade" id="browsePakaiModal" tabindex="-1" role="dialog" aria-labelledby="browsePakaiModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePakaiModalLabel">Lihat Pemakaian</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-pakai">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Order#</th>
						<th>Kode</th>
						<th>Customer</th>
						<th>So#</th>
						<th>Kode</th>
						<th>Barang</th>
						<th>Qty</th>
						<th>Satuan</th>
						<th>Seri#</th>
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
	
@endsection

@section('footer-scripts')
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

    $(document).ready(function () {
		$("#HASIL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		
		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
        });
			
//////////////////////////////////////////////////////////////////////////////////		
		var dTablePakai;
		loadDataPakai = function(){
			$.ajax(
			{
				type: 'GET', 		
				url: "{{url('hasilpro/browsePakai')}}",
				success: function(resp)
				{
					if(dTablePakai){
						dTablePakai.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTablePakai.row.add([
							'<a href="javascript:void(0);" onclick="choosePakai(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].NO_ORDER+'\', \''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\',  \''+resp[i].NO_SO+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',  \''+resp[i].QTY_OUT+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].NO_SERI+'\',  \''+resp[i].NOTES+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].NO_ORDER,
							resp[i].KODEC,
							resp[i].NAMAC,
							resp[i].NO_SO,
							resp[i].KD_BRG,
							resp[i].NA_BRG,
							resp[i].QTY_OUT,
							resp[i].SATUAN,
							resp[i].NO_SERI,
							resp[i].NOTES,
						]);
					}
					dTablePakai.draw();
				}
			});
		}
		
		dTablePakai = $("#table-pakai").DataTable({
			
		});
		
		browsePakai = function(){
			loadDataPakai();
			$("#browsePakaiModal").modal("show");
		}
		
		choosePakai = function(NO_BUKTI,NO_ORDER,KODEC,NAMAC,NO_SO,KD_BRG,NA_BRG,QTY_OUT,SATUAN,NO_SERI,NOTES){
			$("#NO_PAKAI").val(NO_BUKTI);
			$("#NO_OK").val(NO_ORDER);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);		
			$("#NO_SO").val(NO_SO);
			$("#KD_BRG").val(KD_BRG);		
			$("#NA_BRG").val(NA_BRG);
			$("#QTY_OUT").val(QTY_OUT);		
			$("#SATUAN").val(SATUAN);	
			$("#NO_SERI").val(NO_SERI);	
			$("#NOTES").val(NOTES);	
			$("#browsePakaiModal").modal("hide");
		}
		
		$("#NO_PAKAI").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browsePakai();
			}
		}); 
		
/////////////////////////////////////////////////////////////////////////////////////////////
    });

 function simpan() {
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
    	var HASILX = parseFloat($('#HASIL').val().replace(/,/g, ''));
    	var QTYX = parseFloat($('#QTY').val().replace(/,/g, ''));
        var check = '0';

		if ( $('#NO_PAKAI').val()=='' ) 
		{			
			check = '1';
			alert("PO# Harus diisi.");
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

		if (HASILX<0 || QTYX<0) 
		{			
			check = '1';
			alert("Tidak boleh minus!");
		}
		
		if ( check == '0' )
		{
			document.getElementById("entri").submit();  
		}
	}
</script>

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection