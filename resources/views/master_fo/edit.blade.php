@extends('layouts.main')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #b5e5f9 !important;
    }
</style>

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown with Select2</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{($tipx=='new')? url('/fo/store?flagz='.$flagz.'') : url('/fo/update/'.$header->NO_ID.'&flagz='.$flagz.'' ) }}" method="POST" name ="entri" id="entri" >
  
                        @csrf
                        <div class="tab-content mt-3">
                            <div class="form-group row">
                                <div class="col-md-1" align="right">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								

                                   <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden>
									<input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden>

								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly>
                                </div>
								
								
                            </div>

							<div class="form-group row" >
                                <div class="col-md-1" align="right">
                                    <label for="KD_BRG" class="form-label">Kode</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" onblur="browseBarang()" name="KD_BRG"
                                    placeholder="Masukkan Kode" value="{{$header->KD_BRG}}" >
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
                                <div class="col-md-1" align="right">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}">
                                </div>
								
								<div class="col-md-6">
									<input type="checkbox" class="form-check-input" id="AKTIF" name="AKTIF" value="1" {{ ($header->AKTIF == 1) ? 'checked' : '' }}>
									<label for="AKTIF">Aktif</label>
								</div> 
                            </div>
							
							<!--------------------------------------------------------------->

							<ul class="nav nav-tabs">
								<li class="nav-item active">
									<a class="nav-link active" href="#fod2Info" data-toggle="tab" >Tahapan</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#fodInfo" data-toggle="tab">Formula</a>
								</li>
							</ul>

							<!--------------------------------------------------------------->

                        <div class="tab-content mt-3">
							<div id="fodInfo" class="tab-pane ">
							
                            <table id="datatable1" class="table table-striped table-border">
                                <thead>
                                    <tr>
										<th style="text-align: center;">No.</th>
										<th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_PRS" class="form-label">Proses#</label></th>
										<th style="text-align: center;">Nama Proses</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BHN" class="form-label">Bahan#</label></th>
                                        <th style="text-align: center;">Nama Bahan</th>
										<th style="text-align: center;">Satuan</th>
										<th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
                                        <th></th>
                                       						
                                    </tr>
                                </thead>
        
								<tbody>
								<?php $no1=0 ?>
								@foreach ($detail as $fod)		
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]{{$no1}}" id="NO_ID" type="text" value="{{$fod->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no1}}" type="text" value="{{$fod->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly style="text-align:center">
                                        </td>

										<td>
                                            <input name="KD_PRS[]" data-rowid={{$no1}} onblur="browseProses({{$no1}})" id="KD_PRS{{$no1}}" type="text" value="{{$fod->KD_PRS}}" class="form-control KD_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_PRS[]" id="NA_PRS{{$no1}}" type="text" value="{{$fod->NA_PRS}}" class="form-control NA_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" data-rowid={{$no1}} onblur="browseBahan({{$no1}})" id="KD_BHN{{$no1}}" type="text" value="{{$fod->KD_BHN}}" class="form-control KD_BHN">
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN{{$no1}}" type="text" value="{{$fod->NA_BHN}}" class="form-control NA_BHN" readonly required>
                                        </td>
										 <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no1}}" type="text" value="{{$fod->SATUAN}}" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="{{$fod->QTY}}" id="QTY{{$no1}}" type="text" style="text-align: right"  class="form-control QTY text-primary"></td>
                                        
										<td>
                                            <input name="KET[]" id="KET{{$no1}}" type="text" class="form-control KET" value="{{$fod->KET}}" required>
                                        </td> 
										
										<td>
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete del1" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
								
								<?php $no1++; ?>
								@endforeach
                                </tbody>

								<tfoot>
								<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
									<td></td> 									
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>
							
                            <div class="col-md-2 row">
                               <a type="button" id='PLUSX1' onclick="tambah1()" class="fas fa-plus fa-sm md-3" ></a>					
							</div>		
							
						</div>

						<!----------------------------------------------------------------------------------------------->

						<div id="fod2Info" class="tab-pane active">

							<table id="datatable2" class="table table-striped table-border">
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
								<?php $no2=0 ?>
								@foreach ($detail as $fod2)		
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]{{$no2}}" id="NO_ID" type="text" value="{{$fod2->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no2}}" type="text" value="{{$fod2->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly style="text-align:center">
                                        </td>

										<td>
                                            <input name="KD_PRS[]" data-rowid={{$no2}} onblur="browseProses({{$no2}})" id="KD_PRS{{$no2}}" type="text" value="{{$fod2->KD_PRS}}" class="form-control KD_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_PRS[]" id="NA_PRS{{$no2}}" type="text" value="{{$fod2->NA_PRS}}" class="form-control NA_PRS" readonly required>
                                        </td>
										
										<td>
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete del2" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </td> 

                                    </tr>
								
								<?php $no2++; ?>
								@endforeach
                                </tbody>

								<tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
									<td></td>									
                                    <!-- <td><input class="form-control TTOTAL_QTY  text-primary" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
									<td><input class="form-control TTOTAL  text-primary" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="{{$header->TOTAL}}" readonly></td>
                                    <td></td> -->
                                </tfoot>
                            </table>
							
                            <div class="col-md-2 row">
                               <a type="button" id='PLUSX2' onclick="tambah2()" class="fas fa-plus fa-sm md-3" ></a>					
							</div>	

						</div>


					</div>
                        </div> 

                        <hr style="margin-top: 30px; margin-buttom: 30px">
						<!-- dari sini shelvi-->
						
						<!-- sampai sini shelvi-->
						   
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/fo/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/fo/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/fo/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/fo/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/fo/edit/?idx=0&tipx=new&flagz='.$flagz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/fo/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/fo?flagz='.$flagz.'' )}}'" class="btn btn-outline-secondary">Close</button>
							</div>
						</div>
						
						
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


	<div class="modal fade" id="browseBarangModal" tabindex="-1" role="dialog" aria-labelledby="browseBarangModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBarangModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bbarang">
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

	<div class="modal fade" id="browseProses2Modal" tabindex="-1" role="dialog" aria-labelledby="browseProses2ModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseProses2ModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bproses2">
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


	<div class="modal fade" id="browseBahanModal" tabindex="-1" role="dialog" aria-labelledby="browseBahanModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBahanModalLabel">Cari Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bbahan">
				<thead>
					<tr>
						<th>Item#</th>
						<th>Nama</th>
						<th>Satuan</th>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->

