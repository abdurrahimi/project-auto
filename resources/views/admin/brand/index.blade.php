@extends('admin.layouts.main')
@section('title','Brand Management')
@section('content')
<div class="pagetitle">
    <h1>Brand Management</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">brand</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Brand List</h5>
            <a class="btn btn-primary btn-sm" id="btn-add-data" style="margin-bottom:20px">Add Data</a>
            <a class="btn btn-success btn-sm" id="btn-crawl-data" style="margin-bottom:20px">Crawl Data</a>
            <table id="tbl-user" class="table table-hovered" style="min-width:98%">
                <thead>
                    <tr>
                        <td style="max-width:40px">NO</td>
                        <td>BRAND NAME</td>
                        <td style="max-width: 130px">ACTIONS</td>
                    </tr>
                </thead>
            </table>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>
  {{-- @include('admin.user-management.modal') --}}
@endsection

@section('script')
 <script>
     var table = $('#tbl-user').DataTable({
        scrollX: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "dom": 'lrtip',
        pagingType: 'full_numbers',
        "processing": true,
         retrieve: true,
         "language": {
                    "loadingRecords": "Memuat data..."
         },
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "url": "",
            "type": "GET"
        },
        columns: [{
                    data: null,
                    name: "NO",
                    sortable: false,
                    searchable: false
                },
                {
                    data: null,
                    name: "brand",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return `<img src="{{url('${data.logo}')}}"> ${data.brand}`;
                    }
                },
                {
                    data: null,
                    name: "action",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return '<a href="{{url("admin/model")}}/'+data.id+'" class="btn btn-info btn-sm btn-detail" title="detail"><i class="ri-eye-line"></i></a>&nbsp;<a class="btn btn-success btn-sm btn-edit" title="edit"><i class="ri-edit-2-line"></i></a>&nbsp;<a title="delete" class="btn btn-danger btn-delete btn-sm"><i class="ri-delete-bin-line"></i></a>';
                    }
                }]
    });

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#btn-crawl-data').on('click',function(){
        $('#btn-crawl-data').text('Processing...');
        $('#btn-crawl-data').addClass('disabled');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method  : 'get',
            url     : "{{url('admin/brand/crawl')}}",
            dataType: 'json',
            success: function(data) {
                table.ajax.reload();              
                alert(data.msg);
                $('#btn-crawl-data').text('Crawl Data');
                $('#btn-crawl-data').removeClass('disabled');
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#btn-crawl-data').text('Crawl Data');
                $('#btn-crawl-data').removeClass('disabled');
            }
        })
        
    })
 </script>   
@endsection