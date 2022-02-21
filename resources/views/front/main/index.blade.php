@extends('front.layouts.main')
@section('content')
<section id="counts" class="counts" >
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h2>Popular Brand</h2>
          </header>

      <div class="row gy-4">
        @foreach ($brand as $item)
        <div class="col-lg-2 col-md-3">
            <a href="{{url('brand/'.str_replace(' ','-',strtolower($item->brand->brand)))}}" class="count-box justify-content-center">
                {{-- <div > --}}
                    <div class="text-center">
                        <img src="{{url($item->brand->logo)}}">
                        <p ><b style="color:#000">{{$item->brand->brand}}</b></p>
                    </div>
                {{-- </div> --}}
            </a>
        </div>
        @endforeach
        <div class="col-lg-2 col-md-3">
            <a href="{{url('all-brand')}}" class="count-box justify-content-center">
                {{-- <div > --}}
                    <div class="text-center">
                        <img src="{{isset($item->brand->logo)?url($item->brand->logo):"https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg"}}" style="width: 40px; height:40px">
                        <p ><b style="color:#000">All Brand</b></p>
                    </div>
                {{-- </div> --}}
            </a>
        </div>

    </div>
</section>
@endsection