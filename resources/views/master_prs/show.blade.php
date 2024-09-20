@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Lihat Data Proses</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('prs')}}">Master Proses</a></li>
                <li class="breadcrumb-item active">{{$KD_PRS}}</li>
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
                                    <label for="KD_PRS" class="form-label">Kode Proses</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control KD_PRS" id="KD_PRS" name="KD_PRS"
                                    placeholder="Masukkan Kode Proses" value="{{$KD_PRS}}" readonly>
                                </div>

								<div class="col-md-4">
                                    <input type="checkbox" class="form-check-input" id="AKHIR"name="AKHIR"
                                    placeholder="Masukkan Akhir/Tidak" value="1" {{ ($AKHIR == 1) ? 'checked' : '' }} readonly>
									<label for="AKHIR">Akhir</label>
                                </div>
                            </div>
 
						<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NA_PRS" class="form-label">Nama Proses</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_PRS" id="NA_PRS" name="NA_PRS"
                                    placeholder="Masukkan Nama Proses" value="{{$NA_PRS}}" readonly>
                                </div> 
							</div> 	
							
							
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

