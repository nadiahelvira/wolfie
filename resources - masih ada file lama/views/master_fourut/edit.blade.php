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
               <h1 class="m-0">Edit Urutan Master Formula {{$header->NO_BUKTI}}</h1>	   
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/fourut')}}">Urutan Formula</a></li>
                <li class="breadcrumb-item active">Edit {{$header->NO_BUKTI}}</li>
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
                    <form action="{{url('/fourut/update/'.$header->NO_ID)}}" id="entri" method="POST">
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
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly >
                                </div>
							</div>
        
                             <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KD_BRG" class="form-label">Kode</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG"
                                    placeholder="Masukkan Kode" value="{{$header->KD_BRG}}" readonly >
                                </div>
								
								<div class="col-md-2">
                                    <label for="NA_BRG" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG"
                                    placeholder="Masukkan Nama" value="{{$header->NA_BRG}}" readonly >
                                </div>
							</div>
    
	
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}" readonly>
                                </div>
								
								<div class="col-md-6">
									<input type="checkbox" class="form-check-input" id="AKTIF" name="AKTIF" value="1" {{ ($header->AKTIF == 1) ? 'checked' : '' }} disabled>
									<label for="AKTIF">Aktif</label>
										
								</div> 
        
                            </div>
							
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
										<th style="text-align: center;" width="100px">No Proses</th>
										<th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_PRS" class="form-label">Kode Proses</label></th>
										<th style="text-align: center;">Nama Proses</th>
										<th></th>
                                    </tr>
									
                                </thead>
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $fod)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$fod->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
                                            <input name="NO_PRS[]" id="NO_PRS{{$no}}" type="text" value="{{$fod->NO_PRS}}" class="form-control NO_PRS" required>
                                        </td>
                                        <td>
                                            <input name="KD_PRS[]" data-rowid={{$no}} id="KD_PRS{{$no}}" type="text" value="{{$fod->KD_PRS}}" class="form-control KD_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_PRS[]" id="NA_PRS{{$no}}" type="text" value="{{$fod->NA_PRS}}" class="form-control NA_PRS" readonly required>
                                        </td>
										
										<td>
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </td>
										
                                    </tr>
								
								<?php $no++; ?>		
								@endforeach
                                </tbody>
                            </table>     
                            <div class="col-md-2 row">
                                <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
                            </div>							
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-success" onclick="simpan()"><i class="fa fa-save"></i> Save</button>										
                            <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
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
		idrow=<?php echo $no; ?>;
		baris=<?php echo $no; ?>;
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
//////////////////////////////////////////////////////////////////////
		var dTableBProses;
		var rowidProses;
		loadDataBProses = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('prs/browseall')}}",
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
	})
//////////////////////////////////////////////////////////////////


	function simpan() 
	{
        var check = '0';
		
		if ( check == '0' )
		{
			document.getElementById("entri").submit();  
		}
	}
		
		
	function tambah() 
	{
		var x = document.getElementById('datatable').insertRow(baris + 1);
		var td1 = x.insertCell(0);
		var td2 = x.insertCell(1);
		var td3 = x.insertCell(2);
		var td4 = x.insertCell(3);

		td1.innerHTML = "<input type='hidden' name='NO_ID[]' id='NO_ID" + idrow + "' value='new' class='form-control NO_ID' readonly> <input name='NO_PRS[]' id=NO_PRS" + idrow + " type='text' class='form-control NO_PRS' required>";
		td2.innerHTML = "<input name='KD_PRS[]' data-rowid="+ idrow +" id=KD_PRS" + idrow + " type='text' class='form-control  KD_PRS' required readonly>";
		td3.innerHTML = "<input name='NA_PRS[]' id=NA_PRS" + idrow + " type='text' class='form-control  NA_PRS' required readonly>";
		td4.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		
		$("#KD_PRS"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseProses(eval($(this).data("rowid")));
			}
		}); 
			
		idrow++;
		baris++;
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
	}
</script>


<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection