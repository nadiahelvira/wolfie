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
            <h1 class="m-0">Data Mesin</h1>
            </div>
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

                    <form action="{{($tipx=='new')? url('/mesin/store/') : url('/mesin/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
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
                                <div class="col-md-1">
                                    <label for="KD_GOL" class="form-label">Kode</label>
                                </div>
								
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
		 								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_GOL" id="KD_GOL" name="KD_GOL"
                                    placeholder="Masukkan Barang" value="{{$header->KD_GOL}}" readonly>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="NA_GOL" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_GOL" id="NA_GOL" name="NA_GOL"
                                    placeholder="Masukkan Nama Barang" value="{{$header->NA_GOL}}" >
                                </div>
                            </div>
							
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="SATUAN" class="form-label">Satuan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN" id="SATUAN" name="SATUAN"
                                    placeholder="Masukkan Satuan" value="{{$header->SATUAN}}">
                                </div>

                                <div class="col-md-1">
                                    <label for="GOL" class="form-label">Gol</label>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control GOL" id="GOL" name="GOL"
                                    placeholder="Gol" value="{{$header->GOL}}">
                                </div>

								
                            </div>
                                
                        </div>

        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" hidden id='TOPX'  onclick="location.href='{{url('/mesin/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" hidden id='PREVX' onclick="location.href='{{url('/mesin/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->ACNO )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" hidden id='NEXTX' onclick="location.href='{{url('/mesin/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->ACNO )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" hidden id='BOTTOMX' onclick="location.href='{{url('/mesin/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" hidden id='NEWX' onclick="location.href='{{url('/mesin/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" hidden id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" hidden id='UNDOX' onclick="location.href='{{url('/mesin/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success"<i class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" hidden id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/mesin' )}}'" class="btn btn-outline-secondary">Close</button>


							</div>
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
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>


<script>
    var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}


    $(document).ready(function () {
		
 		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			 baru();			
		}

        if ( $tipx != 'new' )
		{
			 //mati();	
    		 ganti();
		} 
		
    });

	function baru() {
		
		 kosong();
		 hidup();
		 
	}
	
	function ganti() {
		
		// mati();
		hidup();
	
	}
	
	function batal() {
			
		 mati();
	
	}
	

	function hidup() {

	    $("#TOPX").attr("disabled", true);
	    $("#PREVX").attr("disabled", true);
	    $("#NEXTX").attr("disabled", true);
	    $("#BOTTOMX").attr("disabled", true);

	    $("#NEWX").attr("disabled", true);
	    $("#EDITX").attr("disabled", true);
	    $("#UNDOX").attr("disabled", false);
	    $("#SAVEX").attr("disabled", false);
		
	    $("#HAPUSX").attr("disabled", true);
	    //$("#CLOSEX").attr("disabled", true);
		
		
 		$tipx = $('#tipx').val();
		
        if ( $tipx == 'new' )		
		{	
		  	
			$("#KD_GOL").attr("readonly", false);	

		   }
		else
		{
	     	$("#KD_GOL").attr("readonly", true);	

		   }
		   
		
		$("#NA_GOL").attr("readonly", false);		
		$("#GRUP").attr("readonly", false);		
		$("#DR").attr("readonly", false);	
		$("#SUB").attr("readonly", false);			
	
	}


	function mati() {

	    $("#TOPX").attr("disabled", false);
	    $("#PREVX").attr("disabled", false);
	    $("#NEXTX").attr("disabled", false);
	    $("#BOTTOMX").attr("disabled", false);

	    $("#NEWX").attr("disabled", false);
	    $("#EDITX").attr("disabled", false);
	    $("#UNDOX").attr("disabled", true);
	    $("#SAVEX").attr("disabled", true);
	    $("#HAPUSX").attr("disabled", false);
	    $("#CLOSEX").attr("disabled", false);
		
		$("#KD_GOL").attr("readonly", true);			
		$("#NA_GOL").attr("readonly", true);	
		$("#GRUP").attr("readonly", true);	
		$("#DR").attr("readonly", true);
		$("#SUB").attr("readonly", true);
		
	}


	function kosong() {
				
		 $('#KD_GOL').val("");	
		 $('#NA_GOL').val("");	
		 $('#GRUP').val("");	
		 $('#DR').val("");
		 $('#SUB').val("");		 
	}
	
	function hapusTrans() {
		let text = "Hapus Master "+$('#KD_GOL').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/mesin/delete/'.$header->NO_ID )}}'";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/mesin/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

    var hasilCek;
	function cekBarang(kdmesin) {
		$.ajax({
			type: "GET",
			url: "{{url('mesin/cekbarang')}}",
            async: false,
			data: ({ KDBRG: kdmesin, }),
			success: function(data) {
                // hasilCek=data;
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekBarang occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        //cekBarang($('#KD_GOL').val());
        //(hasilCek==0) ? document.getElementById("entri").submit() : alert('Kode Barang '+$('#KD_GOL').val()+' sudah ada!');
        
        document.getElementById("entri").submit()
	}
</script>
@endsection