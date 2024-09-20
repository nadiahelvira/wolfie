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
               <h1 class="m-0">Edit Surat Jalan {{$header->NO_BUKTI}}</h1>	
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/surats')}}">Surat Jalan</a></li>
                <li class="breadcrumb-item active">Edit {{$header->NO_BUKTI}}</li>
            </ol>
            </div>
        </div>
        </div>
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('/surats/update/'.$header->NO_ID)}}" id="entri" method="POST">
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
								<div class="col-md-2" align="left">
                                    <label for="NO_BUKTI" class="form-label">No Bukti</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2" align="right">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="KODEC" class="form-label">Customer</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Kode Customer" value="{{$header->KODEC}}" readonly>
                                </div>
                            </div>
							
							<div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="Nama Customer" value="{{$header->NAMAC}}" readonly>
                                </div>
                            </div>
							<div class="form-group row">
                                <div class="col-md-2" align="left">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="TRUCK" class="form-label">Truck</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control TRUCK" id="TRUCK" name="TRUCK" placeholder="Masukkan Truck" value="{{$header->TRUCK}}">
                                </div>
                                <div class="col-md-1" align="right">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="SOPIR" class="form-label">Sopir</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SOPIR" id="SOPIR" name="SOPIR" placeholder="Sopir" value="{{$header->SOPIR}}">
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" placeholder="Alamat Customer" value="{{$header->ALAMAT}}" readonly>
                                </div>
                            </div>
                            
							<div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label class="form-label">Via</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control VIA" id="VIA" name="VIA" placeholder="Via" value="{{$header->VIA}}">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" placeholder="Kota Customer" value="{{$header->KOTA}}" readonly>
                                </div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-2" align="left">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Notes" value="{{$header->NOTES}}">
                                </div>
                            </div>
                           
							<table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BRG" class="form-label">SO#</label></th>
                                        <th style="text-align: center;">Kode</th>
                                        <th style="text-align: center;">Uraian</th>
                                        <th style="text-align: center;">Satuan</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Harga</th>
										<th style="text-align: center;">Total</th>
										<th style="text-align: center;">Ket</th>
										<th style="text-align: center;"></th>
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php $no=0 ?>
								@foreach ($detail as $suratsd)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$suratsd->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" value="{{$suratsd->REC}}" readonly>
											<input name="NO_TERIMA[]" id="NO_TERIMA{{$no}}" type="text" class="form-control NO_TERIMA" value="{{$suratsd->NO_TERIMA}}" readonly hidden>
											<input name="MERK[]" id="MERK{{$no}}" type="text" class="form-control MERK" value="{{$suratsd->MERK}}" readonly hidden>
											<input name="NO_SERI[]" id="NO_SERI{{$no}}" type="text" class="form-control NO_SERI" value="{{$suratsd->NO_SERI}}" readonly hidden>
											<input name="TYP[]" id="TYP{{$no}}" type="text" class="form-control TYP" readonly hidden>
											<input name="ID_SOD[]" id="ID_SOD{{$no}}" type="text" class="form-control ID_SOD" value="{{$suratsd->ID_SOD}}" readonly hidden>
                                        </td>
                                        <td>
                                            <input name="NO_SO[]" data-rowid={{$no}} id="NO_SO{{$no}}" type="text" class="form-control NO_SO" placeholder="No SO" value="{{$suratsd->NO_SO}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="KD_BRG[]"  id="KD_BRG{{$no}}" type="text" class="form-control KD_BRG" placeholder="Barang#" value="{{$suratsd->KD_BRG}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BRG[]" id="NA_BRG{{$no}}" type="text" class="form-control NA_BRG" placeholder="Nama" value="{{$suratsd->NA_BRG}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" class="form-control SATUAN" placeholder="Satuan" value="{{$suratsd->SATUAN}}" readonly required>
                                        </td>
										<td>
											<input name="QTY[]" onkeyup="hitung()" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" value="{{$suratsd->QTY}}">
										</td>                         
										<td>
											<input name="HARGA[]" onkeyup="hitung()" id="HARGA{{$no}}" type="text" style="text-align: right"  class="form-control HARGA text-primary" value="{{$suratsd->HARGA}}">
										</td>
										<td>
											<input name="TOTAL[]" onkeyup="hitung()" id="TOTAL{{$no}}" type="text" style="text-align: right"  class="form-control TOTAL text-primary" value="{{$suratsd->TOTAL}}" readonly>
										</td>
										<td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" placeholder="Ket" value="{{$suratsd->KET}}" required>
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
                                    <td><input class="form-control TQTY  text-primary font-weight-bold" style="text-align: right"  id="TQTY" name="TQTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="{{$header->TOTAL}}" readonly></td>
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

	<div class="modal fade" id="browseCustModal" tabindex="-1" role="dialog" aria-labelledby="browseCustModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustModalLabel">Cari Customer</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-customer">
				<thead>
					<tr>
						<th>Kode</th>
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
	
	<div class="modal fade" id="browseSoModal" tabindex="-1" role="dialog" aria-labelledby="browseSoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustModalLabel">Cari Sales Order</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-so">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<th>No Terima</th>
						<th>Customer</th>
						<th>Kode</th>
						<th>Barang</th>
						<th>Satuan</th>
						<th>Seri#</th>
						<th>Ket</th>
						<th>Qty</th>
						<th>Kirim</th>
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
		$("#TQTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
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
		
		
///////////////////////////////////////////////////////////////////////
 		var dTableCustomer;
		loadDataCustomer = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('surats/browseCust')}}",
				success: function( resp )
				{
					if(dTableCustomer){
						dTableCustomer.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableCustomer.row.add([
							'<a href="javascript:void(0);" onclick="chooseCustomer(\''+resp[i].KODEC+'\',\''+resp[i].NAMAC+'\',\''+resp[i].ALAMAT+'\',\''+resp[i].KOTA+'\')">'+resp[i].KODEC+'</a>',
							resp[i].NAMAC,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableCustomer.draw();
				}
			});
		}
		
		dTableCustomer = $("#table-customer").DataTable({
			
		});
		
		browseCust = function(){
			loadDataCustomer();
			$("#browseCustModal").modal("show");
		}
		
		chooseCustomer = function(kodec,namac,alamat,kota){
			$("#KODEC").val(kodec);
			$("#NAMAC").val(namac);
			$("#ALAMAT").val(alamat);
			$("#KOTA").val(kota);
			$("#browseCustModal").modal("hide");
		}
		
		$("#KODEC").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseCust();
			}
		}); 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var dTableSo;
		var rowidSo;
		loadDataSo = function(){
			var dataDetail = $("input[name='NO_SO[]']").map(function() {
				var isi = "''";
				if ($(this).val()) {
					isi = "'" + $(this).val() + "'";
				}
				return isi;
			}).get();
			var dataDetailBrg = $("input[name='KD_BRG[]']").map(function() {
				var isi = "''";
				if ($(this).val()) {
					isi = "'" + $(this).val() + "'";
				}
				return isi;
			}).get();

			$.ajax(
			{
				type: 'GET',    
				url: "{{url('surats/browseSo')}}",
				data: {
					kodec: $("#KODEC").val(),
					listDetailSO: dataDetailSO, 
					listDetailBrg: dataDetailBrg, 
				},
				success: function( resp )
				{
					if(dTableSo){
						dTableSo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableSo.row.add([
							'<a href="javascript:void(0);" onclick="chooseSo(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].NO_TERIMA+'\',  \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\',  \''+resp[i].SATUAN+'\',  \''+resp[i].SISA+'\',  \''+resp[i].KET+'\',  \''+resp[i].MERK+'\',  \''+resp[i].NO_SERI+'\',  \''+resp[i].TYP+'\',  \''+resp[i].NO_ID+'\',  \''+resp[i].HARGA+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].TGL,
							resp[i].NO_TERIMA,
							resp[i].NAMAC,
							resp[i].KD_BRG,
							resp[i].NA_BRG,
							resp[i].SATUAN,
							resp[i].NO_SERI,
							resp[i].KET,
							resp[i].SISA,
							resp[i].SISA!=0 ? resp[i].SISA : 0,
							resp[i].SISA!=0 ? 0 : resp[i].SISA,
						]);
					}
					dTableSo.draw();
				}
			});
		}
		
		dTableSo = $("#table-so").DataTable({
            columnDefs: 
            [
                {
                    className: "dt-right", 
                    targets: [9,10,11],
                },		
                {
                  targets: 1,
                  render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' ),
                }
            ],
		});
		
		browseSo = function(rid){
			rowidSo = rid;
			loadDataSo();
			$("#browseSoModal").modal("show");
		}
		
		chooseSo = function(NO_BUKTI,NO_TERIMA,KD_BRG,NA_BRG,SATUAN,QTY,KET,MERK,NO_SERI,TYP,NO_ID,HARGA){
			$("#NO_SO"+rowidSo).val(NO_BUKTI);
			$("#NO_TERIMA"+rowidSo).val(NO_TERIMA);
			$("#KD_BRG"+rowidSo).val(KD_BRG);
			$("#NA_BRG"+rowidSo).val(NA_BRG);
			$("#SATUAN"+rowidSo).val(SATUAN);
			$("#QTY"+rowidSo).val(QTY!=0 ? QTY : 0);
			$("#KET"+rowidSo).val(KET);
			$("#MERK"+rowidSo).val(MERK);
			$("#NO_SERI"+rowidSo).val(NO_SERI);
			$("#TYP"+rowidSo).val(TYP);
			$("#ID_SOD"+rowidSo).val(NO_ID);
			$("#HARGA"+rowidSo).val(HARGA);
			$("#browseSoModal").modal("hide");
			hitung();
		}
		
		$("#NO_SO0").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseSo(0);
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
		
		$(".NO_SO").each(function() {
			var noso = $(this).val();
			if(noso=='')
			{
				var val = $(this).parents("tr").remove();
				baris--;
				nomor();
			}
		});

		if ( $('#KODEC').val()=='' ) 
		{			
			check = '1';
			alert("No Customer Harus diisi.");
		}
		if ( $('#TRUCK').val()=='' ) 
		{			
			check = '1';
			alert("Truk Harus diisi.");
		}
		if ( $('#SOPIR').val()=='' ) 
		{			
			check = '1';
			alert("Sopir Harus diisi.");
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
		var TQTY = 0;
		var TTOTAL = 0;

		$(".QTY").each(function() {
			let z = $(this).closest('tr');
			var QTYX = parseFloat($(this).val().replace(/,/g, ''));
			var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
		
            var TOTALX = HARGAX * QTYX;
			z.find('.TOTAL').val(TOTALX);
		    z.find('.TOTAL').autoNumeric('update');
		
            TQTY += QTYX;	
            TTOTAL += TOTALX;	
		});
		

		if(isNaN(TQTY)) TQTY = 0;
		if(isNaN(TTOTAL)) TTOTAL = 0;

		$('#TQTY').val(numberWithCommas(TQTY));		
		$('#TTOTAL').val(numberWithCommas(TTOTAL));		

		$("#TQTY").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
	}


		$(".NO_SO").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseSo(eval($(this).data("rowid")));
			}
		});
		
		
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
        var td10 = x.insertCell(9);

        td1.innerHTML = "<input name='NO_ID[]' id='NO_ID"+idrow+"' type='hidden' class='form-control NO_ID' value='new' readonly> <input name='REC[]' id='REC" + idrow + "' type='text' class='REC form-control '  onkeypress='return tabE(this,event)' readonly> <input name='NO_TERIMA[]' id='NO_TERIMA" + idrow + "' type='text' class='form-control NO_TERIMA' readonly hidden> <input name='MERK[]' id='MERK" + idrow + "' type='text' class='form-control MERK' readonly hidden> <input name='NO_SERI[]' id='NO_SERI" + idrow + "' type='text' class='form-control NO_SERI' readonly hidden> <input name='TYP[]' id='TYP" + idrow + "' type='text' class='form-control TYP' readonly hidden> <input name='ID_SOD[]' id='ID_SOD" + idrow + "' type='text' class='form-control ID_SOD' readonly hidden>";
        td2.innerHTML = "<input name='NO_SO[]' data-rowid='"+idrow+"' id='NO_SO" + idrow + "' type='text' class='form-control NO_SO' placeholder='No SO' readonly required>";
        td3.innerHTML = "<input name='KD_BRG[]' data-rowid='"+idrow+"' id='KD_BRG" + idrow + "' type='text' class='form-control KD_BRG' placeholder='Barang#' readonly required>";
        td4.innerHTML = "<input name='NA_BRG[]' id='NA_BRG" + idrow + "' type='text' class='form-control  NA_BRG' placeholder='Nama' required readonly>";
        td5.innerHTML = "<input name='SATUAN[]' id='SATUAN" + idrow + "' type='text' class='form-control  SATUAN' placeholder='Satuan' required readonly>";
		td6.innerHTML = "<input name='QTY[]' onkeyup='hitung()' value='0' id='QTY" + idrow + "' type='text' style='text-align: right' class='form-control QTY  text-primary' required>";
		td7.innerHTML = "<input name='HARGA[]' onkeyup='hitung()' value='0' id='HARGA" + idrow + "' type='text' style='text-align: right' class='form-control HARGA  text-primary' required>";
 		td8.innerHTML = "<input name='TOTAL[]' onkeyup='hitung()' value='0' id='TOTAL" + idrow + "' type='text' style='text-align: right' class='form-control TOTAL text-primary' required readonly>";
        td9.innerHTML = "<input name='KET[]' id='KET" + idrow + "' type='text' class='form-control KET' placeholder='Ket' required>";
		td10.innerHTML = "<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$("#NO_SO"+idrow).keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseSo(eval($(this).data("rowid")));
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

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>
@endsection

