@extends('admin.layouts.main')
@section('title',/* $brand->brand. */' Type Management')
@section('content')
<div class="pagetitle">
    <h1>Type Management</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">type / {{-- {{$brand->brand}} --}}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{-- {{$brand->brand}} --}} Type List</h5>
            <div class="card col-lg-12 row" style="padding: 10px">
                <table>
                {{-- <?= $detail->detail ?> --}}
                </table>
            </div>
            <a class="btn btn-primary btn-sm" id="btn-add-data" style="margin-bottom:20px">Add Data</a>
            <a class="btn btn-success btn-sm" id="btn-crawl-data" style="margin-bottom:20px">Crawl Data</a>
            <table id="tbl-user" class="table table-hovered" style="min-width:98%">
                <thead>
                    <tr>
                        <td style="max-width:40px">NO</td>
                        <td>TYPE</td>
                        <td>YEAR</td>
                        <td>DETAIL</td>
                        <td style="max-width: 130px">ACTIONS</td>
                    </tr>
                </thead>
            </table>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Image List</h5>
            <table class="table" id="tblImage">
                <thead>
                    <tr>
                        <th>Image List</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($image as $item)
                    <tr>
                        <td>
                            <img src="{{url($item->image)}}">
                        </td>
                        <td>
                            <a title="delete" class="btn btn-danger btn-delete btn-sm"><i class="ri-delete-bin-line"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
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
     $('#tblImage').DataTable({
        "dom": 'rtip',
     });
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
                    data: "title",
                    name: "title",
                    sortable: false,
                    searchable: false,
                },
                {
                    data: "year",
                    name: "year",
                    sortable: false,
                    searchable: false
                },
                {
                    data: "detail",
                    name: "detail",
                    sortable: false,
                    searchable: false
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

 </script>   
@endsection