<script>
	var idrow1 = 1;
	var baris1 = 1;
	
	var idrow2 = 1;
	var baris2 = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
    idrow1=<?=$no1?>;
    baris1=<?=$no1?>;

	no12=<?=$no2?>;
    baris2=<?=$no2?>;

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
		$searchx = $('#CARI').val();
		
		
        if ( $tipx == 'new' )
		{
			 baru();
             tambah1();				 
             tambah2();				 
		}

        if ( $tipx != 'new' )
		{
			 ganti();			
		}    
		
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			
			// $("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			// $("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}	


		
		// $('#supxz').select2({
        //     minimumInputLength:2,
        //     placeholder:'Select Suplier',
        //     ajax:{
        //         url:route('sup/browsesupz'),
        //         dataType:'json',
        //         processResults:data=>{
                    
        //             return {
        //                 results:data.map(res=>{
        //                     return {text:res.NAMAS,id:res.KODES}
        //                 })
        //             }
        //         }
        //     }
        // })
		
		
				
		
        $('body').on('click', '.del1', function() {
			var val = $(this).parents("tr").remove();
			baris1--;
			no2mor();
			
		});

		$('body').on('click', '.del2', function() {
			var val = $(this).parents("tr").remove();
			baris2--;
			no2mor();
			
		});

		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
		});
		
		
 	
		
