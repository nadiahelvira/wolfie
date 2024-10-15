@extends('layouts.main')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
		<div class="col-sm-6">
			<h1 class="m-0">Utilty Ambil Data </h1>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item active">Utility Ambil Data </li>
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
				
					<form method="POST" action="{{url('jasper-stocka-report')}}">
					@csrf
					<div class="form-group row">

						
						<div class="col-md-2">						
							<label class="form-label">Bukti#</label>
							<input type="text" class="form-control NO_BUKTI1" id="NO_BUKTI1" name="NO_BUKTI" value="{{ session()->get('filter_no_bukti1') }}" >
						</div>  
						<div class="col-md-3">
							<label class="form-label"></label>
							<input type="text" class="form-control NO_BUKTI2" id="NO_BUKTI2" name="NO_BUKTI2" value="{{ session()->get('filter_no_bukti2') }}" >
						</div>
		
						
					</div>
					
					
					<!-- Filter Tanggal -->
					<div class="form-group row">
						<div class="col-md-3">
							<input class="form-control date tglDr" id="tglDr" name="tglDr"
							type="text" autocomplete="off" value="{{ session()->get('filter_tglDari') }}"> 
						</div>
						<div>s.d.</div> 
						<div class="col-md-3">
							<input class="form-control date tglSmp" id="tglSmp" name="tglSmp"
							type="text" autocomplete="off" value="{{ session()->get('filter_tglSampai') }}">
						</div>
					</div>
					
                   	<button class="btn btn-primary" type="submit" id="ambil_stock" class="ambil_stock" name="ambil_stock">Stock</button>
                   	<button class="btn btn-primary" type="submit" id="ambil_pakai" class="ambil_pakai" name="ambil_pakai">Pakai</button>
                   	<button class="btn btn-primary" type="submit" id="ambil_beli" class="ambil_beli" name="ambil_beli">Beli</button>
                   	<button class="btn btn-primary" type="submit" id="ambil_setor" class="ambil_setor" name="ambil_setor">Setoran</button>
					
					</form>
					<div style="margin-bottom: 15px;"></div>
		
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>


@endsection

@section('javascripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
	$(document).ready(function() {
		
		$('.date').datepicker({  
			dateFormat: 'dd-mm-yy'
		}); 
		
		
	});
	

	////////////////////////////////
	
 		var dTableBBarang;
		
		loadDataBBarang = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('brg_st/browse')}}",
				data: 
				{
					 KD_BRG : $('#KD_BRG').val(),	   
				},				
				success: function( response )
				{
					resp = response;
					if(dTableBBarang){
						dTableBBarang.clear();
					}
					for(i=0; i<resp.length; i++){
					
						    dTableBBarang.row.add([
							   '<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',   \''+resp[i].SATUAN+'\')">'+resp[i].KD_BRG+'</a>',
							   resp[i].NA_BRG,
							   resp[i].SATUAN,
						    ]);
						
					}
					dTableBBarang.draw();
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});
		

		
		       browseBarang = function() {
                    loadDataBBarang();
                    $("#browseBarangModal").modal("show");
                }

                chooseBarang = function(KD_BRG, NA_BRG, SATUAN) {
                    $("#KD_BRG").val(KD_BRG);
                    $("#NA_BRG").val(NA_BRG);
                    $("#browseBarangModal").modal("hide");
                }


                $("#KD_BRG").keypress(function(e) {
                    if (e.keyCode == 46) {
                        e.preventDefault();
                        browseBarang(0);
                    }
                });
		
	
	/////////
	
</script>
@endsection