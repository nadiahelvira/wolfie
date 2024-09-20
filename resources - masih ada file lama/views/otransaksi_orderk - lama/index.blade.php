@extends('layouts.main')
@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}">
@endsection


<style>
    .card-body {
        padding: 5px 10px !important;
    }

    .table thead {
        background-color: #c6e2ff;
        color: #000;
    }

    .datatable tbody td {
        padding: 5px !important;
    }

    .datatable {
        border-right: solid 2px #000;
        border-left: solid 2px #000;
    }

    .table tbody:nth-child(2) {
        background-color: #ffe4e1;
    }

    .btn-secondary {
        background-color: #42047e !important;
    }
    
    .klikheader, .klikdetail {
      cursor: pointer;
    }
</style>


@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Transaksi Order Kerja {{$JUDUL}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Transaksi Order Kerja {{$JUDUL}}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="text-align: center">No</th>
				     		            <th scope="col" style="text-align: center">-</th>							
                            <th scope="col" style="text-align: center">No Bukti</th>
                            <th scope="col" style="text-align: center">Tgl</th>
                            <th scope="col" style="text-align: center">Kode</th>
                            <th scope="col" style="text-align: center">Customer</th>
                            <th scope="col" style="text-align: center">SO#</th>
                            <th scope="col" style="text-align: center">Kode</th>
                            <th scope="col" style="text-align: center">Barang</th>
                            <th scope="col" style="text-align: center">No Seri</th>
                            <th scope="col" style="text-align: center">FO#</th>
                            <th scope="col" style="text-align: center">Notes</th>				
                        </tr>
                    </thead>
   
                    <tbody>
                    </tbody> 
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
	<div class="modal fade" id="browsePakaiModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="browsePakaiModal">
	  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Informasi Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="tabContent">
              <li class="nav-item active"><a class="nav-link active" href="#pakai" data-toggle="tab">Pemakaian</a></li>
          </ul>
          
          <div class="tab-content">
              <div class="tab-pane active" id="pakai">
                <legend class="font-weight-bold">Pemakaian</legend>
                <table class="table table-stripped table-bordered" id="table-pakai">
                  <thead>
                    <tr>
                      <th>Pakai#</th>
                      <th>Tanggal</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>In</th>
                      <th>Out</th>
                      <th>Lain</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
	  </div>
	</div>
@endsection

@section('javascripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            // scrollX : true,
            scrollY : '400px',
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: "{{ route('get-orderk') }}",
                data: {
                  JNSOK: "{{$JNSOK}}",
                },
            },
            columns: 
            [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'action',name: 'action'},
                {data: 'NO_BUKTI', name: 'NO_BUKTI'},
                {data: 'TGL', name: 'TGL'},
                {data: 'KODEC', name: 'KODEC'},
                {data: 'NAMAC', name: 'NAMAC'},
                {data: 'NO_SO', name: 'NO_SO'},
                @if ($JNSOK == 'OK')
                  {data: 'KD_BRG', name: 'KD_BRG'},
                  {data: 'NA_BRG', name: 'NA_BRG'},
                @endif
                @if ($JNSOK == 'OW')
                  {data: 'KD_BHN', name: 'KD_BHN'},
                  {data: 'NA_BHN', name: 'NA_BHN'},
                @endif
                {data: 'NO_SERI', name: 'NO_SERI'},
                {data: 'NO_FO', name: 'NO_FO'},
                {data: 'NOTES', name: 'NOTES'},
            ],

            columnDefs: [
                {
                  className: "dt-center klikheader", 
                  targets: 2,
                  createdCell: function (td, cellData, rowData, row, col) {
                              $(td).css('color', 'blue');
                      }
                },
                {
                    "className": "dt-center", 
                    "targets": 0
                },			
                {
                  targets: 3,
                  render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
                },
				
            ],
            lengthMenu: [
                [8, 10, 20, 50, 100, -1],
                [8, 10, 20, 50, 100, "All"]
            ],
            dom: "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        });
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('orderk/create')}}?JNSOK={{$JNSOK}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
        
        $('#datatable tbody').on('click', 'td.klikheader', function () {
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);
            var nobukti = dataTable.cell(this).data();
            
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(nobukti,row.data())).show();
                tr.addClass('shown');
            }

        });
        
        
        
        /////////////////////PEMAKAIAN///////////////////
        var dTablePakai;
        loadDataPakai = function(nobukti,kdprs){
          $.ajax(
          {
            type: 'GET',    
            url: "{{url('orderk/browsePakai')}}",
            data: {
                NO_ORDER: nobukti,
                KD_PRS: kdprs,
            },
            success: function( response )
            {
              resp = response;
              if(dTablePakai){
                dTablePakai.clear();
              }
              for(i=0; i<resp.length; i++){
                
                dTablePakai.row.add([
                  resp[i].NO_BUKTI,
                  $.datepicker.formatDate('dd-mm-yy', new Date(resp[i].TGL)),
                  resp[i].KD_PRS,
                  resp[i].NA_PRS,
                  resp[i].QTY_IN,
                  resp[i].QTY_OUT,
                  resp[i].QTY_IN-resp[i].QTY_OUT,
                ]);
              }
              dTablePakai.draw();
            }
          });
        }
        
        dTablePakai = $("#table-pakai").DataTable({
          columnDefs: [
            {
              targets:  [4,5,6],
              className: 'dt-body-right'
            }
          ],
        })
        /////////////////////PEMAKAIAN///////////////////

        browsePakai = function(nobukti,kdprs){
          loadDataPakai(nobukti,kdprs);
          $("#browsePakaiModal").modal("show");
        }
    });

    
