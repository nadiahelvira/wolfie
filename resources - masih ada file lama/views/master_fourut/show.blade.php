@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Lihat Master Formula</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/fo')}}">Transaksi Master Formula</a></li>
                <li class="breadcrumb-item active">{{$header->NO_BUKTI}}</li>
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
                    <form action="store" method="POST">
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
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" disabled >
                                </div>
							</div>
        
                             <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KD_BRG" class="form-label">Kode</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG"
                                    placeholder="Masukkan Kode" value="{{$header->KD_BRG}}" disabled >
                                </div>
								
								<div class="col-md-2">
                                    <label for="NA_BRG" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG"
                                    placeholder="Masukkan Nama" value="{{$header->NA_BRG}}" disabled >
                                </div>
							</div>
    
	
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}" disabled>
                                </div>

								
								<div class="col-md-4">
                                    <input type="checkbox" class="form-check-input" id="AKTIF"name="AKTIF"
                                    placeholder="Masukkan Aktif/Tidak" value="1" {{ ($header->AKTIF == 1) ? 'checked' : '' }} readonly>
									<label for="AKTIF">Aktif</label>
                                </div>
							</div>
        
                            </div>
							
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
										<th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_PRS" class="form-label">Kode Proses</label></th>
										<th style="text-align: center;">Nama Proses</th>
                                        <th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_BHN" class="form-label">Kode Bahan</label></th>
                                        <th style="text-align: center;">Nama Bahan</th>
										<th style="text-align: center;">Satuan</th>
										<th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $fod)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]" id="NO_ID{{$no}}" type="text" value="{{$fod->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="{{$fod->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
										<td>
                                            <input name="KD_PRS[]" id="KD_PRS{{$no}}" type="text" value="{{$fod->KD_PRS}}" class="form-control KD_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_PRS[]" id="NA_PRS{{$no}}" type="text" value="{{$fod->NA_PRS}}" class="form-control NA_PRS" readonly required>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN{{$no}}" type="text" value="{{$fod->KD_BHN}}" class="form-control KD_BHN" readonly required>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" value="{{$fod->NA_BHN}}" class="form-control NA_BHN" readonly required>
                                        </td>
										 <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" value="{{$fod->SATUAN}}" class="form-control SATUAN" readonly required>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="{{$fod->QTY}}" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly></td>
                                        
										<td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" value="{{$fod->KET}}" readonly required>
                                        </td>
										
										<td>
										
                                    </tr>
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
                            							
                        </div>

                        {{-- <div class="mt-3">
                            <button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
                            <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                        </div> --}}
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

		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
		<!--	$("#QTYC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});   -->
		<!--	$("#QTYR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});   -->
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		

	});




</script>


<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection