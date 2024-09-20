@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Lihat Purchase Order Non</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/pon')}}">Transaksi Purchase Order Non</a></li>
                <li class="breadcrumb-item active">{{$header->NO_PO}}</li>
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
                                    <label for="NO_BUKTI" class="form-label">PO</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti" value="{{$header->NO_BUKTI}}" disabled>
                                </div>
							</div>
							
                            <div class="form-group row">
							
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control TGL" id="TGL "name="TGL"
                                    placeholder="Masukkan Tgl" value="{{date('d-m-Y',strtotime($header->TGL))}}"  disabled>
                                </div>
                            </div>
   

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="JTEMPO" class="form-label">JTempo#</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control JTEMPO" id="JTEMPO" name="JTEMPO"
                                    placeholder="Masukkan Jtempo" value="{{date('d-m-Y',strtotime($header->JTEMPO))}}" disabled>
                                </div>
        
                            </div>
							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODES" class="form-label">Suplier#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODES" id="KODES" name="KODES" placeholder="Masukkan Supplier" value="{{$header->KODES}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAS" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS" placeholder="NAMAS" value="{{$header->NAMAS}}" readonly>
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
                                    <input type="text" class="form-control KOTA" id="KOTA" name="KOTA" placeholder="Masukkan Kota" value="{{$header->KOTA}}" readonly>
                                </div>
                            </div>

        
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="TERM" class="form-label">Term</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TERM" id="TERM" name="TERM" placeholder="Masukkan Term" value="{{$header->TERM}}" readonly>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="VIA" class="form-label">Via</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control VIA" id="VIA" name="VIA" placeholder="Masukkan VIA" value="{{$header->VIA}}" readonly>
                                </div>
                            </div>
							
							
							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" placeholder="Masukkan Notes" value="{{$header->NOTES}}" readonly>
                                </div>
        
                            </div>
							
                            
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">Kode</th>
                                        <th style="text-align: center;">Nama Bahan</th>
                                        <th style="text-align: center;">Stn</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Harga</th>
										<th style="text-align: center;">Total</th>
										<th style="text-align: center;">Ket</th>
										
                                    </tr>
									
                                </thead>
								
                                <tbody>
								
								<?php $no=0 ?>
								@foreach ($detail as $pod)
                                    								
                                    <tr>
                                        <td>
                                            <input name="REC[]" id="REC0" type="text" value="{{$pod->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly>
                                        </td>
                                        <td>
                                            <input name="KD_BHN[]" id="KD_BHN0" type="text" class="form-control KD_BHN" value="{{$pod->KD_BHN}}" readonly>
                                        </td>
                                        <td>
                                            <input name="NA_BHN[]" id="NA_BHN0" type="text" class="form-control NA_BHN" value="{{$pod->NA_BHN}}" readonly >
                                        </td>
                                        <td>
                                            <input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN" value="{{$pod->SATUAN}}" required readonly>
                                        </td>
										
										<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="{{$pod->QTY}}" id="QTY0" type="text" style="text-align: right"  class="form-control QTY text-primary" value="{{$pod->QTY}}" readonly></td> ></td>                        
										<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" value="{{$pod->HARGA}}" id="HARGA0" type="text" style="text-align: right"  class="form-control HARGA text-primary" value="{{$pod->HARGA}}" readonly></td>
										<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="{{$pod->TOTAL}}" id="TOTAL0" type="text" style="text-align: right"  class="form-control TOTAL text-primary" value="{{$pod->TOTAL}}" readonly></td>
                                        
										<td>
                                            <input name="KET[]" id="KET0" type="text" class="form-control KET" value="{{$pod->KET}}" required readonly>
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
		
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		

		
//////////////////////////////////////////////////////////////////

	}




   
</script>


<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script>

@endsection