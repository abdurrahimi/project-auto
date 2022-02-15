@extends('front.layouts.main')
@section('content')
<section id="counts" class="counts" >
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h2>All {{$brand->brand}} Models</h2>
          </header>

        @foreach (array_unique($key) as $item)
            <a href="#{{$item}}" style="font-weight: 800; margin-right: 10px; text-decoration:underline; font-size: 24px; color:black">{{$item}}</a>
        @endforeach
        <hr>
        @foreach ($model as $k => $item)
            <a href="#{{$k}}" style="font-weight: 800; margin-right: 10px; text-decoration:underline; font-size: 24px; color:black">{{$k}}</a>
            <div id="{{$k}}" class="row gy-4">
                @foreach ($item as $value)
                
                <div class="col-lg-2 col-md-3">
                    <a href="{{url('generation/'.strtolower($value->model.'-model-'.$value->id))}}" class="count-box justify-content-center">
                        {{-- <div > --}}
                            <div class="text-center">
                                <img src="{{url($value->image)}}">
                                <p ><h5 style="color:#000; margin-top:20px">{{$value->model}}</h5></p>
                            </div>
                        {{-- </div> --}}
                    </a>
                </div>
                @endforeach
            </div>
            <hr>
        @endforeach

    </div>
</section>
@endsection