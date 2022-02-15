@extends('front.layouts.main')
@section('content')
<section id="pricing" class="pricing">

    <div class="container aos-init aos-animate" data-aos="fade-up">

      <header class="section-header">
        <h2>Generation</h2>
        <p>Generation For - </p>
      </header>

      <div class="row gy-4 aos-init aos-animate" data-aos="fade-left">
        @foreach ($generation as $item)
        <div class="col-lg-12 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="box" style="padding:0px; text-align: left;">
                <table >
                        <tr>
                            <td>
                                <img src="{{url($item->image)}}">
                            </td>
                            <td style="padding-left: 20px">
                                <h4>{{$item->title}}</h4>
                                <span><b>{{$item->year}}</b></span><br>
                                Type :{{$item->type}}
                                <p>{{$item->power}} | {{$item->dimension}}</p>
                            </td>
                        </tr>
                </table>
                <a href="{{url('type/'.str_replace(' ','-',strtolower($item->title)).'-type-'.$item->id)}}" class="readmore stretched-link mt-auto"></a>
            </div>
        </div>
         @endforeach    

      </div>

    </div>

</section>
@endsection