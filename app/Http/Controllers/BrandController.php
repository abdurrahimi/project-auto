<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use DB;

class BrandController extends Controller
{
    //
    public function index($name)
    {
        $model = Brand::with('model')->whereRaw('LOWER(brand) = "'.strtolower($name).'"')->first();
        foreach($model->model as $item){
            $data['key'][] = substr($item->model,0,1); 
            $data['model'][substr($item->model,0,1)][] = $item;

        }
        $data['brand'] = $model;

       return view('front.main.model',$data);
    }
}
