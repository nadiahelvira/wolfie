@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Lihat Pembayaran Piutang</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/piu')}}">Transaksi Pembayaran Piutang</a></li>
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
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" disabled>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control TGL" id="TGL "name="TGL"
                                    placeholder="Masukkan tgl" value="{{$header->TGL}}" disabled>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="KODEC" class="form-label">Customer#</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC"
                                    placeholder="Masukkan Customer#" value="{{$header->KODEC}}" disabled>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="NAMAC" class="form-label">-</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC "name="NAMAC"
                                    placeholder="-" value="{{$header->NAMAC}}" disabled>
                                </div>
                            </div>
        
                            <div class="form-group row">

                            </div>
        
                            <hr style="margin-top: 30px; margin-buttom: 30px">
                            
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
<script>
    var target;
	var idrow = 1;

    $(document).ready(function () {
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
    });

    function nomor() {

	}

    function tambah() {

     }
</script>
@endsection

