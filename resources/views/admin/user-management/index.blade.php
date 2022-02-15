@extends('admin.layouts.main')
@section('title',$title.' Management')
@section('content')
<div class="pagetitle">
    <h1>{{$title}} Management</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">user-management</li>
        <li class="breadcrumb-item active">{{$title}}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{$title}} List</h5>
            <a class="btn btn-primary btn-sm" id="btn-add-data" style="margin-bottom:20px">Add Data</a>
            <table id="tbl-user" class="table table-hovered" style="min-width:98%">
                <thead>
                    <tr>
                        <td>NO</td>
                        <td>NAME</td>
                        <td>USERNAME</td>
                        <td>EMAIL</td>
                        {{-- <td>CREATED AT</td>
                        <td>UPDATED AT</td> --}}
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
  @include('admin.user-management.modal')
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
                    data: "name",
                    name: "name",
                    sortable: false,
                    searchable: false
                },
                {
                    data: "username",
                    name: "username",
                    sortable: false,
                    searchable: false
                },
                {
                    data: "email",
                    name: "email",
                    sortable: false,
                    searchable: false
                },
                /* {
                    data: "created_at",
                    name: "created_at",
                    sortable: false,
                    searchable: false
                },
                {
                    data: "updated_at",
                    name: "updated_at",
                    sortable: false,
                    searchable: false
                }, */
                {
                    data: null,
                    name: "action",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return '<a class="btn btn-success btn-sm btn-edit" title="edit"><i class="ri-edit-2-line"></i></a>&nbsp;<a title="delete" class="btn btn-danger btn-delete btn-sm"><i class="ri-delete-bin-line"></i></a>';
                    }
                }]
    });

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#btn-add-data').on('click',function(){
        $('.is-invalid').removeClass('is-invalid');
        $('#password').remove();
        $('#form-title').text("Add New {{$title}}");
        $('input[name="id"]').val("");
        $('#form')[0].reset();
        $('#form-modal').append(`<div id="password" class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" placeholder="name@example.com">
                    <label for="floatingInput">Password</label>
                    <div class="invalid-feedback"></div>
                </div>`)
        $('#modal').modal("show");
    })

    $(document).on('click', '.btn-edit', function(){
        $('.is-invalid').removeClass('is-invalid');
        $('#form-title').text("Edit {{$title}} Data");
        $('#password').remove();
        var data = table.row($(this).closest('tr')).data();
        $.each(data,function(key,val){
            $('[name="'+key+'"]').val(val)
        })
        $('#modal').modal('show');
    });

    $(document).on('click', '.btn-delete', function(){
        var data = table.row($(this).closest('tr')).data();
        if(confirm("Yakin Menghapus Data?")){
            $.ajax({
                url: "{{url('player/delete')}}/"+data.id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    table.ajax.reload();
                    alert(data.msg)
                }
            });
        }
    });

    $('#form').on("submit",function(e){
        $('.is-invalid').removeClass('is-invalid');
        $('.btn-submit').prop('disabled',true);
        $('.btn-submit').text('Loading...');
        var datas = $('#form').serializeArray();
        var data = {};

        $.each(datas, function() {
            data[this.name] = this.value;
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method  : 'post',
            url     : "{{url('admin/user-list/store')}}",
            dataType: 'json',
            data    : data,
            success: function(data) {                
                table.ajax.reload();
                alert(data.msg)
                $('.btn-submit').prop('disabled',false);
                $('.btn-submit').text('Submit');
                $('.modal').modal('hide');
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.each(jqXHR.responseJSON.errors, function(key,val){
                    $('.btn-submit').prop('disabled',false);
                    $('.btn-submit').text('Submit');
                    $(`[name='${key}']`).addClass('is-invalid');
                    $(`[name='${key}']`).nextAll('.invalid-feedback').text(val.toString().replace(`${key}`, $(`[name="${key}"]`).next().text()));
                })
            }
        })
        $('.btn-submit').prop('disabled',false);
        $('.btn-submit').text('Submit');
        e.preventDefault();
    })
 </script>   
@endsection