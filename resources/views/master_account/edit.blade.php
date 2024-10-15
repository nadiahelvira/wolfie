@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	
	
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data Account </h1>
            </div>
            <!-- /.col -->
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
				
                    <form action="{{($tipx=='new')? url('/account/store/') : url('/account/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
     
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
                                    <label for="ACNO" class="form-label">Account</label>
                                </div>
								
									<input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
									placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>								
								
								
								
                                <div class="col-md-4">
                                    <input type="text" class="form-control ACNO" id="ACNO" name="ACNO"
                                    placeholder="Masukkan Account" value="{{$header->ACNO}}" readonly>
                                </div>      
        
                                <div class="col-md-2">
                                    <label for="BNK" class="form-label">Type</label>
                                </div>
                                <div class="col-md-4">
								  <select id="BNK" class="form-control" name="BNK">
									<option value="1" {{ ($header->BNK == '1') ? 'selected' : '' }}>1-Kas</option>
									<option value="2" {{ ($header->BNK == '2') ? 'selected' : '' }}>2-Bank</option>
									<option value="" {{ ($header->BNK == '') ? 'selected' : '' }}>3-Lain</option>
								  </select>
                                </div>      
                            </div>
							
							<div class="form-group row">
									<div class="col-md-2">
										<label for="NAMA" class="form-label">Nama</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control NAMA" id="NAMA" name="NAMA" placeholder="Masukkan Nama" value="{{$header->NAMA}}">
									</div>                             
								</div>
								
							<div class="form-group row">
									<div class="col-md-2">
										<label for="POS2" class="form-label">Type</label>
									</div>
									<div class="col-md-4">
									  <select id="POS2" class="form-control" name="POS2">
										<option value="B" {{ ($header->POS2 == 'B') ? 'selected' : '' }}>B-Neraca</option>
										<option value="I" {{ ($header->POS2 == 'I') ? 'selected' : '' }}>I-Rugi Laba Berjalan</option>
										<option value="R" {{ ($header->POS2 == 'R') ? 'selected' : '' }}>R-Rugi Laba</option>
									  </select>
									</div>                             
							</div>	
								
							<div class="form-group row">
									<div class="col-md-2">
										<label style="color:red;font-size:20px">* </label>	
										<label for="KEL" class="form-label">Kelompok</label>
									</div>
									<div class="col-md-1">
										<input type="text" class="form-control KEL" id="KEL" name="KEL" placeholder="Pilih Kel" value="{{$header->KEL}}" readonly>
									</div>    
									<div class="col-md-3">
										<input type="text" class="form-control NAMA_KEL" id="NAMA_KEL" name="NAMA_KEL" placeholder="Nama Kel" value="{{$header->NAMA_KEL}}" readonly>
									</div>                              
							</div>
        							
                                   
        
                            <hr style="margin-top: 30px; margin-buttom: 30px">
                            
                           
                        </div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/account/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/account/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->ACNO )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/account/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->ACNO )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/account/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>

							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/account/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/account/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success"<i class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/account' )}}'" class="btn btn-outline-secondary">Close</button>


							</div>
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
    
    
  <div class="modal fade" id="browseKelModal" tabindex="-1" role="dialog" aria-labelledby="browseKelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseKelModalLabel">Cari Kelompok</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-stripped table-bordered" id="table-kel">
              <thead>
                  <tr>
                      <th>Kelompok</th>
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
@endsection

@section('footer-scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>

<script>
    var target;
	var idrow = 1;

    $(document).ready(function () {
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
	

			$("#POS2").select2({
               
            });
			
        	var dTableKel;
		loadDataKel = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('account/browseKel')}}",
				data: {
                    tipe: $("#POS2").val(),
				},
				success: function( resp )
				{
					if(dTableKel){
						dTableKel.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableKel.row.add([
							'<a href="javascript:void(0);" onclick="chooseKel(\''+resp[i].KEL+'\',\''+resp[i].NAMA_KEL+'\')">'+resp[i].KEL+'</a>',
							resp[i].NAMA_KEL,
						]);
					}
					dTableKel.draw();
				}
			});
		}
		
		dTableKel = $("#table-kel").DataTable({
			
		});
		
		browseKel = function(){
			loadDataKel();
			$("#browseKelModal").modal("show");
		}
		
		chooseKel = function(kel,nama){
			$("#KEL").val(kel);
			$("#NAMA_KEL").val(nama);
			$("#browseKelModal").modal("hide");
		}
		
		$("#KEL").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseKel();
			}
		}); 
    });

    function nomor() {
	}

    function tambah() {
     }
     
     var hasilCek;
	function cekAcc(acno) {
		$.ajax({
			type: "GET",
			url: "{{url('account/cekacc')}}",
            async: false,
			data: ({ ACNO: acno, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekAcc occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        //cekAcc($('#ACNO').val());
        //(hasilCek==0) ? document.getElementById("entri").submit() : alert('Account '+$('#ACNO').val()+' sudah ada!');
        document.getElementById("entri").submit()
	}
</script>
</script>
@endsection

