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
               <h1 class="m-0">Edit Pembayaran Hutang Bahan {{$header->NO_BUKTI}}</h1>	
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/hutb')}}">Pembayaran Hutang Bahan</a></li>
                <li class="breadcrumb-item active">Edit {{$header->NO_BUKTI}}</li>
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
                    <form action="{{url('/hutb/update/'.$header->NO_ID)}}" id="entri" method="POST">
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
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}">

                                </div>
                            </div>
        
 
							<div class="form-group row">
                                <div class="col-md-2">
									<label style="color:red">*</label>									
                                    <label for="NO_PO" class="form-label">PO#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_PO" id="NO_PO" name="NO_PO" placeholder="Masukkan PO#" value="{{$header->NO_PO}}" readonly>
                                </div>
        
                            </div>
							
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODES" class="form-label">Suplier#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Masukkan Suplier#" value="{{$header->KODES}}"readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAS" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS" placeholder="-" value="{{$header->NAMAS}}" readonly>
                                </div>
                            </div>
        
		
  
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="BACNO" class="form-label">Bank#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control BACNO" id="BACNO" name="BACNO" placeholder="Masukkan Bank#" value="{{$header->BACNO}}" readonly>
                                </div>
        
                            </div>
        
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="BNAMA" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control BNAMA" id="BNAMA" name="BNAMA" placeholder="-" value="{{$header->BNAMA}}" readonly>
                                </div>
        
                            </div>
							
							<hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
										<th width="100px">No.</th>
                                        <th width="200px">
								        	<label style="color:red;font-size:20px">* </label>									
                                            <label for="BACNO" class="form-label">Faktur#</label></th>
                                        <th width="200px">Total</th>
                                        <th width="200px">Bayar</th>
                                        <th width="200px">Sisa</th>										
                                        <th width="600px">Ket</th>
                                        <th></th>										
                                    </tr>
                                </thead>
        
								<tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $hutd)
                                    								
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]{{$no}}" id="NO_ID" type="text" value="{{$hutd->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="{{$hutd->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
                                        <td>
                                            <input name="NO_FAKTUR[]" id="NO_FAKTUR{{$no}}" type="text" class="form-control NO_FAKTUR" value="{{$hutd->NO_FAKTUR}}" readonly required>
                                        </td>

										<td>
										    <input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="{{$hutd->TOTAL}}" id="TOTAL{{$no}}" type="text" style="text-align: right"  class="form-control TOTAL text-primary" >
										</td>                         
										
										<td>
										    <input name="BAYAR[]" onclick="select()" onkeyup="hitung()" value="{{$hutd->BAYAR}}" id="BAYAR{{$no}}" type="text" style="text-align: right"  class="form-control BAYAR text-primary">
										</td>
										
										<td>
										    <input name="SISA[]" onclick="select()" onkeyup="hitung()" value="{{$hutd->SISA}}" id="SISA{{$no}}" type="text" style="text-align: right"  class="form-control SISA text-primary" readonly>
										</td>
                                        
										<td>
                                            <input name="KET[]" id="KET0" type="text" class="form-control KET" value="{{$hutd->KET}}" required>
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

								<tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input class="form-control TBAYAR  text-primary font-weight-bold" style="text-align: right"  id="TBAYAR" name="TBAYAR" value="{{$header->BAYAR}}" value="0" readonly></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>
							
                            <div class="col-md-2 row">
                                <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
                            </div>
							
							
							
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


	
	<div class="modal fade" id="browsePOModal" tabindex="-1" role="dialog" aria-labelledby="browsePOModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePOModalLabel">Cari PO#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bpo">
				<thead>
					<tr>
						<th>PO#</th>
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
	
	


	<div class="modal fade" id="browseAccount1Modal" tabindex="-1" role="dialog" aria-labelledby="browseAccount1ModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAccount1ModalLabel">Cari Account</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-baccount1">
				<thead>
					<tr>
						<th>Account#</th>
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




	<div class="modal fade" id="browseBeliModal" tabindex="-1" role="dialog" aria-labelledby="browseBeliModalLabel" aria-hidden="true">
	  <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseBeliModalLabel">Cari Beli#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bbeli">
				<thead>
					<tr>
						<th>Beli#</th>
						<th>Kode</th>
						<th>-</th>
						<th>Total</th>
						<th>Bayar</th>
						<th>Sisa</th>						
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
    var target;
	var idrow = 1;
	var baris = 1;
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
		
	idrow=<?=$no?>;
	baris=<?=$no?>;
		$("#TBAYAR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BAYAR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SISA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}	
		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
			
		});

		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
		});
		
		
		var dTableBPO;
		loadDataBPO = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('pon/browseuang')}}',
				data: {
					'GOL': 'Y',
				},
				success: function( response )
				{
					resp = response;
					if(dTableBPO){
						dTableBPO.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBPO.row.add([
							'<a href="javascript:void(0);" onclick="choosePO(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODES+'\', \''+resp[i].NAMAS+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODES,
							resp[i].NAMAS
							
						]);
					}
					dTableBPO.draw();
				}
			});
		}
		
		dTableBPO = $("#table-bpo").DataTable({
			
		});
		
		browsePO = function(){
			 loadDataBPO();
			$("#browsePOModal").modal("show");
		}
		
		choosePO = function(NO_BUKTI,KODES,NAMAS){
			$("#NO_PO").val(NO_BUKTI);
			$("#KODES").val(KODES);
			$("#NAMAS").val(NAMAS);		
			$("#browsePOModal").modal("hide");
		}
		
		$("#NO_PO").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browsePO();
			}
		}); 
		

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		var dTableBAccount1;
		loadDataBAccount1 = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browsebank')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBAccount1){
						dTableBAccount1.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAccount1.row.add([
							'<a href="javascript:void(0);" onclick="chooseAccount1(\''+resp[i].ACNO+'\',\''+resp[i].NAMA+'\')">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAccount1.draw();
				}
			});
		}
		
		dTableBAccount1 = $("#table-baccount1").DataTable({
			
		});
		
		browseAccount1 = function(){
			loadDataBAccount1();
			$("#browseAccount1Modal").modal("show");
		}
		
		chooseAccount1 = function(acno,nama){
			$("#BACNO").val(acno);
			$("#BNAMA").val(nama);
			$("#browseAccount1Modal").modal("hide");
		}
		
		$("#BACNO").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount1();
			}
		}); 
		
		
		
		
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var dTableBBeli;
		var rowidBeli;

		loadDataBBeli = function(){
			var dataDetail = $("input[name='NO_FAKTUR[]']").map(function() {
				var isi = "''";
				if ($(this).val()) {
					isi = "'" + $(this).val() + "'";
				}
				return isi;
			}).get();
	
			
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('belin/browse')}}",
				data: {
					'NO_PO': $("#NO_PO").val(),
					listDetail: dataDetail, 
				},
				success: function( response )
				{
					resp = response;
					if(dTableBBeli){
						dTableBBeli.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBeli.row.add([
							'<a href="javascript:void(0);" onclick="chooseBeli(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODES+'\',   \''+resp[i].NAMAS+'\',  \''+resp[i].TOTAL+'\' ,  \''+resp[i].BAYAR+'\', \''+resp[i].SISA+'\'   )">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODES,
							resp[i].NAMAS,
							Intl.NumberFormat('en-US').format(resp[i].TOTAL),
							Intl.NumberFormat('en-US').format(resp[i].BAYAR),
							Intl.NumberFormat('en-US').format(resp[i].SISA)							
						]);
					}
					dTableBBeli.draw();
				}
			});
		}
		
		dTableBBeli = $("#table-bbeli").DataTable({
			
			columnDefs: [
				{
					targets:  [3,4,5],
					className: 'dt-body-right'
				}
			],
		});
		
		browseBeli = function(rid){
			rowidBeli = rid;
			loadDataBBeli();
			$("#browseBeliModal").modal("show");
		}
		
		chooseBeli = function(NO_BUKTI,KODES, NAMAS, TOTAL, BAYAR, SISA){
			$("#NO_FAKTUR"+rowidBeli).val(NO_BUKTI);
			$("#TOTAL"+rowidBeli).val(SISA);
			$("#BAYAR"+rowidBeli).val(SISA);			
			$("#browseBeliModal").modal("hide");
			hitung();
		}
		
		
		$("#NO_FAKTUR0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBeli(0);
			}
		}); 
		
		
		
    });



	function cekDetail(){
		for($i=0 ; $i<idrow ; $i++)
		{
			var BAYARX = parseFloat($('#BAYAR'+$i).val().replace(/,/g, ''));
			var TOTALX = parseFloat($('#TOTAL'+$i).val().replace(/,/g, ''));
			var FAKTURX = $('#NO_FAKTUR'+$i).val();
			if(BAYARX>TOTALX){
				return FAKTURX;
			};
		}
	}



 function simpan() {
	 
		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		var TBAYARX = parseFloat($('#TBAYAR').val().replace(/,/g, ''));
		
        var check = '0';
		
			if (cekDetail())
			{	
			    check = '1';
				alert("Faktur# "+cekDetail()+" lebih bayar! ")
			}
		
			if ( $('#NO_PO').val()=='' ) 
            {			
			    check = '1';
				alert("PO# Harus diisi.");
			}

			if ( $('#BACNO').val()=='' ) 
            		{				
			    check = '1';
				alert("Type Cash Bank Harus Diisi.");
			}
			
		    if ( TBAYARX < 0 ) 
            {			
			    check = '1';
				alert("Total Bayar Negatif.");
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
		
	

    function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		 hitung();
	}

     function hitung() {
		var TBAYAR = 0;


		$(".BAYAR").each(function() {
			
			let z = $(this).closest('tr');
			var TOTALX = parseFloat(z.find('.TOTAL').val().replace(/,/g, ''));
			var BAYARX = parseFloat(z.find('.BAYAR').val().replace(/,/g, ''));
		
            var SISAX  = TOTALX - BAYARX;
			z.find('.SISA').val(SISAX);
			
		    z.find('.SISA').autoNumeric('update');
		
            TBAYAR +=BAYARX;				
		
		});
		
		
		if(isNaN(TBAYAR)) TBAYAR = 0;

		$('#TBAYAR').val(numberWithCommas(TBAYAR));		
		$("#TBAYAR").autoNumeric('update');
		
	}
	
	
    function tambah() {

        var x = document.getElementById('datatable').insertRow(baris + 1);
        var td1 = x.insertCell(0);
        var td2 = x.insertCell(1);
        var td3 = x.insertCell(2);
        var td4 = x.insertCell(3);
        var td5 = x.insertCell(4);
        var td6 = x.insertCell(5);
        var td7 = x.insertCell(6);
        //var td6 = x.insertCell(5);


        td1.innerHTML = "<input name='NO_ID[]' id='NO_ID"+idrow+"' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
        //<input name="LAT[]" id="LAT0" type="text" class="form-control LAT  " required>
        td2.innerHTML = "<input name='NO_FAKTUR[]'   id=NO_FAKTUR" + idrow + " type='text' class='form-control NO_FAKTUR' readonly required>";
        td3.innerHTML = "<input name='TOTAL[]'   id=TOTAL" + idrow + " type='text' class='form-control  TOTAL' style='text-align: right' value='0' readonly required>";
        td4.innerHTML = "<input name='BAYAR[]'   id=BAYAR" + idrow + " type='text' class='form-control  BAYAR' onclick='select()' onkeyup='hitung()' style='text-align: right' value='0' required>";
        td5.innerHTML = "<input name='SISA[]'   id=SISA" + idrow + " type='text' class='form-control  SISA' style='text-align: right' value='0' readonly required>";
        td6.innerHTML = "<input name='KET[]'   id=KET" + idrow + " type='text' class='form-control KET'  required>";
        td7.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		
         jumlahdata = 100;
         for (i = 0; i <= jumlahdata; i++) {
             $("#TOTAL" + i.toString()).autoNumeric('init', {
                 aSign: '<?php echo ''; ?>',
                 vMin: '-999999999.99'
             });

             $("#BAYAR" + i.toString()).autoNumeric('init', {
                 aSign: '<?php echo ''; ?>',
                 vMin: '-999999999.99'
             });
			 
             $("#SISA" + i.toString()).autoNumeric('init', {
                 aSign: '<?php echo ''; ?>',
                 vMin: '-999999999.99'
             });			 


         }

        
		$("#NO_FAKTUR"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBeli(eval($(this).data("rowid")));
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