//		CHOOSE Supplier
 		var dTableBSuplier;
		loadDataBSuplier = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('sup/browse')}}',
				// data: {
				// 	'GOL': 'Y',
				// },
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



		//////////////////////////////////////////////////////

		var dTableBBarang;
		var rowidBarang;
		loadDataBBarang = function(){
		
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('brg/browse')}}",
				async : false,
				data: {
						'KD_BRG': $("#KD_BRG").val(),
					
				},
				success: function( response )

				{
					resp = response;
					
					
					if ( resp.length > 1 )
					{	
							if(dTableBBarang){
								dTableBBarang.clear();
							}
							for(i=0; i<resp.length; i++){
								
								dTableBBarang.row.add([
									'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\', \''+resp[i].NA_BRG+'\' )">'+resp[i].KD_BRG+'</a>',
									resp[i].NA_BRG,
								]);
							}
							dTableBBarang.draw();
					
					}
					else
					{
						$("#KD_BRG").val(resp[0].KD_BRG);
						$("#NA_BRG").val(resp[0].NA_BRG);
					}
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});

		browseBarang = function(){
			$("#NA_BRG").val("");			
			loadDataBBarang();
	
			
			if ( $("#NA_BRG").val() == '' ) {				
					$("#browseBarangModal").modal("show");
			}	
		}
		
		chooseBarang = function(KD_BRG,NA_BRG){
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);
			$("#browseBarangModal").modal("hide");
		}


	////////////////////////////////////////////////////

		var dTableBProses;
		var rowidProses;
		loadDataBProses = function(){
		
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('prs/browseall')}}",
				async : false,
				data: {
						'KD_PRS': $("#KD_PRS"+rowidProses).val(),
					
				},
				success: function( response )

				{
					resp = response;
					
					
					if ( resp.length > 1 )
					{	
							if(dTableBProses){
								dTableBProses.clear();
							}
							for(i=0; i<resp.length; i++){
								
								dTableBProses.row.add([
									'<a href="javascript:void(0);" onclick="chooseProses(\''+resp[i].KD_PRS+'\', \''+resp[i].NA_PRS+'\' )">'+resp[i].KD_PRS+'</a>',
									resp[i].NA_PRS,
								]);
							}
							dTableBProses.draw();
					
					}
					else
					{
						$("#KD_PRS"+rowidProses).val(resp[0].KD_PRS);
						$("#NA_PRS"+rowidProses).val(resp[0].NA_PRS);
					}
				}
			});
		}
		
		dTableBProses = $("#table-bproses").DataTable({
			
		});

		browseProses = function(rid){
		rowidProses = rid;
			$("#NA_PRS"+rowidProses).val("");			
			loadDataBProses();
	
			
			if ( $("#NA_PRS"+rowidProses).val() == '' ) {				
					$("#browseProsesModal").modal("show");
			}	
		}
		
		chooseProses = function(KD_PRS,NA_PRS){
			$("#KD_PRS"+rowidProses).val(KD_PRS);
			$("#NA_PRS"+rowidProses).val(NA_PRS);
			$("#browseProsesModal").modal("hide");
		}



	////////////////////////////////////////////////////

		var dTableBProses2;
		var rowidProses2;
		loadDataBProses2 = function(){
		
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('prs/browseall')}}",
				async : false,
				data: {
						'KD_PRS	': $("#KD_PRS2"+rowidProses2).val(),
					
				},
				success: function( response )

				{
					resp = response;
					
					
					if ( resp.length > 1 )
					{	
							if(dTableBProses2){
								dTableBProses2.clear();
							}
							for(i=0; i<resp.length; i++){
								
								dTableBProses2.row.add([
									'<a href="javascript:void(0);" onclick="chooseProses2(\''+resp[i].KD_PRS+'\', \''+resp[i].NA_PRS+'\' )">'+resp[i].KD_PRS+'</a>',
									resp[i].NA_PRS,
								]);
							}
							dTableBProses2.draw();
					
					}
					else
					{
						$("#KD_PRS2"+rowidProses2).val(resp[0].KD_PRS);
						$("#NA_PRS2"+rowidProses2).val(resp[0].NA_PRS);
					}
				}
			});
		}
		
		dTableBProses2 = $("#table-bproses2").DataTable({
			
		});

		browseProses2 = function(rid){
		rowidProses2 = rid;
			$("#NA_PRS2"+rowidProses2).val("");			
			loadDataBProses2();
	
			
			if ( $("#NA_PRS2"+rowidProses2).val() == '' ) {				
					$("#browseProses2Modal").modal("show");
			}	
		}
		
		chooseProses2 = function(KD_PRS,NA_PRS){
			$("#KD_PRS2"+rowidProses2).val(KD_PRS);
			$("#NA_PRS2"+rowidProses2).val(NA_PRS);
			$("#browseProses2Modal").modal("hide");
		}



	////////////////////////////////////////////////////

		var dTableBBahan;
		var rowidBahan;
		loadDataBBahan = function(){
		
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('bhn/browseall')}}",
				async : false,
				data: {
						'KD_BHN': $("#KD_BHN"+rowidBahan).val(),
					
				},
				success: function( response )

				{
					resp = response;
					
					
					if ( resp.length > 1 )
					{	
							if(dTableBBahan){
								dTableBBahan.clear();
							}
							for(i=0; i<resp.length; i++){
								
								dTableBBahan.row.add([
									'<a href="javascript:void(0);" onclick="chooseBahan(\''+resp[i].KD_BHN+'\', \''+resp[i].NA_BHN+'\', \''+resp[i].SATUAN+'\' )">'+resp[i].KD_BHN+'</a>',
									resp[i].NA_BHN,
									resp[i].SATUAN,
								]);
							}
							dTableBBahan.draw();
					
					}
					else
					{
						$("#KD_BHN"+rowidBahan).val(resp[0].KD_BHN);
						$("#NA_BHN"+rowidBahan).val(resp[0].NA_BHN);
						$("#SATUAN"+rowidBahan).val(resp[0].SATUAN);
					}
				}
			});
		}
		
		dTableBBahan = $("#table-bbahan").DataTable({
			
		});

		browseBahan = function(rid){
		rowidBahan = rid;
			$("#NA_BHN"+rowidBahan).val("");			
			loadDataBBahan();
	
			
			if ( $("#NA_BHN"+rowidBahan).val() == '' ) {				
					$("#browseBahanModal").modal("show");
			}	
		}
		
		chooseBahan = function(KD_BHN,NA_BHN, SATUAN){
			$("#KD_BHN"+rowidBahan).val(KD_BHN);
			$("#NA_BHN"+rowidBahan).val(NA_BHN);
			$("#SATUAN"+rowidBahan).val(SATUAN);
			$("#browseBahanModal").modal("hide");
		}



	////////////////////////////////////////////////////

	});



///////////////////////////////////////		
    



	function cekDetail(){
		var cekBarang = '';
		$(".KD_BRG").each(function() {
			
			let z = $(this).closest('tr');
			var KD_BRGX = z.find('.KD_BRG').val();
			
			if( KD_BRGX =="" )
			{
					cekBarang = '1';
					
			}	
		});
		
		return cekBarang;
	}


 	function simpan() {
		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
		
			if (cekDetail())
			{	
			    check = '1';
				alert("#Barang ada yang kosong. ")
			}
			
			
			// if ( $('#KODES').val()=='' ) 
            // {				
			//     check = '1';
			// 	alert("Suplier# Harus Diisi.");
			// }
			
			// if ( tgl.substring(3,5) != bulanPer ) 
			// {
			// 	check = '1';
			// 	alert("Bulan tidak sama dengan Periode");
			// }	
			

			// if ( tgl.substring(tgl.length-4) != tahunPer )
			// {
			// 	check = '1';
			// 	alert("Tahun tidak sama dengan Periode");
		    // }	 
			
			if (baris1==0)
			{
				check = '1';
				alert("Data detail kosong (Tambahkan 1 baris kosong jika ingin mengosongi detail)");
			}

			if (baris2==0)
			{
				check = '1';
				alert("Data detail kosong (Tambahkan 1 baris kosong jika ingin mengosongi detail)");
			}

			if ( check == '0' )
			{
				hitung();	
		      	document.getElementById("entri").submit();  
			}
			
	}
		
    function no2mor() {
		var i = 1;
		$(".RECX").each(function() {
			$(this).val(i++);
		});

		i = 1;
		$(".RECY").each(function() {
			$(this).val(i++);
		});
		
	//	hitung();
	
	}

   function hitung() {
		var TTOTAL_QTY = 0;
		// var TTOTAL = 0;


		
		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat(z.find('.QTY').val().replace(/,/g, ''));
			// var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
	
	
            // var TOTALX  =  ( QTYX * HARGAX );
			// z.find('.TOTAL').val(TOTALX);

		    // z.find('.HARGA').autoNumeric('update');			
		    // z.find('.QTY').autoNumeric('update');	
		    // z.find('.TOTAL').autoNumeric('update');			

            TTOTAL_QTY +=QTYX;		
            // TTOTAL +=TOTALX;				
		
		});
		

		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		$("#TTOTAL_QTY").autoNumeric('update');
		
		// if(isNaN(TTOTAL)) TTOTAL = 0;

		// $('#TTOTAL').val(numberWithCommas(TTOTAL));		
		// $("#TTOTAL").autoNumeric('update');



		
	}
	

	
  
	function baru() {
		
		 kosong();
		 hidup();
	
	}
	
	function ganti() {
		
		 mati();
	
	}
	
	function batal() {
		
		// alert($header[0]->NO_BUKTI);
		
		 //$('#NO_BUKTI').val($header[0]->NO_BUKTI);	
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
//	    $("#CLOSEX").attr("disabled", true);

		$("#CARI").attr("readonly", true);	
	    $("#SEARCHX").attr("disabled", true);
		
	    $("#PLUSX1").attr("hidden", false);
	    $("#PLUSX2").attr("hidden", false);
		   
			$("#NO_BUKTI").attr("readonly", true);		   
			$("#TGL").attr("readonly", false);
			$("#KODES").attr("readonly", true);
			$("#NAMAS").attr("readonly", true);			
			$("#ALAMAT").attr("readonly", true);
			$("#KOTA").attr("readonly", true);

			
			$("#NOTES").attr("readonly", false);
				

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#RECX" + i.toString()).attr("readonly", true);
			$("#RECY" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", false);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", false);
			$("#HARGA" + i.toString()).attr("readonly", false);
			$("#TOTAL" + i.toString()).attr("readonly", true);
			$("#KET" + i.toString()).attr("readonly", false);
			$("#DELETEX" + i.toString()).attr("hidden", false);

			$tipx = $('#tipx').val();
		
			
			if ( $tipx != 'new' )
			{
				$("#KD_BRG" + i.toString()).attr("readonly", true);	
				$("#KD_BRG" + i.toString()).removeAttr('onblur');	
			} 
		}

		
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

		$("#CARI").attr("readonly", false);	
	    $("#SEARCHX").attr("disabled", false);
		
		
	    $("#PLUSX1").attr("hidden", true);
	    $("#PLUSX2").attr("hidden", true);
		
	    $(".NO_BUKTI").attr("readonly", true);	
		
		$("#TGL").attr("readonly", true);
		$("#KODES").attr("readonly", true);
		$("#NAMAS").attr("readonly", true);
		$("#ALAMAT").attr("readonly", true);
		$("#KOTA").attr("readonly", true);
	
		
		$("#NOTES").attr("readonly", true);

		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#RECX" + i.toString()).attr("readonly", true);
			$("#RECY" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", true);
			$("#TOTAL" + i.toString()).attr("readonly", true);
			$("#KET" + i.toString()).attr("readonly", true);
			
			$("#DELETEX" + i.toString()).attr("hidden", true);
		}


		
	}


	function kosong() {
				
		 $('#NO_BUKTI').val("+");		
		 $('#KODES').val("");	
		 $('#NAMAS').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");	
		 $('#NOTES').val("");	
		 $('#TTOTAL_QTY').val("0.00");	
		 $('#TTOTAL').val("0.00");
		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/fo/delete/'.$header->NO_ID .'/?flagz='.$flagz.'' )}}";
			//return true;
		} 
		return false;
	}
	

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/fo/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&buktix=' +encodeURIComponent(cari);
		window.location = loc;
		
	}


    function tambah1() {

        var x = document.getElementById('datatable1').insertRow(baris1 + 1);
 
		html=`<tr>

                <td>
 					<input name='NO_ID[]' id='NO_ID${idrow1}' type='hidden' class='form-control NO_ID' value='new' readonly> 
					<input name='RECX[]' id='RECX${idrow1}' type='text' class='RECX form-control' onkeypress='return tabE(this,event)' readonly>
	            </td>


				
                <td>
				    <input name='KD_PRS[]' data-rowid=${idrow1} onblur='browseProses(${idrow1})' id='KD_PRS${idrow1}' type='text' class='form-control  KD_PRS' >
                </td>
                <td>
				    <input name='NA_PRS[]'   id='NA_PRS${idrow1}' type='text' class='form-control  NA_PRS' required readonly>
                </td>
                <td>
				    <input name='KD_BHN[]' onblur='browseBahan(${idrow1})'  id='KD_BHN${idrow1}' type='text' class='form-control  KD_BHN' >
                </td>
                <td>
				    <input name='NA_BHN[]'   id='NA_BHN${idrow1}' type='text' class='form-control  NA_BHN' readonly required>
                </td>
                <td>
				    <input name='SATUAN[]'   id='SATUAN${idrow1}' type='text' class='form-control  SATUAN' readonly required>
                </td>

				<td>
		            <input name='QTY[]' onclick='select()' onblur='hitung()' value='0' id='QTY${idrow1}' type='text' style='text-align: right' class='form-control QTY text-primary' required >
                </td>			
					
                <td>
				    <input name='KET[]'   id='KET${idrow1}' type='text' class='form-control  KET' required>
                </td>
				
                <td>
					<button type='button' id='DELETEX${idrow1}'  class='btn btn-sm btn-circle btn-outline-danger btn-delete del1' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>
                </td>				
         </tr>`;
				
        x.innerHTML = html;
        var html='';
		
		
		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					
		}

		// $("#KD_BRG"+idrow1).keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browseBarang(eval($(this).data("rowid")));
		// 	}
		// }); 


        idrow1++;
        baris1++;
        no2mor();
		
		$(".ronly").on('keydown paste', function(e) {
             e.preventDefault();
             e.currentTarget.blur();
         });
     }


	 function tambah2() {

		var x = document.getElementById('datatable2').insertRow(baris2 + 1);

		html=`<tr>

				<td>
					<input name='NO_ID[]' id='NO_ID${idrow2}' type='hidden' class='form-control NO_ID' value='new' readonly> 
					<input name='RECY[]' id='RECY${idrow2}' type='text' class='RECY form-control' onkeypress='return tabE(this,event)' readonly>
				</td>

				<td>
				    <input name='KD_PRS2[]' data-rowid=${idrow2} onblur='browseProses2(${idrow2})' id='KD_PRS2${idrow2}' type='text' class='form-control  KD_PRS2' >
                </td>
                <td>
				    <input name='NA_PRS2[]' id='NA_PRS2${idrow2}' type='text' class='form-control NA_PRS2' required readonly>
                </td>
				
				<td>
					<button type='button' id='DELETEX${idrow2}'  class='btn btn-sm btn-circle btn-outline-danger btn-delete del2' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>
				</td>				
		</tr>`;
				
		x.innerHTML = html;
		var html='';



		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			// $("#QTY" + i.toString()).autoNumeric('init', {
			// 	aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});


			// $("#HARGA" + i.toString()).autoNumeric('init', {
			// 	aSign: '<?php echo ''; ?>',
			// 	vMin: '-999999999.99'
			// });

			// $("#TOTAL" + i.toString()).autoNumeric('init', {
			// 	aSign: '<?php echo ''; ?>',
			// 	vMin: '-999999999.99'
			// });			 

					
		}

		// $("#KD_BRG"+idrow2).keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browseBarang(eval($(this).data("rowid")));
		// 	}
		// }); 


		idrow2++;
		baris2++;
		no2mor();

		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		}
</script>
<!-- 
<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script> -->
@endsection