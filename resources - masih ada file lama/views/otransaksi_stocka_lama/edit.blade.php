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
               <h1 class="m-0">Edit Koreksi Stock {{$header->NO_BUKTI}}</h1>	   
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/stocka')}}">Koreksi Stock</a></li>
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
                    <form action="{{url('/stocka/update/'.$header->NO_ID)}}" method="POST">
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
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
								
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{$header->TGL}}">
								
                                </div>
                            </div>
    

 							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}">
                                </div>
        
                            </div>
							
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BHN" class="form-label">Kode Bahan</label></th>
                                        <th style="text-align: center;">Nama Bahan</th>
                                        <th style="text-align: center;">Stn</th>
                                        <th style="text-align: center;">Qty-Comp</th>
										<th style="text-align: center;">Qty-Real</th>
										<th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $stockad)
								
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$stockad->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="{{$stockad->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN{{$no}}" type="text" value="{{$stockad->KD_BHN}}" class="form-control KD_BHN" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" value="{{$stockad->NA_BHN}}" class="form-control NA_BHN" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" value="{{$stockad->SATUAN}}" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTYC[]" onclick="select()" onkeyup="hitung()" value="{{$stockad->QTYC}}" id="QTYC{{$no}}" type="text" style="text-align: right"  class="form-control QTYC text-primary"></td>                         
										<td><input name="QTYR[]" onclick="select()" onkeyup="hitung()" value="{{$stockad->QTYR}}" id="QTYR{{$no}}" type="text" style="text-align: right"  class="form-control QTYR text-primary"></td>
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="{{$stockad->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly></td>
                                        
										<td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" value="{{$stockad->KET}}" required>
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
                                    <td></td>
                                    <td></td> 
                                    <td></td>
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>     
                            <div class="col-md-2 row">
                                <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
                            </div>							
                        </div>

                        <div class="mt-3">
                            <button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
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
		
		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTYC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTYR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
///////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		



		
//////////////////////////////////////////////////////////////////////
		
 		var dTableBBahan;
		var rowidBahan;
		loadDataBBahan = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('bhn/browse')}}",
				success: function( response )
				{
					resp = response;
					if(dTableBBahan){
						dTableBBahan.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBBahan.row.add([
							'<a href="javascript:void(0);" onclick="chooseBahan(\''+resp[i].KD_BHN+'\',\''+resp[i].NA_BHN+'\')">'+resp[i].KD_BHN+'</a>',
							resp[i].NA_BHN,
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
		
		chooseBahan = function(KD_BHN,NA_BHN){
			$("#KD_BHN"+rowidBahan).val(KD_BHN);
			$("#NA_BHN"+rowidBahan).val(NA_BHN);
			$("#browseBahanModal").modal("hide");
		}
		
		
		$("#KD_BHN0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBahan(0);
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
		
		
			if ( $('#BACNO').val()=='' ) 
            {			
			    check = '1';
				alert("Bank Harus diisi.");
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
		var TTOTAL_QTY = 0;


		$(".QTY").each(function() {
			
			let z = $(this).closest('tr');
			var QTYRX = parseFloat(z.find('.QTYR').val().replace(/,/g, ''));
			var QTYCX = parseFloat(z.find('.QTYC').val().replace(/,/g, ''));
		
            var QTYX  = QTYRX - QTYCX;
			z.find('.QTY').val(QTYX);
			
		    z.find('.QTY').autoNumeric('update');
		
            TTOTAL_QTY +=QTYX;				
		
		});
		
		
		if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		$('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		$("#TTOTAL_QTY").autoNumeric('update');
		
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
        var td8 = x.insertCell(7); 
        var td9 = x.insertCell(8);
		//var td6 = x.insertCell(5);

        td1.innerHTML = "<input name='NO_ID[]' id='NO_ID"+idrow+"' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
        //<input name="LAT[]" id="LAT0" type="text" class="form-control LAT  " required>
        td2.innerHTML = "<input name='KD_BHN[]' data-rowid='"+idrow+"'  id=KD_BHN" + idrow + " type='text' class='form-control KD_BHN' readonly required>";
        td3.innerHTML = "<input name='NA_BHN[]'   id=NA_BHN" + idrow + " type='text' class='form-control  NA_BHN' required readonly>";
        td4.innerHTML = "<input name='SATUAN[]'   id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' readonly required>";
		td5.innerHTML = "<input name='QTYC[]' onclick='select()' onkeyup='hitung()' value='0' id=QTYC" + idrow + " type='text' style='text-align: right' class='form-control QTYC  text-primary' required>";
		td6.innerHTML = "<input name='QTYR[]' onclick='select()' onkeyup='hitung()' value='0' id=QTYR" + idrow + " type='text' style='text-align: right' class='form-control QTYR text-primary' required>";
 		td7.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY text-primary' required readonly>";
        td8.innerHTML = "<input name='KET[]'   id=KET" + idrow + " type='text' class='form-control  KET' required>";
		td9.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTYC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTYR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$("#KD_BHN"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseBahan(eval($(this).data("rowid")));
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