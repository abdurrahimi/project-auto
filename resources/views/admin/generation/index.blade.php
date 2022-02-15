@extends('admin.layouts.main')
@section('title',/* $brand->brand. */' Model Management')
@section('content')
<div class="pagetitle">
    <h1>Model Management</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">model / {{-- {{$brand->brand}} --}}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{-- {{$brand->brand}} --}} Model List</h5>
            <a class="btn btn-primary btn-sm" id="btn-add-data" style="margin-bottom:20px">Add Data</a>
            <a class="btn btn-success btn-sm" id="btn-crawl-data" style="margin-bottom:20px">Crawl Data</a>
            <table id="tbl-user" class="table table-hovered" style="min-width:98%">
                <thead>
                    <tr>
                        <td style="max-width:40px">NO</td>
                        <td>GENERATION</td>
                        <td>DETAIL</td>
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
                    name: "title",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return `<img src="{{url('${data.image}')}}" style="height:50px;"> <b>${data.title}</b>`;
                    }
                },
                {
                    data: null,
                    name: "detail",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return `<table>
                                    <tr>
                                        <th>Type </th>
                                        <td>&nbsp;:&nbsp;${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimension </th>
                                        <td>&nbsp;:&nbsp;${data.dimension}</td>
                                    </tr>
                                    <tr>
                                        <th>Power </th>
                                        <td>&nbsp;:&nbsp;${data.power}</td>
                                    </tr>
                                </table>

                        `;
                    }
                },
                {
                    data: null,
                    name: "brand.brand",
                    sortable: false,
                    searchable: false,
                    /* render:function(data){
                        return `<img src="{{url('${data.brand.logo}')}}"> <b>${data.brand.brand}</b>`;
                    } */
                },
                {
                    data: null,
                    name: "action",
                    sortable: false,
                    searchable: false,
                    render:function(data){
                        return '<a href="{{url("admin/type")}}/'+data.id+'" class="btn btn-info btn-sm btn-detail" title="detail"><i class="ri-eye-line"></i></a>&nbsp;<a class="btn btn-success btn-sm btn-edit" title="edit"><i class="ri-edit-2-line"></i></a>&nbsp;<a title="delete" class="btn btn-danger btn-delete btn-sm"><i class="ri-delete-bin-line"></i></a>';
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