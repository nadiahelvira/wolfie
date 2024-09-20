@extends('layouts.main')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #b5e5f9 !important;
    }

	.table-scrollable {
		margin: 0;
		padding: 0;
	}

	table {
		table-layout: fixed !important;
	}

	.uppercase {
		text-transform: uppercase;
	}

</style>

@section('content')

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

                    <form action="{{($tipx=='new')? url('/beli/store?flagz='.$flagz.'&golz='.$golz.'') : url('/beli/update/'.$header->NO_ID.'&flagz='.$flagz.'&golz='.$golz.'' ) }}" method="POST" name ="entri" id="entri" >
  
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
									<input name="golz" class="form-control golz" id="golz" value="{{$golz}}" hidden>

								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly>
                                </div>

                                <div class="col-md-1" align="right">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}">
                                </div>
								
                            </div>

                            <div class="form-group row">

								<div class="col-md-1" align="right">
									<label style="color:red">*</label>									
                                    <label for="NO_PO" class="form-label">PO#</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control NO_PO" id="NO_PO" name="NO_PO" placeholder="Pilih PO"value="{{$header->NO_PO}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseSuplier()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
							
                            <div class="form-group row">
								<div class="col-md-1" align="right">
                                    <label for="KODES" class="form-label">Suplier#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Masukkan Suplier#" value="{{$header->KODES}}"readonly>
                                </div>
                            </div>
							

							<div class="form-group row">

								<div class="col-md-1" align="left">
                                    <label for="NAMAS" class="form-label"></label>
                                </div>
								<div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS" placeholder="-" value="{{$header->NAMAS}}" readonly>
                                </div>
                            </div>

							
                            <div class="form-group row">

								<div class="col-md-1" align="right">
                                    <label for="ALAMAT" class="form-label"></label>
                                </div>
								<div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" value="{{$header->ALAMAT}}"placeholder="Alamat" readonly >
                                </div>
                            </div>
   
							<div class="form-group row">

								<div class="col-md-1" align="right">
                                    <label for="KOTA" class="form-label"></label>
                                </div>
								<div class="col-md-2">
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" value="{{$header->KOTA}}"placeholder="Kota" readonly>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-1" align="right">
									<label style="color:red">*</label>									
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" value="{{$header->NOTES}}" placeholder="Masukkan Notes" >
                                </div>
        
                            </div>
							
							
                            <hr style="margin-top: 30px; margin-buttom: 30px">
							
							<div style="overflow-y:scroll;" class="col-md-12 scrollable" align="right">

								<table id="datatable" class="table table-striped table-border">

									<thead>
										<tr>
										<th width="100px" style="text-align:center">No.</th>

											<th {{( $golz =='B') ? '' : 'hidden' }} width="100px">
												<label style="color:red;font-size:20px">*</label>
												<label for="KD_BHN" class="form-label">Bahan</label>
											</th>
											<th {{( $golz =='B') ? '' : 'hidden' }} width="200px" style="text-align:center">Nama</th>

											<th {{( $golz =='J') ? '' : 'hidden' }} width="100px">
												<label style="color:red;font-size:20px">*</label>
												<label for="KD_BRG" class="form-label">Barang</label>
											</th>
											<th {{( $golz =='J') ? '' : 'hidden' }} width="200px" style="text-align:center">Nama</th>

											<th width="200px" style="text-align:center">Satuan PO</th>
											<th width="200px" style="text-align:center">Qty PO</th>

											<th width="200px" style="text-align:center">X</th>

											<th width="200px" style="text-align:center">Satuan</th>
											<th width="200px" style="text-align:center">Qty</th>  

											<th width="200px" style="text-align:center">Harga</th>
											<th width="200px" style="text-align:center">Total</th>
											<th width="200px" style="text-align:center">PPN</th>
											<th width="200px" style="text-align:center">DPP</th>
											<th width="200px" style="text-align:center">Ket</th>

											<th></th>
																
										</tr>
									</thead>
			
									<tbody>
									<?php $no=0 ?>
									@foreach ($detail as $detail)		
										<tr>
											<td>
												<input type="hidden" name="NO_ID[]{{$no}}" id="NO_ID" type="text" value="{{$detail->NO_ID}}" 
												class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
												
												<input name="REC[]" id="REC{{$no}}" type="text" value="{{$detail->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly style="text-align:center">
											</td>
											<!-- <td>
												<input name="NO_PO[]" id="NO_PO0" type="text" value="{{$detail->NO_PO}}" class="form-control NO_PO" readonly >
											</td>										 -->

											<td {{( $golz =='B') ? '' : 'hidden' }}>
												<input name="KD_BHN[]" id="KD_BHN{{$no}}" type="text" value="{{$detail->KD_BHN}}"
												class="form-control KD_BHN "  onblur="browseBahan({{$no}})" >
											</td>
											<td {{( $golz =='B') ? '' : 'hidden' }}>
												<input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" class="form-control KD_BHN" value="{{$detail->NA_BHN}}" readonly required>
											</td>

											<td {{( $golz =='J') ? '' : 'hidden' }}>
												<input name="KD_BRG[]" id="KD_BRG{{$no}}" type="text" class="form-control KD_BRG " 
												value="{{$detail->KD_BRG}}" onblur="browseBarang({{$no}})">
											</td>

											<td {{( $golz =='J') ? '' : 'hidden' }}>
												<input name="NA_BRG[]" id="NA_BRG{{$no}}" type="text" class="form-control NA_BRG " value="{{$detail->NA_BRG}}">
											</td>

											<td>
												<input name="SATUAN_PO[]" id="SATUAN_PO{{$no}}" type="text" class="form-control SATUAN_PO" value="{{$detail->SATUAN_PO}}">
											</td>										
											<td>
												<input name="QTY_PO[]" onclick="select()" onblur="hitung()" value="{{$detail->QTY_PO}}" id="QTY_PO{{$no}}" type="text" style="text-align: right"  class="form-control QTY_PO" >
											</td>
											
											<td>
												<input name="X[]" id="X{{$no}}" type="text" class="form-control X" value="{{$detail->X}}">
											</td>
											
											<td>
												<input name="SATUAN[]" id="SATUAN{{$no}}" type="text" class="form-control SATUAN" value="{{$detail->SATUAN}}">
											</td>										
											<td>
												<input name="QTY[]" onclick="select()" onblur="hitung()" value="{{$detail->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY" >
											</td>
																																	
											<td>
												<input name="HARGA[]" onclick="select()" onblur="hitung()" value="{{$detail->HARGA}}" id="HARGA{{$no}}" type="text" style="text-align: right"  class="form-control HARGA">
											</td>
		
											<td>
												<input name="TOTAL[]" onblur="hitung()"  value="{{$detail->TOTAL}}" id="TOTAL{{$no}}" type="text" style="text-align: right"  class="form-control TOTAL" readonly>
											</td>
											<td>
												<input name="PPNX[]" onblur="hitung()"  value="{{$detail->PPN}}" id="PPNX{{$no}}" type="text" style="text-align: right"  class="form-control PPNX" readonly>
											</td>
											<td>
												<input name="DPP[]" onblur="hitung()"  value="{{$detail->DPP}}" id="DPP{{$no}}" type="text" style="text-align: right"  class="form-control DPP" readonly>
											</td>
											<td>
												<input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" value="{{$detail->KET}}"  >
											</td> 
											
											<td>
												<button type='button' id='DELETEX{{$no}}'  class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>
											</td> 

										</tr>
									
									<?php $no++; ?>
									@endforeach
									</tbody>

									<tfoot>
										<td></td>
										<td {{( $golz =='B') ? '' : 'hidden' }}></td>
										<td {{( $golz =='B') ? '' : 'hidden' }}></td>
										<td {{( $golz =='J') ? '' : 'hidden' }}></td>
										<td {{( $golz =='J') ? '' : 'hidden' }}></td>
										<td></td>									
										<td><input class="form-control TTOTAL_QTY  text-primary" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										
										<td><input class="form-control TTOTAL  text-primary" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="{{$header->TOTAL}}" readonly></td>
										<td></td>
									</tfoot>
								</table>
							</div>

                            <div class="col-md-2 row">
                               <a type="button" id='PLUSX' onclick="tambah()" class="fas fa-plus fa-sm md-3" style="font-size: 20px" ></a>
					
							</div>>		
							
                        </div> 

                        <hr style="margin-top: 30px; margin-buttom: 30px">
						
						<div class="tab-content mt-6">
						
							<div class="form-group row">
                                <div class="col-md-8" align="right">
                                    <label for="TOTALX" class="form-label">Total</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control TOTALX" id="TOTALX" name="TOTALX" placeholder="TOTALX" value="{{$header->TOTAL}}" style="text-align: right" readonly>
                                </div>
							</div>

                            <div class="form-group row">
                                <div class="col-md-8" align="right">
                                    <label for="PPN" class="form-label">Ppn</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control PPN" id="PPN" name="PPN" placeholder="PPN" value="{{$header->PPN}}" style="text-align: right" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">
                                <div class="col-md-8" align="right">
                                    <label for="NETT" class="form-label">Nett</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text"  onclick="select()" onkeyup="hitung()" class="form-control NETT" id="NETT" name="NETT" placeholder="NETT" value="{{$header->NETT}}" style="text-align: right" readonly>
                                </div>
							</div>
							
						</div>
						   
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/beli/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/beli/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/beli/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/beli/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/beli/edit/?idx=0&tipx=new&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/beli/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/beli?flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-secondary">Close</button>
							</div>
						</div>
						
						
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


 	<div class="modal fade" id="browseSuplierModal" tabindex="-1" role="dialog" aria-labelledby="browseSuplierModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
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
						<th>PO#</th>
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


	<div class="modal fade" id="browseBarangModal" tabindex="-1" role="dialog" aria-labelledby="browseBarangModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
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
						<th>Satuan</th>
						<th>Qty</th>
						<th>Kirim</th>
						<th>Sisa</th>
						<th>Harga</th>	
							
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
	  <div class="modal-dialog modal-xl" role="document">
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
						<th>Qty</th>
						<th>Kirim</th>
						<th>Sisa</th>
						<th>Harga</th>	
						
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

