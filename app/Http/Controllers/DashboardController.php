<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\TopBrand;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $data['brand'] = TopBrand::with('brand')->get();
        return view('front.main.index',$data);
    }
}
