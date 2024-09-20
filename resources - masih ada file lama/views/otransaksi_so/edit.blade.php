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

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                   <form action="{{($tipx=='new')? url('/so/store?flagz='.$flagz.'&golz='.$golz.'') : url('/so/update/'.$header->NO_ID.'&flagz='.$flagz.'&golz='.$golz.'' ) }}" method="POST" name ="entri" id="entri" >
  
	    			      @csrf
        
                        <div class="tab-content mt-3">
        
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								

                                   <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									
									<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden>
									<input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden>
									<input name="golz" class="form-control golz" id="flagz" value="{{$golz}}" hidden>

								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly >
                                </div>
        
                                <div class="col-md-1">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
								
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}">
								
                                </div>
                            </div>
        
	                          
                            <div class="form-group row">

								<div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="KODEC" class="form-label">Customer</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Pilih Customer"value="{{$header->KODEC}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseCust()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
							

							<div class="form-group row">


								<div class="col-md-1" align="left">
                                    <label for="NAMAC" class="form-label"></label>
                                </div>
								<div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="-" value="{{$header->NAMAC}}" readonly>
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
                                <div class="col-md-1">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}">
                                </div>
        

                            </div>
							
                            
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

										<th width="200px" style="text-align:center">Satuan</th>
										<th width="200px" style="text-align:center">Qty</th> 
										<th width="200px" style="text-align:center">Harga</th>

										<th width="200px" style="text-align:center">Total</th>

										<th width="200px" style="text-align:center">Ket</th>
										<th></th>										
                                    </tr>
									
                                </thead>
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $detail)
                                    <tr>
                                        <td>
										    <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$detail->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
                                            
											<input name="REC[]" id="REC{{$no}}" type="text" value="{{$detail->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
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
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" value="{{$detail->SATUAN}}" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTY[]" onclick='select()' onblur="hitung()" value="{{$detail->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" ></td>
										<td><input name="HARGA[]" onclick='select()' onblur="hitung()" value="{{$detail->HARGA}}" id="HARGA{{$no}}" type="text" style="text-align: right"  class="form-control HARGA text-primary" ></td>
 										<td><input name="TOTAL[]" onclick='select()' onblur="hitung()" value="{{$detail->TOTAL}}" id="TOTAL{{$no}}" type="text" style="text-align: right"  class="form-control TOTAL text-primary" readonly ></td>
                                        <td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" value="{{$detail->KET}}" class="form-control KET" >
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
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="{{$header->TOTAL}}" readonly></td>
                                    <td></td>
                                </tfoot>
                            </table> 

							<div class="col-md-2 row">
								<a type="button" id='PLUSX' onclick="tambah()" class="fas fa-plus fa-sm md-3" style="font-size: 20px" ></a>

							</div>
                                 
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/so/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/so/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/so/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/so/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/so/edit/?idx=0&tipx=new&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/so/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/so?flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-secondary">Close</button>
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
	

 	<div class="modal fade" id="browseCustModal" tabindex="-1" role="dialog" aria-labelledby="browseCustModalLabel" aria-hidden="true">
	  <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustModalLabel">Cari Customer</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bcust">
				<thead>
					<tr>
						<th>Customer</th>
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
	  <div class="modal-dialog" role="document">
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
             tambah();				 
		}

        if ( $tipx != 'new' )
		{
			 ganti();			
		}    
		
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
//////////////////////////////////////////////

 		var dTableBCust;
		loadDataBCust = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('cust/browse')}}',
				// data: {
				// 	'GOL': 'Y',
				// },
				success: function( response )
				{
					resp = response;
					if(dTableBCust){
						dTableBCust.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBCust.row.add([
							'<a href="javascript:void(0);" onclick="chooseCustomer(\''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODEC+'</a>',
							resp[i].NAMAC,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableBCust.draw();
				}
			});
		}
		
		dTableBCust = $("#table-bcust").DataTable({
			
		});
		
		browseCust = function(){
			loadDataBCust();
			$("#browseCustModal").modal("show");
		}
		
		chooseCustomer = function(KODEC,NAMAC, ALAMAT, KOTA){
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);			
			$("#browseCustModal").modal("hide");
		}
		
		$("#KODEC").keypress(function(e){

			if(e.keyCode == 46){
				 e.preventDefault();
				 browseCust();
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
						'KD_BRG': $("#KD_BRG"+rowidBarang).val(),
					
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
									'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\', \''+resp[i].NA_BRG+'\' , \''+resp[i].SATUAN+'\' )">'+resp[i].KD_BRG+'</a>',
									resp[i].NA_BRG,
									resp[i].SATUAN,
								]);
							}
							dTableBBarang.draw();
					
					}
					else
					{
						$("#KD_BRG"+rowidBarang).val(resp[0].KD_BRG);
						$("#NA_BRG"+rowidBarang).val(resp[0].NA_BRG);
						$("#SATUAN"+rowidBarang).val(resp[0].SATUAN);
					}
				}
			});
		}
		
		dTableBBarang = $("#table-bbarang").DataTable({
			
		});

		browseBarang = function(rid){
			rowidBarang = rid;
			$("#NA_BRG"+rowidBarang).val("");			
			loadDataBBarang();
	
			
			if ( $("#NA_BRG"+rowidBarang).val() == '' ) {				
					$("#browseBarangModal").modal("show");
			}	
		}
		
		chooseBarang = function(KD_BRG,NA_BRG,SATUAN){
			$("#KD_BRG"+rowidBarang).val(KD_BRG);
			$("#NA_BRG"+rowidBarang).val(NA_BRG);	
			$("#SATUAN"+rowidBarang).val(SATUAN);
			$("#browseBarangModal").modal("hide");
		}
		
		
		/* $("#RAK0").onblur(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseRak(0);
			}
		});  */

		////////////////////////////////////////////////////

		//////////////////////////////////////////////////////

		var dTableBBahan;
		var rowidBahan;
		loadDataBBahan = function(){
		
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('bhn/browse')}}",
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
									'<a href="javascript:void(0);" onclick="chooseBahan(\''+resp[i].KD_BHN+'\', \''+resp[i].NA_BHN+'\' , \''+resp[i].SATUAN+'\' )">'+resp[i].KD_BHN+'</a>',
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
		
		chooseBahan = function(KD_BHN,NA_BHN,SATUAN){
			$("#KD_BHN"+rowidBahan).val(KD_BHN);
			$("#NA_BHN"+rowidBahan).val(NA_BHN);	
			$("#SATUAN"+rowidBahan).val(SATUAN);
			$("#browseBahanModal").modal("hide");
		}
		
		
		/* $("#RAK0").onblur(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseRak(0);
			}
		});  */

		////////////////////////////////////////////////////


	});




//////////////////////////////////////////////////////////////////


	function simpan() {

		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
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

			if ( $('#KD_BRG').val()=='' ) 
            {				
			    check = '1';
				alert("Barang# Harus Diisi.");
			}

			if ( $('#KD_BHN').val()=='' ) 
            {				
			    check = '1';
				alert("Bahan# Harus Diisi.");
			}

        
			if ( $('#NO_BUKTI').val()=='' ) 
            {				
			    check = '1';
				alert("Bukti# Harus Diisi.");
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
		var TTOTAL = 0;

		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat(z.find('.QTY').val().replace(/,/g, ''));
			var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
			var TOTALX = QTYX * HARGAX;
		
			z.find('.QTY').val(QTYX);			
		    z.find('.QTY').autoNumeric('update');

			z.find('.HARGA').val(HARGAX);			
		    z.find('.HARGA').autoNumeric('update');

			z.find('.TOTAL').val(TOTALX);			
		    z.find('.TOTAL').autoNumeric('update');

		
            TTOTAL_QTY +=QTYX;				
            TTOTAL +=TOTALX;	
			
		});
		
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		$("#TTOTAL_QTY").autoNumeric('update');


		if(isNaN(TTOTAL)) TTOTAL_QTY = 0;

		$('#TTOTAL').val(numberWithCommas(TTOTAL));		
		$("#TTOTAL").autoNumeric('update');
		
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
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", false);
			$("#HARGA" + i.toString()).attr("readonly", false);
			$("#TOTAL" + i.toString()).attr("readonly", true);
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
			$("#KET" + i.toString()).attr("readonly", true);
			
			$("#DELETEX" + i.toString()).attr("hidden", true);
		}


		
	}


	function kosong() {
				
		 $('#NO_BUKTI').val("+");	
	//	 $('#TGL').val("");		
		 $('#KODEC').val("");	
		 $('#NAMAC').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");	
		 $('#NOTES').val("");	
		 $('#TTOTAL_QTY').val("0.00");
		 $('#TTOTAL').val("0.00")

		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/so/delete/'.$header->NO_ID .'/?flagz='.$flagz.'&golz=' .$golz.'' )}}";

			//return true;
		} 
		return false;
	}
	

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var golz = "{{ $golz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/so/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&golz=' + encodeURIComponent(golz) + '&buktix=' +encodeURIComponent(cari);
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
		            <input name='QTY[]' onclick='select()' onblur='hitung()' value='0' id='QTY${idrow}' type='text' style='text-align: right' class='form-control QTY text-primary' required >
                </td>

				<td>
		            <input name='HARGA[]' onclick='select()' onblur='hitung()' value='0' id='HARGA${idrow}' type='text' style='text-align: right' class='form-control HARGA text-primary' required >
                </td>
				
				<td>
		            <input name='TOTAL[]' onclick='select()' onblur='hitung()' value='0' id='TOTAL${idrow}' type='text' style='text-align: right' class='form-control TOTAL text-primary' readonly required >
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



<!-- <script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script> -->

@endsection