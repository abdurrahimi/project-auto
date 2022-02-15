<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generation;

class GenerationController extends Controller
{
    //

    public function index($slug)
    {
        $id = substr($slug, strpos($slug, 'model-')+6);
        $data['generation'] = Generation::where('model_id',$id)->get();
        if(empty($data))
        {
            return redirect(url('/'));
        }
        return view('front.main.generation',$data);
    }
}
