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
			
<!--// ganti 1 -->
			
            <h1 class="m-0">Tambah Data Proses Baru</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

<!--// ganti 2 -->
                <li class="breadcrumb-item"><a href="/prs">Master Proses</a></li>
                <li class="breadcrumb-item active">Add</li>
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
<!--// ganti 3 -->
                                    <label for="KD_PRS" class="form-label">Kode Proses</label>
                                </div>
                                <div class="col-md-4">
<!--// ganti 4 -->
                                    <input type="text" class="form-control KD_PRS" id="KD_PRS" name="KD_PRS" placeholder="Masukkan Kode Proses">
                                </div>

								<div class="col-md-6">
									<input type="checkbox" class="form-check-input" id="AKHIR" name="AKHIR" value="1" checked>
									<label for="AKHIR">Akhir</label>
										
								</div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-2">
                                    <label for="NA_PRS" class="form-label">Nama Proses</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NA_PRS" id="NA_PRS" name="NA_PRS" placeholder="Masukkan Nama Proses">
                                </div>
							</div>
								
								
                            </div>
        
							
                            
							
        
                            <hr style="margin-top: 30px; margin-buttom: 30px">
                            
                            
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
		var TJUMLAH = 0;


		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});
		
		if(isNaN(TJUMLAH)) TJUMLAH = 0;

		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));
		$("#TJUMLAH").autoNumeric('update');

	}

    function tambah() {

       
     }
</script>
@endsection

