@extends('layouts.main')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{($tipx=='new')? url('/terima/store?flagz='.$flagz.'&golz='.$golz.'') : url('/terima/update/'.$header->NO_ID.'&flagz='.$flagz.'&golz='.$golz.'' ) }}" method="POST" name ="entri" id="entri" >
  
	    			      @csrf
        
                        <div class="tab-content mt-3">
        
                            <div class="form-group row">
								<div class="col-md-1" align="left">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								

                                   <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden >
									<input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden >
									<input name="golz" class="form-control golz" id="golz" value="{{$golz}}" hidden >
			
								
                                <div class="col-md-2">
									<input type="text" class="form-control KODEC" id="KODEC" name="KODEC" value="{{$header->KODEC}}" readonly hidden>
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" value="{{$header->NAMAC}}" readonly hidden>
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti" value="{{$header->NO_BUKTI}}" readonly>
                                </div>
        
                                <div class="col-md-1" align="right">
									<label style="color:red;font-size:20px">* </label>								
                                    <label class="form-label">Pakai#</label>
                                </div>

								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PAKAI" id="NO_PAKAI" name="NO_PAKAI" placeholder="No Pemakaian" value="{{$header->NO_PAKAI}}" readonly>
                                </div>

                                <div class="col-md-2">
									<label style="cursor: pointer; font-size: 20px;">
										<input type="checkbox" id="FIN" name="FIN" value="1" {{ ($header->FIN == 1) ? 'checked' : '' }}> Finish
									</label>
                                </div>
                            </div>
        
							<div class="form-group row">
								<div class="col-md-1" align="left">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}" >
                                </div>
                                <div class="col-md-1" align="right">		
                                    <label class="form-label">OK#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_OK" id="NO_OK" name="NO_OK" placeholder="No Order Kerja" value="{{$header->NO_ORDER}}" readonly>
                                </div>
                                <div class="col-md-1" align="right">			
                                    <label class="form-label">FO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_FO" id="NO_FO" name="NO_FO" placeholder="No Formula" value="{{$header->NO_FO}}" readonly>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_PRSH" id="NA_PRSH" name="NA_PRSH" placeholder="Nama Proses" value="{{$header->NA_PRS}}" readonly hidden>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label" hidden>Proses</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_PRSH" id="KD_PRSH" name="KD_PRSH" placeholder="Kode Proses" value="{{$header->KD_PRS}}"  readonly hidden>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PRS" id="NO_PRS" name="NO_PRS" placeholder="No Proses" value="{{$header->NO_PRS}}" readonly hidden>
                                </div>
                            </div>
							

                            <div class="form-group row">
								<div class="col-md-1" align="left">
                                    <label class="form-label">Barang</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG" placeholder="Barang#" value="{{$header->KD_BRG}}" readonly>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">Satuan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUANH" id="SATUANH" name="SATUANH" placeholder="Satuan" value="{{$header->SATUAN}}" readonly>
                                </div>
                                <div class="col-md-1" align="right">
                                    <label class="form-label">SO#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="No Sales Order" value="{{$header->NO_SO}}" readonly>
                                </div>
                            </div>
							

							<div class="form-group row">
								<div class="col-md-1" align="left">
                                </div>

                                <div class="col-md-5">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama Barang" value="{{$header->NA_BRG}}" readonly>
                                </div>
                            </div>

							
                            <div class="form-group row">
								<div class="col-md-1" align="left">
                                    <label class="form-label">Qty</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control QTYH" id="QTYH" name="QTYH" {{ ($header->FLAG == "HP") ? 'readonly value='.$header->QTY : 'value='.$header->QTY_BHN }}>
                                </div>
                            </div>

							<div class="form-group row">
								<div class="col-md-1" align="left">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes" value="{{$header->NOTES}}">
                                </div>
                            </div>
							
                            
                            <hr style="margin-top: 30px; margin-buttom: 30px">
							
							<div style="overflow-y:scroll;" class="col-md-12 scrollable" align="right">
							
								<table id="datatable" class="table table-striped table-border">

									<thead>
										<tr>
											<th width="75px" style="text-align: center;">No.</th>
											<th style="text-align: center;">Kode</th>
											<th style="text-align: center;">Bahan</th>
											<th style="text-align: center;">Stn</th>
											<th style="text-align: center;">Qty</th>
											<th style="text-align: center;">Ket</th>
											<th style="text-align: center;"></th>		
										</tr>
										
									</thead>
									<tbody id="detailTerima">
									
									<?php $no=0 ?>
									@foreach ($detail as $detail)
										<tr>
											<td>
												<input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$detail->NO_ID}}" 
												class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
												
												<input name="REC[]" id="REC{{$no}}" type="text" value="{{$detail->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
											</td>
											
											<td>
												<input name="KD_BHN[]" id="KD_BHN{{$no}}" type="text" class="form-control KD_BHN" placeholder="Bahan#" value="{{$detail->KD_BHN}}" readonly required>
											</td>
											<td>
												<input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" class="form-control NA_BHN" value="{{$detail->NA_BHN}}" readonly required>
											</td>
											<td>
												<input name="SATUAN[]" id="SATUAN{{$no}}" type="text" class="form-control SATUAN" placeholder="Satuan" value="{{$detail->SATUAN}}" readonly required>
											</td>   
											<td>
												<input name="QTY[]" onkeyup="hitung()" value="{{$detail->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly>
											</td>   
											<td>
												<input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" placeholder="Ket" value="{{$detail->KET}}" required>
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
										<td></td>
										<td></td>
										<td></td>
										<td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
										<td></td>
										<td></td>
									</tfoot>
								</table>					
							</div>

							<!-- <div class="col-md-2 row">
								<a type="button" id='PLUSX' onclick="tambah()" class="fas fa-plus fa-sm md-3" style="font-size: 20px" ></a>
							</div>			 -->
							
                        </div> 
						
						<hr style="margin-top: 30px; margin-buttom: 30px">		
						
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/terima/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/terima/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/terima/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/terima/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/terima/edit/?idx=0&tipx=new&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/terima/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/terima?flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-secondary">Close</button>
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
	

	<div class="modal fade" id="browsePakaiModal" tabindex="-1" role="dialog" aria-labelledby="browsePakaiModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePakaiModalLabel">Cari Order Kerja</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-pakai">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Order Kerja#</th>
						<th>SO#</th>
						<th>FO#</th>
						<th>Proses#</th>
						<th>Nama</th>
						<th>No Proses</th>
						<th>Barang</th>
						<th>Qty</th>
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
            //  tambah();				 
		}

        if ( $tipx != 'new' )
		{
			 ganti();			
		}    
		
		$("#QTYH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
//////////////////////////////////////////////////

		var dTablePakai;
		loadDataPakai = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('terima/browsePakai')}}",
				data: {
					'FLAG': "PK",
				},
				success: function( response )
				{
					resp = response;
					if(dTablePakai){
						dTablePakai.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTablePakai.row.add([
							'<a href="javascript:void(0);" onclick="choosePakai(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\',  \''+resp[i].KD_PRS+'\', \''+resp[i].NA_PRS+'\', \''+resp[i].NO_PRS+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\', \''+resp[i].NO_SO+'\',  \''+resp[i].NO_FO+'\',  \''+resp[i].NO_ORDER+'\',  \''+resp[i].QTY_OUT+'\',  \''+resp[i].NOTES+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].NO_ORDER,
							resp[i].NO_SO,
							resp[i].NO_FO,
							resp[i].KD_PRS,
							resp[i].NA_PRS,
							resp[i].NO_PRS,
							resp[i].NA_BRG,
							Intl.NumberFormat('en-US').format(resp[i].QTY_OUT),	
							resp[i].SATUAN,
						]);
					}
					dTablePakai.draw();
				}
			});
		}
		
		dTablePakai = $("#table-pakai").DataTable({
            columnDefs: [
                {
                    "className": "dt-right", 
                    "targets": 9,
                },	
            ],
		});
		
		browsePakai = function(){
			loadDataPakai();
			$("#browsePakaiModal").modal("show");
		}
		
		choosePakai = function(NO_BUKTI, KODEC, NAMAC, KD_PRS, NA_PRS, NO_PRS, SATUAN, KD_BRG, NA_BRG, NO_SO, NO_FO, NO_ORDER, QTY_OUT, NOTES){
			$("#NO_PAKAI").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#KD_PRSH").val(KD_PRS);
			$("#NA_PRSH").val(NA_PRS);			
			$("#NO_PRS").val(NO_PRS);
			$("#SATUANH").val(SATUAN);	
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);	
			$("#NO_SO").val(NO_SO);		
			$("#NO_FO").val(NO_FO);		
			$("#NO_OK").val(NO_ORDER);		
			$("#QTYH").val(QTY_OUT);	
			$("#NOTES").val(NOTES);			
			$("#browsePakaiModal").modal("hide");
			$("#QTYH").autoNumeric('update');

			getPakaid(NO_ORDER);
		}
		
		$("#NO_PAKAI").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browsePakai();
			}
		}); 
	}); 

////////////////////////////////////////////////////////////////////////////////////

	function getPakaid(no_order)
	{
		$.ajax(
			{
				type: 'GET',    
				url: "{{url('terima/browsePakaid')}}",
				data: {
					no_orderk: no_order,
				},
				success: function( resp )
				{
					var html = '';
					for(i=0; i<resp.length; i++){
						html+=`<tr>
                                    <td><input name='NO_ID[]' id='NO_ID${i}' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id=REC${i} value=${i+1} type='text' class='REC form-control' onkeypress='return tabE(this,event)' style='text-align: center;' readonly></td>
                                    <td><input name='KD_BHN[]' data-rowid=${i} id=KD_BHN${i} value="${resp[i].KD_BHN}" type='text' class='form-control KD_BHN' required readonly></td>
                                    <td><input name='NA_BHN[]' data-rowid=${i} id=NA_BHN${i} value="${resp[i].NA_BHN}" type='text' class='form-control  NA_BHN' required readonly></td>
                                    <td><input name='SATUAN[]' data-rowid=${i} id=SATUAN${i} value="${resp[i].SATUAN}" type='text' class='form-control  SATUAN' placeholder="Satuan" required readonly></td>
                                    <td><input name='QTY[]' onclick='select()' onkeyup='hitung()' id=QTY${i} value="${resp[i].QTY}" type='text' style='text-align: right' class='form-control QTY text-primary' required readonly></td>
                                    <td><input name='KET[]' id=KET${i} value="${resp[i].KET}" type='text' class='form-control  KET' readonly></td>
                                    <td><button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button></td>
                                </tr>`;
					}
					$('#detailTerima').html(html);
					$(".QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".QTY").autoNumeric('update');
					idrow=resp.length;
					baris=resp.length;

					nomor();
				}
			});
	}

//////////////////////////////////////////////////////////////////


	function simpan() {

		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';

			$(".KD_BHN").each(function() {
			var kdbhn = $(this).val();
				if(kdbhn=='')
				{
					var val = $(this).parents("tr").remove();
					baris--;
					nomor();
				}
			});


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

			if ( $('#NO_PAKAI').val()=='' ) 
			{			
				check = '1';
				alert("Pemakaian Harus diisi.");
			}

			if ( $('#NO_OK').val()=='' ) 
			{			
				check = '1';
				alert("Order Kerja Harus diisi.");
			}

			if ( $('#NO_SO').val()=='' ) 
			{			
				check = '1';
				alert("SO Harus diisi.");
			}

			if ( $('#NO_FO').val()=='' ) 
			{			
				check = '1';
				alert("Formula Harus diisi.");
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
	//	hitung();
	}
 
	
	
	function hitung() {
		var TTOTAL_QTY = 0;

		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTY = parseFloat($(this).val().replace(/,/g, ''));
		
            TTOTAL_QTY +=QTY;	
		});
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;
	
		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		

		$("#TTOTAL_QTY").autoNumeric('update');
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
			$("#NO_SO").attr("readonly", true);
			$("#KODEC").attr("readonly", true);			
			$("#NAMAC").attr("readonly", true);
			$("#ALAMAT").attr("readonly", true);
			$("#KOTA").attr("readonly", true);			
			$("#NOTES").attr("readonly", false);
		
	

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", false);
			$("#KD_BRG" + i.toString()).attr("readonly", false);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", false);
			$("#QTY" + i.toString()).attr("readonly", false);
			$("#HARGA" + i.toString()).attr("readonly", true);
			$("#TOTAL" + i.toString()).attr("readonly", false);
			$("#DPP" + i.toString()).attr("readonly", true);
			$("#PPN" + i.toString()).attr("readonly", true);
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
		$("#KODEC").attr("readonly", true);			
		$("#NAMAC").attr("readonly", true);
		$("#ALAMAT").attr("readonly", true);
		$("#KOTA").attr("readonly", true);	
		$("#NOTES").attr("readonly", true);

		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
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
		 $('#NO_SO').val("");
		 $('#KODEC').val("");
		 $('#NAMAC').val("");
		 $('#ALAMAT').val("");
		 $('#KOTA').val("");		 
	//	 $('#TGL').val("");	
		 $('#NOTES').val("");	
		 $('#TTOTAL_QTY').val("0.00");	
		 $('#TTOTAL').val("0.00");

		 $('#PPN').val("0.00");	
		 $('#NETT').val("0.00");
		 $('#DPP').val("0.00");
		 $('#PPNX').val("0.00");
		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/terima/delete/'.$header->NO_ID .'/?flagz='.$flagz.'&golz=' .$golz.'' )}}";
			//return true;
		} 
		return false;
	}
	

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/terima/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&golz=' + encodeURIComponent(golz) + '&buktix=' +encodeURIComponent(cari);
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
				    <input name='SATUAN[]'   id='SATUAN${idrow}' type='text' class='form-control  SATUAN' readonly required>
                </td>
				
				<td>
		            <input name='QTY[]'  onblur='hitung()' value='0' id='QTY${idrow}' type='text' style='text-align: right' class='form-control QTY text-primary' required >
                </td>

				<td>
		            <input name='HARGA[]'  onblur='hitung()' value='0' id='HARGA${idrow}' type='text' style='text-align: right' class='form-control HARGA text-primary' required >
                </td>
				
				<td>
		            <input name='TOTAL[]'  onblur='hitung()' value='0' id='TOTAL${idrow}' type='text' style='text-align: right' class='form-control TOTAL text-primary' required >
                </td>
				
				<td>
		            <input name='DPP[]'  onblur='hitung()' value='0' id='DPP${idrow}' type='text' style='text-align: right' class='form-control DPP text-primary' readonly >
                </td>
				
				<td>
		            <input name='PPNX[]'  onblur='hitung()' value='0' id='PPNX${idrow}' type='text' style='text-align: right' class='form-control PPNX text-primary' readonly >
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
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PPNX" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#DPP" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
	
		}
		
		// $("#KD_BRG"+idrow).keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browseBarang(eval($(this).data("rowid")));
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