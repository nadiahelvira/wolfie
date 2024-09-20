@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Lihat Sales Order</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/stock')}}">Transaksi Sales Order</a></li>
                <li class="breadcrumb-item active">{{$header->NO_SO}}</li>
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
                                    <label for="NO_SO" class="form-label">SO#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO"
                                    placeholder="Masukkan SO#" value="{{$header->NO_SO}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TGL" id="TGL "name="TGL"
                                    placeholder="Masukkan tgl" value="{{$header->TGL}}" readonly>
                                </div>
                            </div>
							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODEC" class="form-label">Customer#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Masukkan Customer#" value="{{$header->KODEC}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="Nama" value="{{$header->NAMAC}}" readonly>
                                </div>
                            </div>
							
							
							 <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="ALAMAT" class="form-label">Alamat</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" placeholder="Masukkan Alamat" value="{{$header->ALAMAT}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="KOTA" class="form-label">Kota</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" placeholder="KOTA"  value="{{$header->KOTA}}" readonly>
                                </div>
                            </div>

        
                            
							
							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan NOTES" value="{{$header->NOTES}}" readonly>
                                </div>
        

                            </div>
							
						
                     
							<hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">Kode</th>
                                        <th style="text-align: center;">Nama</th>
                                        <th style="text-align: center;">Stn</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Harga</th>
										<th style="text-align: center;">Total</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $sod)
                                    <tr>
                                        <td>
                                            <input name="REC[]" id="REC0" type="text" value="{{$sod->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BRG[]" id="KD_BRG0" type="text" class="form-control KD_BRG " value="{{$sod->KD_BRG}}" required readonly>
                                        </td>
                                        <td>
                                            <input name="NA_BRG[]" id="NA_BRG0" type="text" class="form-control NA_BRG" value="{{$sod->NA_BRG}}" readonly required>
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN" value="{{$sod->SATUAN}}" required readonly>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()"  value="{{$sod->QTY}}" id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary" readonly></td>                         
										<td><input name="HARGA[]" onclick="select()" value="{{$sod->HARGA}}" id="HARGA0" type="text" style="text-align: right"  class="form-control HARGA text-primary" readonly></td>
										<td><input name="TOTAL[]" onclick="select()" value="{{$sod->TOTAL}}" id="TOTAL0" type="text" style="text-align: right"  class="form-control TOTAL text-primary" readonly></td>
                                        
										<td>
                                            <input name="KET[]" id="KET0" type="text" class="form-control KET" value="{{$sod->KET}}" readonly>
                                        </td>
										
                                    </tr>
								@endforeach
                                </tbody>
								<tfoot>
                                   <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL_QTY  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL_QTY" name="TTOTAL_QTY" value="{{$header->TTOTAL_QTY}}" readonly></td>
                                    <td></td>
                                    <td><input class="form-control TTOTAL  text-primary font-weight-bold" style="text-align: right"  id="TTOTAL" name="TTOTAL" value="{{$header->TTOTAL}}" readonly></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>     
                            						
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
	
	
	
@endsection

@section('footer-scripts')
<!-- TAMBAH 1 -->
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

	var idrow = 1;
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

// TAMBAH HITUNG
	$(document).ready(function() {

		$("#TTOTAL_QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
	
			

	});


/////////////////////////////////////////////////////////////////

</script>


<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection