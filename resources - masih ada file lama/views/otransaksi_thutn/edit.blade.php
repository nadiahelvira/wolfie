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
               <h1 class="m-0">Edit Transaksi Hutang Non {{$NO_BUKTI}}</h1>	
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/thutn')}}">Transaksi Hutang Non</a></li>
                <li class="breadcrumb-item active">Edit {{$NO_BUKTI}}</li>
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
                    <form action="{{url('/thutn/update/'.$NO_ID)}}" id="entri" method="POST">
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
                                    placeholder="Masukkan Bukti#" value="{{$NO_BUKTI}}" readonly>
                                </div>
        
                            </div>

                            <div class="form-group row">

        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl </label>
                                </div>
                                <div class="col-md-4">

								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($TGL))}}">

                                </div>

                            </div>
							
        
                            <div class="form-group row">
       
								<div class="col-md-2">
									<label style="color:red">*</label>									
                                    <label for="NO_PO" class="form-label">PO#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_PO" id="NO_PO" name="NO_PO"
                                    placeholder="Masukkan PO#" value="{{$NO_PO}}" readonly>
                                </div>
       
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODES" class="form-label">Suplier</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES"
                                    placeholder="Masukkan Suplier" value="{{$KODES}}" readonly>
                                </div>
        
                                
                            </div>
							
                            <div class="form-group row">

        
                                <div class="col-md-2">
                                    <label for="NAMAS" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS"
                                    placeholder="-" value="{{$NAMAS}}" readonly>
                                </div>
                            </div>

							
                            <div class="form-group row">

        
                                <div class="col-md-2">
                                    <label for="TOTAL" class="form-label">TOTAL</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TOTAL" id="TOTAL" name="TOTAL"
                                    placeholder="-" value="{{ number_format( $TOTAL, 0, '.', ',') }}" style="text-align: right"  >
                                </div>
                            </div>


                            <div class="form-group row">

        
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES"
                                    placeholder="-" value="{{$NOTES}}" >
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


	<div class="modal fade" id="browsePoModal" tabindex="-1" role="dialog" aria-labelledby="browsePoModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePoModalLabel">Cari Po#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bpo">
				<thead>
					<tr>
						<th>Po#</th>
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
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		});
		
		hitung=function() {

			$('#TOTAL').val(numberWithCommas(TOTALX));	
		    $("#TOTAL").autoNumeric('update');	
				
		}		
		
		
		var dTableBPo;
		loadDataBPo = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('pon/browseuang')}}',

				success: function( response )
				{
					resp = response;
					if(dTableBPo){
						dTableBPo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBPo.row.add([
							'<a href="javascript:void(0);" onclick="choosePo(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODES+'\', \''+resp[i].NAMAS+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODES,
							resp[i].NAMAS
							
						]);
					}
					dTableBPo.draw();
				}
			});
		}
		
		dTableBPo = $("#table-bpo").DataTable({
			
		});
		
		browsePo = function(){
			 loadDataBPo();
			$("#browsePoModal").modal("show");
		}
		
		choosePo = function(NO_BUKTI,KODES,NAMAS){
			$("#NO_PO").val(NO_BUKTI);
			$("#KODES").val(KODES);
			$("#NAMAS").val(NAMAS);		
			$("#browsePoModal").modal("hide");
		}
		
		$("#NO_PO").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browsePo();
			}
		}); 
		
		
		
		
    });





 function simpan() {
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
			if ( $('#NO_PO').val()=='' ) 
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


