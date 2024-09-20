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
            <h1 class="m-0">Tambah Transaksi Piutang</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/thut">Transaksi Piutang</a></li>
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
        
                            <div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red">*</label>									
                                    <label for="NO_SO" class="form-label">SO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="Masukkan SO#" readonly >
                                </div>
							</div>
							

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODEC" class="form-label">Customer#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Masukkan Suplier" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="-" readonly>
                                </div>
							</div>							
							
		
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="TOTAL" class="form-label">Total</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control TOTAL" id="TOTAL" name="TOTAL" placeholder="TOTAL" value="{{ number_format(0, 0, '.', ',') }}" style="text-align: right">
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

	
	
	<div class="modal fade" id="browseSoModal" tabindex="-1" role="dialog" aria-labelledby="browseSoModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSoModalLabel">Cari So#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bso">
				<thead>
					<tr>
						<th>So#</th>
						<th>Kode</th>
						<th>-</th>
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

			$('#TOTAL').val(numberWithCommas(TOTALX));	
		    $("#TOTAL").autoNumeric('update');	
				
		}		
		
		
		var dTableBSo;
		loadDataBSo = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('so/browseuang')}}',
				data: {
					'GOL': 'Y',
				},
				success: function( response )
				{
					resp = response;
					if(dTableBSo){
						dTableBSo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSo.row.add([
							'<a href="javascript:void(0);" onclick="chooseSo(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\', \''+resp[i].NAMAC+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODEC,
							resp[i].NAMAC
							
						]);
					}
					dTableBSo.draw();
				}
			});
		}
		
		dTableBSo = $("#table-bso").DataTable({
			
		});
		
		browseSo = function(){
			 loadDataBSo();
			$("#browseSoModal").modal("show");
		}
		
		chooseSo = function(NO_BUKTI,KODEC,NAMAC){
			$("#NO_SO").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);		
			$("#browseSoModal").modal("hide");
		}
		
		$("#NO_SO").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseSo();
			}
		}); 
		
		
		
		
    });



	function simpan() {
		var bulanTgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		if(bulanTgl.substring(3, 5)==bulanPer)
		{
			document.getElementById("entri").submit();
		}
		else
		{
			alert("Tanggal tidak sama dengan periode! ("+bulanTgl+")")
		}
	}
	
	
</script>

<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection

