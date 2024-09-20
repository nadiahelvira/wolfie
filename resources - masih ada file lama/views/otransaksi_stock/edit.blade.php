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
  
					<form action="{{($tipx=='new')? url('/stock/store') : url('/stock/update/'.$header->NO_ID.'' ) }}" method="POST" name ="entri" id="entri" >
  
                       @csrf
                       
                        <div class="tab-content mt-3">
        
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								
                                   <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden>

			 							
									
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
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes" value="{{$header->NOTES}}">
                                </div>
        

                            </div>
							

                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BRG" class="form-label">Barang#</label></th>
                                        <th style="text-align: center;">Nama</th>
                                        <th style="text-align: center;">Stn</th>
										<th style="text-align: center;">Qty</th>										
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
                                        <td>
                                            <input name="KD_BRG[]" id="KD_BRG{{$no}}" type="text" value="{{$detail->KD_BRG}}" class="form-control KD_BRG" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BRG[]" id="NA_BRG{{$no}}" type="text" value="{{$detail->NA_BRG}}" class="form-control NA_BRG" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" value="{{$detail->SATUAN}}" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTY[]"  onblur="hitung()" value="{{$detail->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary"></td>
                                        

										
										<td>
										
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
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

						   
						   
                            <div class="col-md-2 row">
                               <a type="button" id='PLUSX' onclick="tambah()" class="fas fa-plus fa-sm md-3" ></a>					
							</div>			
                                 
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/stock/edit/?idx=' .$idx. '&tipx=top' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/stock/edit/?idx='.$header->NO_ID.'&tipx=prev&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/stock/edit/?idx='.$header->NO_ID.'&tipx=next&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/stock/edit/?idx=' .$idx. '&tipx=bottom' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/stock/edit/?idx=0&tipx=new' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/stock/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success"<i class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/stock' )}}'" class="btn btn-outline-secondary">Close</button>
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
		
		

//////////////////////////////////////////////////////////////////////
		
 		var dTableBBarang;
		var rowidBarang;
		loadDataBBarang = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('brg/browse')}}",
				data: 
				{
                    KD_BRG : $("#KD_BRG"+rowidBarang).val(),					   
				},				
				success: function( response )
				{
					resp = response;
					if(dTableBBarang){
						dTableBBarang.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBarang.row.add([
							'<a href="javascript:void(0);" onclick="chooseBarang(\''+resp[i].KD_BRG+'\',\''+resp[i].NA_BRG+'\', \''+resp[i].SATUAN+'\'  )">'+resp[i].KD_BRG+'</a>',
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
		
		browseBarang = function(rid){
			rowidBarang = rid;
			loadDataBBarang();
			$("#browseBarangModal").modal("show");
		}
		
		chooseBarang = function(KD_BRG, NA_BRG, SATUAN){
			$("#KD_BRG"+rowidBarang).val(KD_BRG);
			$("#NA_BRG"+rowidBarang).val(NA_BRG);
			$("#SATUAN"+rowidBarang).val(SATUAN);
			$("#browseBarangModal").modal("hide");
		}
		
		
		$("#KD_BRG0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(0);
			}
		}); 
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


		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYX = parseFloat(z.find('.QTY').val().replace(/,/g, ''));

			z.find('.QTY').val(QTYX);
			
		    z.find('.QTY').autoNumeric('update');
		
            TTOTAL_QTY +=QTYX;				
		
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
			$("#NOTES").attr("readonly", false);
		
	

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", false);
			$("#DELETEX" + i.toString()).attr("hidden", false);
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
		$("#NOTES").attr("readonly", true);

		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", true);
			$("#DELETEX" + i.toString()).attr("hidden", true);
		}


		
	}


	function kosong() {
				
		 $('#NO_BUKTI').val("+");	
	//	 $('#TGL').val("");	
		 $('#NOTES').val("");	
		 $('#TTOTAL_QTY').val("0.00");	

		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/stock/delete/'.$header->NO_ID .'' )}}";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
	
		var cari = $("#CARI").val();
		var loc = "{{ url('/stock/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&buktix=' +encodeURIComponent(cari);
		window.location = loc;
	
		
	}


    function tambah() {

        var x = document.getElementById('datatable').insertRow(baris + 1);
 
		html=`<tr>

                <td>
 					<input name='NO_ID[]' id='NO_ID${idrow}' type='hidden' class='form-control NO_ID' value='new' readonly> 
					<input name='REC[]' id='REC${idrow}' type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>
	            </td>
						       
                <td>
				    <input name='KD_BRG[]' data-rowid=${idrow}  id='KD_BRG${idrow}' type='text' class='form-control  KD_BRG' readonly required >
                </td>
                <td>
				    <input name='NA_BRG[]'   id='NA_BRG${idrow}' type='text' class='form-control  NA_BRG' required readonly>
                </td>
                <td>
				    <input name='SATUAN[]'   id='SATUAN${idrow}' type='text' class='form-control SATUAN' readonly required>
                </td>
				
				<td>
		            <input name='QTY[]'  onblur='hitung()' value='0' id='QTY${idrow}' type='text' style='text-align: right' class='form-control QTY text-primary' required >
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
		}
		
		$("#KD_BRG"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBarang(eval($(this).data("rowid")));
			}
		}); 
		
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