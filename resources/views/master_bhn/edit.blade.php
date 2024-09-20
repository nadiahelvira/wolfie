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
            <h1 class="m-0">Data Bahan</h1>
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

                    <form action="{{($tipx=='new')? url('/bhn/store/') : url('/bhn/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
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
                                    <label for="KD_BHN" class="form-label">Kode</label>
                                </div>
								
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
		 								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BHN" id="KD_BHN" name="KD_BHN"
                                    placeholder="Masukkan Bahan" value="{{$header->KD_BHN}}" readonly>
                                </div>

								<div class="col-md-1" align="center">
									<label for="PN" class="form-label">PPN</label>
								</div>
								<div class="col-md-1">
									<select id="PN" class="form-control"  name="PN">
										<option value="0" {{ ($header->PN == '0') ? 'selected' : '' }}>0</option>
										<option value="11" {{ ($header->PN == '11') ? 'selected' : '' }}>11</option>
										<option value="12" {{ ($header->PN == '12') ? 'selected' : '' }}>12</option>
									</select>
								</div>
							
								<div class="col-md-1">
                                    <input type="checkbox" class="form-check-input" id="AKTIF"name="AKTIF"
                                    placeholder="Masukkan Aktif/Tidak" value="1" {{ ($header->AKTIF == 1) ? 'checked' : '' }}>
									<label for="AKTIF">Aktif</label>
                                </div>

                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="NA_BHN" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_BHN" id="NA_BHN" name="NA_BHN"
                                    placeholder="Masukkan Nama Bahan" value="{{$header->NA_BHN}}" >
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-1">
                                    <label for="SATUAN_BELI" class="form-label">Satuan Beli</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN_BELI" id="SATUAN_BELI" name="SATUAN_BELI"
                                    placeholder="Masukkan Satuan Beli" value="{{$header->SATUAN_BELI}}">
                                </div>

								<div class="col-md-1">
                                    <label for="KALI" class="form-label" style="text-align: center; width:140px">Konversi</label>
                                </div>
                                <div class="col-md-2">
									<input type="text" class="form-control KALI" onclick="select()"  id="KALI" name="KALI" placeholder="KALI" 
									value="{{ number_format($header->KALI, 2, '.', ',') }}" style="text-align: right; width:140px">
                                </div>

                                <div class="col-md-1">
                                    <label for="SATUAN" class="form-label">Satuan Pakai</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN" id="SATUAN" name="SATUAN"
                                    placeholder="Masukkan Satuan Pakai" value="{{$header->SATUAN}}">
                                </div>

								
                            </div>
							
                            <div class="form-group row">
                                
                                <div class="col-md-1">
									<label for="GOL" class="form-label">Golongan</label>
								</div>
								<div class="col-md-2">
									<select id="GOL" class="form-control"  name="GOL">
										<option value="B" {{ ($header->GOL == 'B') ? 'selected' : '' }}>B</option>
										<option value="W" {{ ($header->GOL == 'W') ? 'selected' : '' }}>W</option>
									</select>
								</div>
								
                            </div>

							<div class="form-group row">
								<div class="col-md-1">
									<label for="ROP" class="form-label">ROP</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick= "select()" class="form-control ROP" id="ROP" name="ROP" placeholder="Masukkan ROP" 
									value="{{ number_format( $header->ROP, 0, '.', ',') }}" style="text-align: right" >
								</div>

								<div class="col-md-1">
									<label for="HJUAL" class="form-label">Harga Jual</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick="select()" class="form-control HJUAL" id="HJUAL" name="HJUAL" placeholder="Masukkan HJUAL" 
									value="{{ number_format( $header->HJUAL, 0, '.', ',') }}" style="text-align: right" >
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-1">
                                    <label for="SMIN" class="form-label">SMIN</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control SMIN" id="SMIN" name="SMIN" placeholder="Masukkan SMIN" 
									value="{{ number_format( $header->SMIN, 0, '.', ',') }}" style="text-align: right" >
                                </div>

								<div class="col-md-1">
									<label for="SMAX" class="form-label">SMAX</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick="select()" class="form-control SMAX" id="SMAX" name="SMAX" placeholder="Masukkan SMAX" 
									value="{{ number_format( $header->SMAX, 0, '.', ',') }}" style="text-align: right" >
								</div>
							</div>

							<!-- <div class="form-group row">
                                <div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="KODES" class="form-label">Vendor</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Pilih Suplier"value="{{$header->KODES}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseSuplier()"><i class="fa fa-search"></i></button>
                                </div>
        
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS" placeholder="" value="{{$header->NAMAS}}" readonly>
                                </div>
                            </div> -->

							<div class="form-group row">
                                <div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="ACNOA" class="form-label">Acno Debet</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control ACNOA" id="ACNOA" name="ACNOA" placeholder="Pilih Acno Debet"value="{{$header->ACNOA}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseAcno()"><i class="fa fa-search"></i></button>
                                </div>
        
                                <div class="col-md-4">
                                    <input type="text" class="form-control NACNOA" id="NACNOA" name="NACNOA" placeholder="" value="{{$header->NACNOA}}" readonly>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="ACNOB" class="form-label">Acno Kredit</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control ACNOB" id="ACNOB" name="ACNOB" placeholder="Pilih Acno Kredit"value="{{$header->ACNOB}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseAcnob()"><i class="fa fa-search"></i></button>
                                </div>
        
                                <div class="col-md-4">
                                    <input type="text" class="form-control NACNOB" id="NACNOB" name="NACNOB" placeholder="" value="{{$header->NACNOB}}" readonly>
                                </div>
                            </div>
                                
                        </div>

        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/bhn/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/bhn/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KD_BHN )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/bhn/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KD_BHN )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/bhn/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/bhn/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/bhn/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/bhn' )}}'" class="btn btn-outline-secondary">Close</button>


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

	<div class="modal fade" id="browseSuplierModal" tabindex="-1" role="dialog" aria-labelledby="browseSuplierModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
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

	<div class="modal fade" id="browseAcnoModal" tabindex="-1" role="dialog" aria-labelledby="browseAcnoModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAcnoModalLabel">Cari Acno</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bacno">
				<thead>
					<tr>
						<th>Acno</th>
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

	<div class="modal fade" id="browseAcnobModal" tabindex="-1" role="dialog" aria-labelledby="browseAcnobModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAcnobModalLabel">Cari Acnob</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bacnob">
				<thead>
					<tr>
						<th>Acno</th>
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

		
		$('body').on('keydown', 'input, select', function(e) {
			if (e.key === "Enter") {
				var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				focusable = form.find('input,select,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				console.log(next);
				if (next.length) {
					next.focus().select();
				} else {
					// tambah();
					// var nomer = idrow-1;
					// console.log("REC"+nomor);
					// document.getElementById("REC"+nomor).focus();
					// form.submit();
				}
				return false;
			}
		});

		
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


		$("#KALI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#ROP").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#HJUAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#SMIN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#SMAX").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
		
		
		//CHOOSE Supplier
		var dTableBSuplier;
		loadDataBSuplier = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('sup/browse')}}',

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
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////

		//CHOOSE Acno
		var dTableBAcno;
		loadDataBAcno = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBAcno){
						dTableBAcno.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAcno.row.add([
							'<a href="javascript:void(0);" onclick="chooseAcno(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAcno.draw();
				}
			});
		}
		
		dTableBAcno = $("#table-bacno").DataTable({
			
		});
		
		browseAcno = function(){
			loadDataBAcno();
			$("#browseAcnoModal").modal("show");
		}
		
		chooseAcno = function(ACNO,NAMA){
			$("#ACNOA").val(ACNO);
			$("#NACNOA").val(NAMA);
			$("#browseAcnoModal").modal("hide");
		}
		
		$("#ACNOA").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseAcno();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////

		//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Acno
		var dTableBAcnob;
		loadDataBAcnob = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBAcnob){
						dTableBAcnob.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAcnob.row.add([
							'<a href="javascript:void(0);" onclick="chooseAcnob(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAcnob.draw();
				}
			});
		}
		
		dTableBAcnob = $("#table-bacnob").DataTable({
			
		});
		
		browseAcnob = function(){
			loadDataBAcnob();
			$("#browseAcnobModal").modal("show");
		}
		
		chooseAcnob = function(ACNO,NAMA){
			$("#ACNOB").val(ACNO);
			$("#NACNOB").val(NAMA);
			$("#browseAcnobModal").modal("hide");
		}
		
		$("#ACNOB").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseAcnob();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		
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
		  	
			$("#KD_BHN").attr("readonly", false);	

		   }
		else
		{
	     	$("#KD_BHN").attr("readonly", true);	

		   }
		   
		
		$("#NA_BHN").attr("readonly", false);		
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
		
		$("#KD_BHN").attr("readonly", true);			
		$("#NA_BHN").attr("readonly", true);	
		$("#GRUP").attr("readonly", true);	
		$("#DR").attr("readonly", true);
		$("#SUB").attr("readonly", true);
		
	}


	function kosong() {
				
		 $('#KD_BHN').val("");	
		 $('#NA_BHN').val("");	
		 $('#GRUP').val("");	
		 $('#DR').val("");
		 $('#SUB').val("");		 
	}
	
	function hapusTrans() {
		let text = "Hapus Master "+$('#KD_BHN').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/bhn/delete/'.$header->NO_ID )}}'";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/bhn/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

    var hasilCek;
	function cekBahan(kdbhn) {
		$.ajax({
			type: "GET",
			url: "{{url('bhn/cekbahan')}}",
            async: false,
			data: ({ KD_BHN: kdbhn, }),
			success: function(data) {
                // hasilCek=data;
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekBahan occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        //cekBahan($('#KD_BHN').val());
        //(hasilCek==0) ? document.getElementById("entri").submit() : alert('Kode Bahan '+$('#KD_BHN').val()+' sudah ada!');
        
        document.getElementById("entri").submit()
	}
</script>
@endsection