<script>
	var idrow = 1;
	var baris = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
    idrow=<?=$no?>;
    baris=<?=$no?>;

		$('body').on('keydown', 'input, select', function(e) {
			if (e.key === "Enter") {
				var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				focusable = form.find('input,select,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				console.log(next);
				if (next.length) {
					next.focus().select();
				} else {
					tambah();
					var nomer = idrow-1;
					console.log("REC"+nomor);
					document.getElementById("REC"+nomor).focus();
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
             tambah();				 
		}

        if ( $tipx != 'new' )
		{
			 ganti();			
		}    
		
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#PPN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#NETT").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});



		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY_PO" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PPNX" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#DPP" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#X" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}	


		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
			
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
				url: '{{url('po/browse')}}',
				data: {
					'GOL': "{{$golz}}",
				},

				success: function( response )
				{
					resp = response;
					if(dTableBSuplier){
						dTableBSuplier.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSuplier.row.add([
							'<a href="javascript:void(0);" onclick="chooseSuplier(\''+resp[i].NO_BUKTI+'\' ,\''+resp[i].KODES+'\',  \''+resp[i].NAMAS+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODES,
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
		
		chooseSuplier = function( NO_BUKTI,KODES,NAMAS, ALAMAT, KOTA){

			$("#NO_PO").val(NO_BUKTI);
			$("#KODES").val(KODES);
			$("#NAMAS").val(NAMAS);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);			
			$("#browseSuplierModal").modal("hide");
		}
		
		$("#NO_PO").keypress(function(e){

			if(e.keyCode == 46){
				 e.preventDefault();
				 browseSuplier();
			}
		}); 

////////////////////////////////////////////////////////////////////

		//CHOOSE Bahan
		var dTableBBahan;
		var rowidBahan;
		loadDataBBahan = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('po/browse_detail')}}",
				data: 
				{
                    KD_BHN : $("#KD_BHN"+rowidBahan).val(),
                    NO_PO : $("#NO_PO").val(), 					
				},
				success: function( response )
				{
					resp = response;
					if(dTableBBahan){
						dTableBBahan.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBahan.row.add([
							'<a href="javascript:void(0);" onclick="chooseBahan(\''+resp[i].KD_BHN+'\',\''+resp[i].NA_BHN+'\', \''+resp[i].SATUAN_PO+'\' , \''+resp[i].QTY_PO+'\', \''+resp[i].KIRIM+'\' , \''+resp[i].SISA+'\' , \''+resp[i].HARGA+'\' , \''+resp[i].SATUAN+'\', \''+resp[i].QTY+'\', \''+resp[i].X+'\' )">'+resp[i].KD_BHN+'</a>',
							resp[i].NA_BHN,
							resp[i].SATUAN_PO,
							resp[i].QTY_PO,
							resp[i].KIRIM,
							resp[i].SISA,
							resp[i].HARGA,
							
						]);
					}
					dTableBBahan.draw();
				}
			});
		}
		
		dTableBBahan = $("#table-bbahan").DataTable({
			
		});
		
		browseBahan = function(rid){
			rowidBahan = rid;
			loadDataBBahan();
			$("#browseBahanModal").modal("show");
		}
		
		chooseBahan = function(KD_BHN, NA_BHN, SATUAN_PO, QTY_PO, KIRIM, SISA, HARGA, SATUAN, QTY, X ){
			$("#KD_BHN"+rowidBahan).val(KD_BHN);
			$("#NA_BHN"+rowidBahan).val(NA_BHN);
			$("#SATUAN_PO"+rowidBahan).val(SATUAN_PO);
			$("#QTY_PO"+rowidBahan).val(SISA);
			$("#HARGA"+rowidBahan).val(HARGA);
			$("#SATUAN"+rowidBahan).val(SATUAN);
			$("#QTY"+rowidBahan).val(QTY);
			$("#X"+rowidBahan).val(X);
			hitung();
			
			
			$("#browseBahanModal").modal("hide");
		}
		
		
		$("#KD_BHN0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBahan(0);
			}
		}); 

