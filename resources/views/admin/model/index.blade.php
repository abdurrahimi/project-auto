@extends('admin.layouts.main')
@section('title',$brand->brand.' Model Management')
@section('content')
<div class="pagetitle">
    <h1>Model Management</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">model / {{$brand->brand}}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{$brand->brand}} Model List</h5>
            <a class="btn btn-primary btn-sm" id="btn-add-data" style="margin-bottom:20px">Add Data</a>
            <table id="tbl-user" class="table table-hovered" style="min-width:98%">
                <thead>
                    <tr>
                        <td style="max-width:40px">NO</td>
                        <td>MODEL NAME</td>
                        <td>BRAND</td>
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
  @include('admin.model.modal')
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
            "dataSrc" : "data",
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
                    name: "model",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return `<img src="{{url('${data.image}')}}" style="height:50px;"> <b>${data.model}</b>`;
                    }
                },
                {
                    data: null,
                    name: "brand.brand",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return `<img src="{{url('${data.brand.logo}')}}"> <b>${data.brand.brand}</b>`;
                    }
                },
                {
                    data: null,
                    name: "action",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return '<a href="{{url("admin/generation")}}/'+data.id+'" class="btn btn-info btn-sm btn-detail" title="detail"><i class="ri-eye-line"></i></a>&nbsp;<a class="btn btn-success btn-sm btn-edit" title="edit"><i class="ri-edit-2-line"></i></a>&nbsp;<a title="delete" class="btn btn-danger btn-delete btn-sm"><i class="ri-delete-bin-line"></i></a>';
                    }
                }]
    });

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#btn-add-data').on('click',function(){
      $('#modal').modal('show');
    })

    $('#modal').on('hidden.bs.modal', function () {
        var datas = $('#form').serializeArray();
        $.each(datas, function() {
            $(`input[name="${this.name}"]`).val("");
        });
    })

    $('#form').on('submit',function(e){
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');
        $('.btn-submit').prop('disabled',true);
        $('.btn-submit').text('Loading...');
        var formData = new FormData($('#form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method  : 'post',
            url     : "{{url('admin/model/store')}}",
            //dataType: 'application/x-www-form-urlencoded',
            processData: false,
            contentType: false,
            data    : formData,
            success: function(data) {    
    
                table.ajax.reload(null,false);
                alert(data.msg)
                $('.btn-submit').prop('disabled',false);
                $('.btn-submit').text('Submit');
                $('.modal').modal('hide');
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.btn-submit').prop('disabled',false);
                $('.btn-submit').text('Submit');
                /* $.each(jqXHR.responseJSON.errors, function(key,val){
                    
                }) */
            }
        })
    })
 </script>   
@endsection