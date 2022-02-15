<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\GenerationImage;
use App\Models\GenerationDetail;

class TypeController extends Controller
{
    //
    public function index($slug)
    {
        $id = substr($slug, strpos($slug, 'type-')+5);
        $data['type'] = Type::where('generation_id',$id)->get();
        $data['image'] = GenerationImage::where('generation_id',$id)->get();
        $data['detail'] = GenerationDetail::where('generation_id',$id)->get();
        //dd($data);
        if(empty($data))
        {
            return redirect(url('/'));
        }
        return view('front.main.type',$data);
    }
}