//////////////////////////////////////////////////////////////////////
		
		var dTableBBarang;
		var rowidBarang;
		loadDataBBarang = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('po/browse_detail2')}}",
				data: 
				{
                    KD_BRG : $("#KD_BRG"+rowidBarang).val(),
                    NO_PO : $("#NO_PO").val(), 					
				},				
				
				success: function( response )
				{
					resp = response;
					if(dTableBBarang){
						dTableBBarang.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBarang.row.add([
							'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\',\''+resp[i].NA_BRG+'\', \''+resp[i].SATUAN_PO+'\' , \''+resp[i].QTY_PO+'\' , \''+resp[i].KIRIM+'\' , \''+resp[i].SISA+'\' , \''+resp[i].HARGA+'\', \''+resp[i].SATUAN+'\', \''+resp[i].QTY+'\', \''+resp[i].X+'\'  )">'+resp[i].KD_BRG+'</a>',
							resp[i].NA_BRG,
							resp[i].SATUAN_PO,
							resp[i].QTY_PO,
							resp[i].KIRIM,
							resp[i].SISA,
							resp[i].HARGA,							
						]);
					}
					dTableBBarang.draw();
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});
		
		browseBarang = function(rid){
			rowidBarang = rid;
			loadDataBBarang();
			$("#browseBarangModal").modal("show");
		}
		
		chooseBarang = function(KD_BRG, NA_BRG, SATUAN_PO, QTY_PO, KIRIM, SISA, HARGA, SATUAN, QTY, X ){
			$("#KD_BRG"+rowidBarang).val(KD_BRG);
			$("#NA_BRG"+rowidBarang).val(NA_BRG);
			$("#SATUAN_PO"+rowidBarang).val(SATUAN_PO);
			$("#QTY_PO"+rowidBarang).val(SISA);
			$("#HARGA"+rowidBarang).val(HARGA);
			$("#SATUAN"+rowidBarang).val(SATUAN);			
			$("#QTY"+rowidBarang).val(QTY);			
			$("#X"+rowidBarang).val(X);			
			$("#browseBarangModal").modal("hide");
			hitung();
		}
		
		
		$("#KD_BRG0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(0);
			}
		}); 

	});