function getinfo(nobukti,kdprs){
  browsePakai(nobukti,kdprs);
}

function format (bukti,rowData) {
    var div = $('<div/>').addClass( 'loading' ).text( 'Memuat...' );
    
    $.ajax(
    {
      type: 'GET',    
      url: "{{url('orderk/browseOrderkxd')}}",
      data: {
          NO_BUKTI: (bukti.length>5) ? bukti : '',
      },
      success: function(response)
      {
        var baris = '<table id="detailtabel">'+
                      '<tr>'+
                        '<th>No Proses</th>'+
                        '<th>Kode</th>'+
                        '<th>Proses</th>'+
                        '<th>Masuk</th>'+
                        '<th>Keluar</th>'+
                        '<th>Rusak</th>'+
                        '<th>Sisa</th>'+
                        '<th>Proses</th>'+
                        '<th>Belum Proses</th>'+
                        '<th>Akhir</th>'+
                      '</tr>';
        var isi = '';
        for(i=0; i<response.length; i++){
          isi = '<tr>'+
                  '<td style="text-align:center">' + response[i].NO_PRS + '</td>'+
                  '<td class="klikdetail" style="color:blue" onclick="getinfo(\''+response[i].NO_BUKTI+'\',  \''+response[i].KD_PRS+'\')">' + response[i].KD_PRS + '</td>'+
                  '<td>' + response[i].NA_PRS + '</td>'+
                  '<td style="text-align:right">' + response[i].MASUK + '</td>'+
                  '<td style="text-align:right">' + response[i].KELUAR + '</td>'+
                  '<td style="text-align:right">' + response[i].LAIN + '</td>'+
                  '<td style="text-align:right">' + response[i].SISA + '</td>'+
                  '<td style="text-align:right">' + response[i].PROSES + '</td>'+
                  '<td style="text-align:right">' + response[i].BLM_PROSES + '</td>'+
                  '<td style="text-align:center"> <input type="checkbox" class="form-control" ' +((response[i].AKHIR == 1) ? "checked" : "") + ' style="pointer-events: none;"></input> </td>'+
                '</tr>';
          baris += isi;
        }
        baris += "</table>"
        div.html(baris).removeClass('loading');
      }
    });
 
    return div;
}
</script>
@endsection
