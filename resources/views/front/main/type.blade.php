@extends('front.layouts.main')
@section('content')
<section id="pricing" class="pricing">

    <div class="container aos-init aos-animate" data-aos="fade-up">

      <header class="section-header">
        <h2>Generation</h2>
        <p>Generation For - </p>
      </header>
      <ul id="lightSlider">
          @foreach ($image as $item)
            <li>
                <img src="{{url($item->image)}}">
            </li>
          @endforeach
        
        
      </ul>

      <div class="row gy-4 aos-init aos-animate" data-aos="fade-left">
        @foreach ($type as $item)
        <div class="col-lg-12 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="box" style="padding:30px; text-align: left;">
                <table style="width:100%">
                        <tr>
                            <td>
                                {{-- <img src="{{url($item->image)}}"> --}}
                                <h4>{{$item->title}}</h4>
                            </td>
                            <td style="padding-left: 20px; text-align:right">
                                <span><b>{{$item->year}}</b></span><br>
                                {{-- Type :{{$item->type}} --}}
                                <p><?=$item->detail?></p>
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
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
      $("#lightSlider").lightSlider({
        item: 4,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 10,
      }); 
    });
  </script>
@endsection