///////////////////////////////////////		
    



	function cekDetail(){
		var cekBahan = '';
		$(".KD_BHN").each(function() {
			
			let z = $(this).closest('tr');
			var KD_BHNX = z.find('.KD_BHN').val();
			
			if( KD_BHNX =="" )
			{
					cekBahan = '1';
					
			}	
		});
		
		return cekBahan;
	}


 	function simpan() {
		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
		
			// if (cekDetail())
			// {	
			//     check = '1';
			// 	alert("#Bahan ada yang kosong. ")
			// }

			if ( $('#KD_BRG').val()=='' ) 
            {				
			    check = '1';
				alert("Bahan# Harus Diisi.");
			}

			if ( $('#KD_BHN').val()=='' ) 
            {				
			    check = '1';
				alert("Bahan# Harus Diisi.");
			}
			
			// if ( $('#NO_BUKTI').val()=='' ) 
            // {				
			//     check = '1';
			// 	alert("Bukti# Harus Diisi.");
			// }
			
			if ( $('#KODES').val()=='' ) 
            {				
			    check = '1';
				alert("Suplier# Harus Diisi.");
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
			
			if (baris==0)
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
		
    function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		
	//	hitung();
	
	}

   function hitung() {
		var TTOTAL_QTY = 0;
		var TTOTAL = 0;
		var PPNX = 0;
		var NETTX = 0;

		
		$(".QTY_PO").each(function() {
			
			let z = $(this).closest('tr');
			var QTY_POX = parseFloat(z.find('.QTY_PO').val().replace(/,/g, ''));
			var XX = parseFloat(z.find('.X').val().replace(/,/g, ''));
			var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
	
			var QTYX  = ( QTY_POX * XX );
			z.find('.QTY').val(QTYX);

		    z.find('.X').autoNumeric('update');			
		    z.find('.QTY_PO').autoNumeric('update');	
		    z.find('.QTY').autoNumeric('update');	


            var TOTALX  = ( QTYX * HARGAX );
			z.find('.TOTAL').val(TOTALX);

			var dpp = Math.floor(TOTALX / ((100+11)/100) );
			z.find('.DPP').val(dpp);

			var ppn = TOTALX - dpp;
			z.find('.PPNX').val(ppn);		


		    z.find('.HARGA').autoNumeric('update');			
		    z.find('.QTY_PO').autoNumeric('update');	
		    z.find('.TOTAL').autoNumeric('update');			
		    z.find('.DPP').autoNumeric('update');			
		    z.find('.PPNX').autoNumeric('update');			

            TTOTAL_QTY +=QTYX;		
            TTOTAL +=TOTALX;				
		
		});
		
		PPNX =  TTOTAL * 11 / 100;
		NETTX = PPNX + TTOTAL;
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		$("#TTOTAL_QTY").autoNumeric('update');
		
		if(isNaN(TTOTAL)) TTOTAL = 0;

		$('#TTOTAL').val(numberWithCommas(TTOTAL));		
		$("#TTOTAL").autoNumeric('update');

		$('#PPN').val(numberWithCommas(PPNX));		
		$("#PPN").autoNumeric('update');

		$('#NETT').val(numberWithCommas(NETTX));		
		$("#NETT").autoNumeric('update');

		
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
		
	    $("#PLUSX").attr("hidden", false)
		   
			$("#NO_BUKTI").attr("readonly", true);		   
			$("#TGL").attr("readonly", false);
			$("#KODES").attr("readonly", true);
			$("#NAMAS").attr("readonly", true);			
			$("#ALAMAT").attr("readonly", true);
			$("#KOTA").attr("readonly", true);
			
			$("#NO_FAKTUR").attr("readonly", false);
			$("#TGL_FAKTUR").attr("readonly", false);
			$("#JTEMPO").attr("readonly", false);
			
			$("#NOTES").attr("readonly", false);
			
			$("#PPN").attr("readonly", true);
			$("#NETT").attr("readonly", true);	

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", false);
			$("#KD_BRG" + i.toString()).attr("readonly", false);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN_PO" + i.toString()).attr("readonly", true);
			$("#QTY_PO" + i.toString()).attr("readonly", false);
			$("#X" + i.toString()).attr("readonly", false);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", false);
			$("#TOTAL" + i.toString()).attr("readonly", false);
			$("#DPP" + i.toString()).attr("readonly", true);
			$("#PPNX" + i.toString()).attr("readonly", true);
			$("#KET" + i.toString()).attr("readonly", false);
			$("#DELETEX" + i.toString()).attr("hidden", false);

			$tipx = $('#tipx').val();
		
			
			if ( $tipx != 'new' )
			{
				$("#KD_BHN" + i.toString()).attr("readonly", true);	
				$("#KD_BHN" + i.toString()).removeAttr('onblur');
				
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
		
		
	    $("#PLUSX").attr("hidden", true)
		
	    $(".NO_BUKTI").attr("readonly", true);	
		
		$("#TGL").attr("readonly", true);
		$("#KODES").attr("readonly", true);
		$("#NAMAS").attr("readonly", true);
		$("#ALAMAT").attr("readonly", true);
		$("#KOTA").attr("readonly", true);

			$("#NO_FAKTUR").attr("readonly", true);
			$("#TGL_FAKTUR").attr("readonly", true);
			$("#JTEMPO").attr("readonly", true);
			
		$("#PPN").attr("readonly", true);
		$("#NETT").attr("readonly", true);		
		
		$("#NOTES").attr("readonly", true);

		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN_PO" + i.toString()).attr("readonly", true);
			$("#QTY_PO" + i.toString()).attr("readonly", true);
			$("#X" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", true);
			$("#TOTAL" + i.toString()).attr("readonly", true);
			$("#DPP" + i.toString()).attr("readonly", true);
			$("#PPNX" + i.toString()).attr("readonly", true);
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
		 $('#NO_PO').val("");
		 $('#PPN').val("0.00");
		 $('#NETT').val("0.00");
		 $('#DPP').val("0.00");
		 $('#PPNX').val("0.00");		 
	
		 $('#TTOTAL_QTY').val("0.00");
		 $('#TTOTAL').val("0.00");		 
		 
		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/beli/delete/'.$header->NO_ID .'/?flagz='.$flagz.'&golz=' .$golz.'' )}}";
			//return true;
		} 
		return false;
	}
	

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var golz = "{{ $golz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/beli/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&golz=' + encodeURIComponent(golz) + '&buktix=' +encodeURIComponent(cari);
		window.location = loc;
		
	}


    function tambah() {

        var x = document.getElementById('datatable').insertRow(baris + 1);
 
		html=`<tr>

                <td>
 					<input name='NO_ID[]' id='NO_ID${idrow}' type='hidden' class='form-control NO_ID' value='new' readonly> 
					<input name='REC[]' id='REC${idrow}' type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>
	            </td>
				
                <td {{( $golz =='B') ? '' : 'hidden' }} >
				    <input name='KD_BHN[]' data-rowid=${idrow} onblur='browseBahan(${idrow})' id='KD_BHN${idrow}' type='text' class='form-control  KD_BHN' >
                </td>
                <td {{( $golz =='B') ? '' : 'hidden' }} >
				    <input name='NA_BHN[]'   id='NA_BHN${idrow}' type='text' class='form-control  NA_BHN' required readonly>
                </td>

				<td {{( $golz =='J') ? '' : 'hidden' }} >
				    <input name='KD_BRG[]' data-rowid=${idrow} onblur='browseBarang(${idrow})' id='KD_BRG${idrow}' type='text' class='form-control  KD_BRG' >
                </td>
                <td {{( $golz =='J') ? '' : 'hidden' }} >
				    <input name='NA_BRG[]'   id='NA_BRG${idrow}' type='text' class='form-control  NA_BRG' required readonly>
                </td>


                <td>
				    <input name='SATUAN_PO[]'   id='SATUAN_PO${idrow}' type='text' class='form-control  SATUAN_PO' readonly>
                </td>
				
				<td>
		            <input name='QTY_PO[]' onclick ='select()' onblur='hitung()' value='0' id='QTY_PO${idrow}' type='text' style='text-align: right' class='form-control QTY_PO text-primary' >
                </td>

				<td>
				    <input name='X[]' onclick ='select()' value='0' onblur='hitung()'  id='X${idrow}' type='text' class='form-control  X'>
                </td>
				
                <td>
				    <input name='SATUAN[]' id='SATUAN${idrow}' type='text' class='form-control  SATUAN' readonly>
                </td>
				
				<td>
		            <input name='QTY[]' onclick ='select()' onblur='hitung()' value='0' id='QTY${idrow}' type='text' style='text-align: right' class='form-control QTY text-primary' readonly >
                </td>

				<td>
		            <input name='HARGA[]' onclick ='select()' onblur='hitung()' value='0' id='HARGA${idrow}' type='text' style='text-align: right' class='form-control HARGA text-primary' required >
                </td>

				<td>
		            <input name='TOTAL[]'  onblur='hitung()' value='0' id='TOTAL${idrow}' type='text' style='text-align: right' class='form-control TOTAL text-primary' readonly required >
                </td>

				<td>
		            <input name='PPNX[]'  onblur='hitung()' value='0' id='PPNX${idrow}' type='text' style='text-align: right' class='form-control PPNX text-primary' readonly required >
                </td>

				<td>
					<input name='DPP[]'  onblur='hitung()' value='0' id='DPP${idrow}' type='text' style='text-align: right' class='form-control DPP text-primary' readonly required >
				</td>					
							
                <td>
				    <input name='KET[]'   id='KET${idrow}' type='text' class='form-control  KET' required>
                </td>
				
                <td>
					<button type='button' id='DELETEX${idrow}'  class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>
                </td>				
         </tr>`;
				
        x.innerHTML = html;
        var html='';
		
		
		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY_PO" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});

			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});

			
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			
			
			$("#X" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			
			$("#DPP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			
			$("#PPNX" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});


			
		}

		// $("#KD_BHN"+idrow).keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browseBahan(eval($(this).data("rowid")));
		// 	}
		// }); 


        idrow++;
        baris++;
        nomor();
		
		$(".ronly").on('keydown paste', function(e) {
             e.preventDefault();
             e.currentTarget.blur();
         });
     }
</script>

<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection