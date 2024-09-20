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
               <h1 class="m-0">Data Suplier</h1>	
            </div>

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

                    <form action="{{($tipx=='new')? url('/sup/store/') : url('/sup/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                        @csrf
						
                        

						<ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#suppInfo" data-toggle="tab">Main</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#bankInfo" data-toggle="tab">Bank Info</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="#deliveryInfo" data-toggle="tab">Lead Delivery Time</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="#standartInfo" data-toggle="tab">Standart Kualitas</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="#nilaiInfo" data-toggle="tab">Penilaian</a>
                            </li>
                        </ul>
        
                        <div class="tab-content mt-3">
							<div id="suppInfo" class="tab-pane active">	
							
								<div class="form-group row">
									<div class="col-md-1">
										<label for="KODES" class="form-label">Kode</label>
									</div>

										<input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
										placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

										<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
											
									
									<div class="col-md-2">
										<input type="text" class="form-control KODES" id="KODES" name="KODES"
										placeholder="Masukkan Kode Suplier" value="{{$header->KODES}}" readonly>
									</div>

									<div class="col-md-1">
									</div>
									
									<div class="col-md-1">
										<input type="checkbox" class="form-check-input" id="PKP" name="PKP" value="1" {{ ($header->PKP == 1) ? 'checked' : '' }}>
										<label for="PKP">PKP</label>
									</div>					
									
									<div class="col-md-1">
										<input type="checkbox" class="form-check-input" id="AKT" name="AKT" value="1" {{ ($header->AKT == 1) ? 'checked' : '' }}>
										<label for="AKT">AKTIF</label>
									</div>	
								</div>

								<div class="form-group row">
									<div class="col-md-1">
										<label for="NAMAS" class="form-label">Nama</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control NAMAS" id="NAMAS" name="NAMAS"
										placeholder="Masukkan Nama Suplier" value="{{$header->NAMAS}}">
									</div> 
									
								</div>
			
								<div class="form-group row">
									<div class="col-md-1">
										<label for="ALAMAT" class="form-label">Alamat</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT"
										placeholder="Masukkan Alamat" value="{{$header->ALAMAT}}">
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control KOTA" id="KOTA "name="KOTA"
										placeholder="Masukkan Kota" value="{{$header->KOTA}}">
									</div>
								</div>
			
								<div class="form-group row">
									<div class="col-md-1" align="left">
										<label for="TELPON1" class="form-label">Telpon</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control TELPON1" id="TELPON1" name="TELPON1" placeholder="" value="{{$header->TELPON1}}" >
									</div>

									<div class="col-md-2">
                                        <label for="GOL" class="form-label">Golongan</label>
                                    </div>
                                    <div class="col-md-2">
                                        <select id="GOL" class="form-control"  name="GOL">
											<option value="Y" {{ ($header->GOL == 'Y') ? 'selected' : '' }}>Y</option>
											<option value="Z" {{ ($header->GOL == 'Z') ? 'selected' : '' }}>Z</option>
                                        </select>
                                    </div>	
								</div>

								<div class="form-group row">
									<div class="col-md-1" align="left">
										<label for="FAX" class="form-label">Fax</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control FAX" id="FAX" name="FAX" placeholder="" value="{{$header->FAX}}" >
									</div>
								</div>
	
								<div class="form-group row">
									<div class="col-md-1" align="left">
										<label for="HP" class="form-label">HP</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control HP" id="HP" name="HP" placeholder="" value="{{$header->HP}}" >
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-1" align="left">
										<label for="KONTAK" class="form-label">Kontak</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control KONTAK" id="KONTAK" name="KONTAK" placeholder="" value="{{$header->KONTAK}}" >
									</div>

									<div class="col-md-1" align="right">
										<label for="EMAIL" class="form-label">Email</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control EMAIL" id="EMAIL" name="EMAIL" placeholder="" value="{{$header->EMAIL}}" >
									</div>

									<div class="col-md-1" align="right">
										<label for="NPWP" class="form-label">NPWP</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control NPWP" id="NPWP" name="NPWP" placeholder="" value="{{$header->NPWP}}" >
									</div>
								</div>

								<div class="form-group row">

									<div class="col-md-1" align="right">
										<label for="EMAIL" class="form-label">Pembayaran</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control EMAIL" id="EMAIL" name="EMAIL" placeholder="" value="{{$header->EMAIL}}" >
									</div>
								</div> 

								<div class="form-group row">
									<div class="col-md-1" align="left">
										<label for="KET" class="form-label">Ket</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control KET" id="KET" name="KET" placeholder="" value="{{$header->KET}}" >
									</div>
								</div>
							</div>

							
							<!--------------------------------------------------->
							
							<div id="bankInfo" class="tab-pane">
				
								<div class="form-group row">
									<div class="col-md-1">
										<label for="BANK" class="form-label">Bank</label>
									</div>
									<div class="col-md-2">
										<select name="BANK" id="BANK" class="form-control BANK" style="width: 300px">
											<option value="">--Pilih Bank--</option>
											@foreach($pilihbank as $pilihbankD)
												<option value="{{$pilihbankD->KODE}}" {{ $header->BANK == $pilihbankD->KODE ? 'selected' : '' }}>{{ $pilihbankD->NAMA }}</option>
											@endforeach
										</select>
									</div>                                
								</div>

								<div class="form-group row">							       
									<div class="col-md-1">
										<label for="BANK_CAB" class="form-label">Cabang</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control BANK_CAB" id="BANK_CAB" name="BANK_CAB" placeholder="Masukkan Cabang" value="{{$header->BANK_CAB}}">
									</div>
								</div>

								<div class="form-group row">							       
									<div class="col-md-1">
										<label for="BANK_KOTA" class="form-label">Kota</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control BANK_KOTA" id="BANK_KOTA" name="BANK_KOTA" placeholder="Masukkan Kota" value="{{$header->BANK_KOTA}}">
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-md-1">
										<label for="BANK_NAMA" class="form-label">A/N</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control BANK_NAMA" id="BANK_NAMA" name="BANK_NAMA" placeholder="Masukkan Nama" value="{{$header->BANK_NAMA}}">
									</div>                                
								</div>
								
								<div class="form-group row">
									<div class="col-md-1">
										<label for="BANK_REK" class="form-label">No Rekening</label>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control BANK_REK" id="BANK_REK" name="BANK_REK" placeholder="Masukkan Nomor Rekening" value="{{$header->BANK_REK}}">
									</div>                                
								</div>
							
							
								<div class="form-group row">
									<div class="col-md-1">
										<label for="HARI" class="form-label">Jatuh Tempo (Hari)</label>
									</div>
									<div class="col-md-1">
										<input type="text" class="form-control HARI" id="HARI" name="HARI" placeholder="Masukkan Jumlah Hari" value="{{$header->HARI}}" style="text-align: right; width:140px">
									</div>                                
								</div>
								
							</div>


							<!---------------------------------------------------------->


							<div id="deliveryInfo" class="tab-pane">	
							
								<div class="form-group row">
									<div class="col-md-1">
										<label for="LDT_NEW" class="form-label">U/ Barang Baru</label>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control LDT_NEW" id="LDT_NEW" name="LDT_NEW"
										placeholder="" value="{{$header->LDT_NEW}}">
									</div>
									
									<div class="col-md-1">
										<label for="LDT_REP" class="form-label">U/ Barang Repeat</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control LDT_REP" id="LDT_REP" name="LDT_REP"
										placeholder="" value="{{$header->LDT_REP}}">
									</div>
								</div>

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="PLH" class="form-label">Price Lv. High</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="PLH" class="form-control"  name="PLH">
											<option value="1" {{ ($header->PLH == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLH == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-1">
										<label for="PLM" class="form-label">Price Lv. Medium</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="PLM" class="form-control"  name="PLM">
											<option value="1" {{ ($header->PLM == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLM == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-1">
										<label for="PLL" class="form-label">Price Lv. Low</label>
									</div>
									<div class="col-md-2">
										<select id="PLL" class="form-control"  name="PLL">
											<option value="1" {{ ($header->PLL == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLL == '0') ? 'selected' : '' }}>Tidak Aktif</option>
										</select>
									</div>
									
								</div>
							</div>


							<!---------------------------------------------------------->


							<div id="standartInfo" class="tab-pane">	
							

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="SKH" class="form-label">Standart Qty High</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="SKH" class="form-control"  name="SKH">
											<option value="1" {{ ($header->SKH == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKH == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control SKH_KET" id="SKH_KET" name="SKH_KET"
										placeholder="" value="{{$header->SKH_KET}}" >
									</div>
								</div>

								<div class="form-group row">

									<div class="col-md-1">
										<label for="SKM" class="form-label">Standart Qty Medium</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="SKM" class="form-control"  name="SKM">
											<option value="1" {{ ($header->SKM == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKM == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control SKM_KET" id="SKM_KET" name="SKM_KET"
										placeholder="" value="{{$header->SKM_KET}}" >
									</div>
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="SKL" class="form-label">Standart Qty Low</label>
									</div>
									<div class="col-md-2">
										<select id="SKL" class="form-control"  name="SKL">
											<option value="1" {{ ($header->SKL == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKL == '0') ? 'selected' : '' }}>Tidak Aktif</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control SKL_KET" id="SKL_KET" name="SKL_KET"
										placeholder="" value="{{$header->SKL_KET}}" >
									</div>
									
								</div>
							</div>


							<!---------------------------------------------------------->


							<div id="nilaiInfo" class="tab-pane">	
							

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="NKUALITAS" class="form-label">Kualitas</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="NKUALITAS" class="form-control"  name="NKUALITAS">
											<option value="" {{ ($header->NKUALITAS == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKUALITAS == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKUALITAS == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKUALITAS == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control KUALITAS" id="KUALITAS" name="KUALITAS"
										placeholder="" value="{{$header->KUALITAS}}" >
									</div>


									<div class="col-md-1">
										<label for="NHARGA" class="form-label">Harga</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="NHARGA" class="form-control"  name="NHARGA">
											<option value="" {{ ($header->NHARGA == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NHARGA == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NHARGA == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NHARGA == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control NOTE_HARGA" id="NOTE_HARGA" name="NOTE_HARGA"
										placeholder="" value="{{$header->NOTE_HARGA}}" >
									</div>
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NPENGIRIMAN" class="form-label">Pengiriman</label>
									</div>
									<div class="col-md-2">
										<select id="NPENGIRIMAN" class="form-control"  name="NPENGIRIMAN">
											<option value="" {{ ($header->NPENGIRIMAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPENGIRIMAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPENGIRIMAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPENGIRIMAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PENGIRIMAN" id="PENGIRIMAN" name="PENGIRIMAN"
										placeholder="" value="{{$header->PENGIRIMAN}}" >
									</div>

									<div class="col-md-1">
										<label for="NKEAMANAN" class="form-label">Keamanan</label>
									</div>
									<div class="col-md-2">
										<select id="NKEAMANAN" class="form-control"  name="NKEAMANAN">
											<option value="" {{ ($header->NKEAMANAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKEAMANAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKEAMANAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKEAMANAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control KEAMANAN" id="KEAMANAN" name="KEAMANAN"
										placeholder="" value="{{$header->KEAMANAN}}" >
									</div>
									
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NKREDIT" class="form-label">Kredit</label>
									</div>
									<div class="col-md-2">
										<select id="NKREDIT" class="form-control"  name="NKREDIT">
											<option value="" {{ ($header->NKREDIT == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKREDIT == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKREDIT == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKREDIT == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control KREDIT" id="KREDIT" name="KREDIT"
										placeholder="" value="{{$header->KREDIT}}" >
									</div>

									<div class="col-md-1">
										<label for="NPRODUKSI" class="form-label">Produksi</label>
									</div>
									<div class="col-md-2">
										<select id="NPRODUKSI" class="form-control"  name="NPRODUKSI">
											<option value="" {{ ($header->NPRODUKSI == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPRODUKSI == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPRODUKSI == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPRODUKSI == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PRODUKSI" id="PRODUKSI" name="PRODUKSI"
										placeholder="" value="{{$header->PRODUKSI}}" >
									</div>
									
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NPELAYANAN" class="form-label">Pelayanan</label>
									</div>
									<div class="col-md-2">
										<select id="NPELAYANAN" class="form-control"  name="NPELAYANAN">
											<option value="" {{ ($header->NPELAYANAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPELAYANAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPELAYANAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPELAYANAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PELAYANAN" id="PELAYANAN" name="PELAYANAN"
										placeholder="" value="{{$header->PELAYANAN}}" >
									</div>

									<div class="col-md-1">
										<label for="NISO" class="form-label">Iso</label>
									</div>
									<div class="col-md-2">
										<select id="NISO" class="form-control"  name="NISO">
											<option value="" {{ ($header->NISO == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NISO == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NISO == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NISO == 'KURANG') ? 'selected' : '' }}>Kurang</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control ISO" id="ISO" name="ISO"
										placeholder="" value="{{$header->ISO}}" >
									</div>
									
								</div>

								<div class="form-group row">

									<div class="col-md-1">
										<label for="NILAI" class="form-label">Nilai Akhir</label>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control NILAI" id="NILAI" name="NILAI"
										placeholder="" value="{{$header->NILAI}}" >
									</div>
									
								</div>	
							

								<!--------------------------------------------------->

							</div>

						</div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/sup/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KODES )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/sup/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KODES )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/sup/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()' class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/sup' )}}'" class="btn btn-outline-secondary">Close</button>


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
@endsection

@section('footer-scripts')
<script>
    var target;
	var idrow = 1;

    $(document).ready(function () {

		$('body').on('keydown', 'input, select', function(e) {
			if (e.key === "Enter") {
				var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				focusable = form.find('input,select,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				console.log(next);
				if (next.length) {
					next.focus().select();
				} else {
					// tambah();
					// var nomer = idrow-1;
					// console.log("REC"+nomor);
					// document.getElementById("REC"+nomor).focus();
					// form.submit();
				}
				return false;
			}
		});

 		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			 baru();			
		}

        if ( $tipx != 'new' )
		{
			 //mati();	
    		 ganti();
		}    
	
    });


	function baru() {
		
		 kosong();
		 hidup();
		 
	}
	
	function ganti() {
		
		// mati();
		hidup();
	
	}
	
	
	function batal() {
			
		 mati();
	
	}
	

	function hidup() {

	    $("#TOPX").attr("disabled", true);
	    $("#PREVX").attr("disabled", true);
	    $("#NEXTX").attr("disabled", true);
	    $("#BOTTOMX").attr("disabled", true);

	    $("#NEWX").attr("disabled", true);
	    $("#EDITX").attr("disabled", true);
	    $("#UNDOX").attr("disabled", false);
	    $("#SAVEX").attr("disabled", false);
		
	    $("#HAPUSX").attr("disabled", true);
	    $("#CLOSEX").attr("disabled", false);
		
		
 		$tipx = $('#tipx').val();
		
        if ( $tipx == 'new' )		
		{	
		  	
			$("#KODES").attr("readonly", false);	

		   }
		else
		{
	     	$("#KODES").attr("readonly", true);	

		   }
		   
		$("#PLH").attr("readonly", false);	
		$("#ALAMAT").attr("readonly", false);			
		$("#KOTA").attr("readonly", false);		
		$("#TELPON1").attr("readonly", false);			
		$("#FAX").attr("readonly", false);	
		$("#HP").attr("readonly", false);			
		$("#AKT").attr("readonly", false);		
		$('#KONTAK').attr("readonly", false);

		 $('#EMAIL').attr("readonly", false);	
		 $('#NPWP').attr("readonly", false);	
		 $('#KET').attr("readonly", false);


		 $('#BANK').attr("readonly", false);	
		 $('#BANK_CAB').attr("readonly", false);	
		 $('#BANK_KOTA').attr("readonly", false);	
		 $('#BANK_NAMA').attr("readonly", false);		
		 $('#BANK_REK').attr("readonly", false);
		 $('#HARI').attr("readonly", false);
		 $('#LIM').attr("readonly", false);	
	
	
	}


	function mati() {

	    $("#TOPX").attr("disabled", false);
	    $("#PREVX").attr("disabled", false);
	    $("#NEXTX").attr("disabled", false);
	    $("#BOTTOMX").attr("disabled", false);

	    $("#NEWX").attr("disabled", false);
	    $("#EDITX").attr("disabled", false);
	    $("#UNDOX").attr("disabled", true);
	    $("#SAVEX").attr("disabled", true);
	    $("#HAPUSX").attr("disabled", false);
	    $("#CLOSEX").attr("disabled", false);
		
		$("#KODES").attr("readonly", true);			
		$("#PLH").attr("readonly", true);	
		$("#ALAMAT").attr("readonly", true);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON1").attr("readonly", true);			
		$("#FAX").attr("readonly", true);	
		$("#HP").attr("readonly", true);			
		$("#AKT").attr("readonly", true);		
		$('#KONTAK').attr("readonly", true);

		 $('#EMAIL').attr("readonly", true);	
		 $('#NPWP').attr("readonly", true);	
		 $('#KET').attr("readonly", true);


		 $('#BANK').attr("readonly", true);	
		 $('#BANK_CAB').attr("readonly", true);	
		 $('#BANK_KOTA').attr("readonly", true);	
		 $('#BANK_NAMA').attr("readonly", true);		
		 $('#BANK_REK').attr("readonly", true);
		 $('#HARI').attr("readonly", true);
		 $('#LIM').attr("readonly", true);	
		
		
	

		
	}


	function kosong() {
				
		 $('#KODES').val("");	
		 $('#NAMAS').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");		

		 $('#TELPON1').val("");	
		 $('#FAX').val("");	
		 $('#HP').val("");	
		 $('#AKT').val("0");		
		 $('#KONTAK').val("");

		 $('#EMAIL').val("");	
		 $('#NPWP').val("");	
		 $('#KET').val("");	


		 $('#BANK').val("");	
		 $('#BANK_CAB').val("");	
		 $('#BANK_KOTA').val("");	
		 $('#BANK_NAMA').val("");		
		 $('#BANK_REK').val("");
		 $('#HARI').val("0");
		 $('#LIM').val("0");		


		 
	}
	
	function hapusTrans() {
		let text = "Hapus Master "+$('#KODES').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/sup/delete/'.$header->NO_ID )}}'";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/sup/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

     
     
    var hasilCek;
	function cekSup(kodes) {
		$.ajax({
			type: "GET",
			url: "{{url('sup/ceksup')}}",
            async: false,
			data: ({ KODES: kodes, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekSup occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        hasilCek=0;
		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			cekSup($('#KODES').val());		
		}
		

        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Suplier '+$('#KODES').val()+' sudah ada!');
	}
</script>
@endsection

