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
               <h1 class="m-0">Edit Terima {{$JUDUL}} {{$header->NO_BUKTI}}</h1>	
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/terima?JNSHP=')}}{{$header->FLAG}}">Transaksi Terima {{$JUDUL}}</a></li>
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
                    <form action="{{url('/terima/update/'.$header->NO_ID)}}" id="entri" method="POST">
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
								<div class="col-md-2" align="right">
                                    <label for="NO_BUKTI" class="form-label">No Bukti</label>
                                </div>
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
									<label style="cursor: pointer; font-size: 20px;">
										<input type="checkbox" id="FIN" name="FIN" value="1" {{ ($header->FIN == 1) ? 'checked' : '' }}> Finish
									</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
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
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_PAKAI" id="NO_PAKAI" name="NO_PAKAI" placeholder="No Pemakaian" value="{{$header->NO_PAKAI}}" readonly>
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
                                <div class="col-md-2" align="right">
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
                                <div class="col-md-2" align="right">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG" placeholder="Nama Barang" value="{{$header->NA_BRG}}" readonly>
                                </div>
                            </div>
							
							@if ($header->FLAG == 'HW')
                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Bahan</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BHN_H" id="KD_BHN_H" name="KD_BHN_H" placeholder="Bahan#" value="{{$header->KD_BHN}}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control NA_BHN_H" id="NA_BHN_H" name="NA_BHN_H" placeholder="Nama Bahan" value="{{$header->NA_BHN}}" readonly>
                                </div>
                            </div>
                    		@endif

                            <div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label class="form-label">Qty</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control QTYH" id="QTYH" name="QTYH" {{ ($header->FLAG == "HP") ? 'readonly value='.$header->QTY : 'value='.$header->QTY_BHN }}>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-2" align="right">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes" value="{{$header->NOTES}}">
                                </div>
                            </div>
                            
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
								@foreach ($detail as $terimad)	
                                    <tr>
                                        <td>
											<input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$terimad->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											<input name="REC[]" id="REC{{$no}}" type="text" class="form-control REC" onkeypress="return tabE(this,event)" value="{{$terimad->REC}}" style="text-align: center;" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN{{$no}}" type="text" class="form-control KD_BHN" placeholder="Bahan#" value="{{$terimad->KD_BHN}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" class="form-control NA_BHN" value="{{$terimad->NA_BHN}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" class="form-control SATUAN" placeholder="Satuan" value="{{$terimad->SATUAN}}" readonly required>
                                        </td>   
										<td>
											<input name="QTY[]" onkeyup="hitung()" value="{{$terimad->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly>
										</td>   
										<td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" placeholder="Ket" value="{{$terimad->KET}}" required>
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
                            <button type="button" onclick="simpan()"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
                            <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
	

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
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

	var idrow = 1;
	var baris = 1;
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).ready(function() {
		idrow=<?php echo $no; ?>;
		baris=<?php echo $no; ?>;
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
		
//////////////////////////////////////////////////////////////////////////////////////////////////////	
 		var dTablePakai;
		loadDataPakai = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('terima/browsePakai')}}",
				data: {
					flag: "{{$header->FLAG}}",
				},
				success: function( response )
				{
					resp = response;
					if(dTablePakai){
						dTablePakai.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTablePakai.row.add([
							'<a href="javascript:void(0);" onclick="choosePakai(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\',  \''+resp[i].KD_PRS+'\', \''+resp[i].NA_PRS+'\', \''+resp[i].NO_PRS+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',  \''+resp[i].KD_BHN+'\',  \''+resp[i].NA_BHN+'\',  \''+resp[i].NO_SO+'\',  \''+resp[i].NO_FO+'\',  \''+resp[i].NO_ORDER+'\',  \''+resp[i].QTY_OUT+'\',  \''+resp[i].NOTES+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].NO_ORDER,
							resp[i].NO_SO,
							resp[i].NO_FO,
							resp[i].KD_PRS,
							resp[i].NA_PRS,
							resp[i].NO_PRS,
							@if ($header->FLAG == 'HP')
								resp[i].NA_BRG,
                    		@endif
							@if ($header->FLAG == 'HW')
								resp[i].NA_BHN,
                    		@endif
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
		
		choosePakai = function(NO_BUKTI, KODEC, NAMAC, KD_PRS, NA_PRS, NO_PRS, SATUAN, KD_BRG, NA_BRG, KD_BHN, NA_BHN, NO_SO, NO_FO, NO_ORDER, QTY_OUT, NOTES){
			$("#NO_PAKAI").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#KD_PRSH").val(KD_PRS);
			$("#NA_PRSH").val(NA_PRS);			
			$("#NO_PRS").val(NO_PRS);
			$("#SATUANH").val(SATUAN);	
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);	
			@if ($header->FLAG == 'HW')
				$("#KD_BHN_H").val(KD_BHN);
				$("#NA_BHN_H").val(NA_BHN);
			@endif			
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
                                    <td><input name='KET[]' id=KET${i} value="${resp[i].KET}" type='text' class='form-control  KET' required></td>
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
		if ( tgl.substring(3,5) != bulanPer ) 
		{
			check = '1';
			alert("Bulan ("+tgl+") tidak sama dengan Periode");
		}	
		if ( tgl.substring(tgl.length-4) != tahunPer )
		{
			check = '1';
			alert("Tahun ("+tgl+") tidak sama dengan Periode");
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
			var QTY = parseFloat($(this).val().replace(/,/g, ''));
		
            TTOTAL_QTY +=QTY;	
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

        td1.innerHTML = "<input name='NO_ID[]' id='NO_ID"+idrow+"' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control '  onkeypress='return tabE(this,event)' style='text-align: center;' readonly>";
        td2.innerHTML = "<input name='KD_BHN[]' data-rowid='"+idrow+"' id=KD_BHN" + idrow + " type='text' class='form-control KD_BHN' placeholder='Bahan#' required readonly>";
        td3.innerHTML = "<input name='NA_BHN[]' id=NA_BHN" + idrow + " type='text' class='form-control  NA_BHN' required readonly>";
        td4.innerHTML = "<input name='SATUAN[]' id=SATUAN" + idrow + " type='text' class='form-control  SATUAN' placeholder='Satuan' required readonly>";
		td5.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' style='text-align: right' class='form-control QTY  text-primary' placeholder='Qty' readonly required>";
        td6.innerHTML = "<input name='KET[]' id=KET" + idrow + " type='text' class='form-control  KET' placeholder='Ket' required>";
		td7.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) 
		{
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		idrow++;
		baris++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
     }
</script>

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection
