<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models;
use App\Models\Brand;

class ModelController extends Controller
{
    //

    public function index($id, Request $req)
    {
        $data['brand'] = Brand::find($id)->first();
        if($req->ajax()){
            $models = Models::with(['brand'])->where('brand_id',$id)->get();
            return response()->json([
                'status'=>"OK",
                "data"=>$models
            ]);
        }
        return view('admin.model.index',$data);
    }

    public function store()
    {
        //tba
    }

    public function delete($id)
    {
        if(Models::find($id)->delete()){
            return response()->json([
                "status" => "OK",
                "msg"   =>"Data has been deleted"
            ]);
        }else{
            return response()->json([
                "status" => "FAILED",
                "msg"   => "Error, please contact the author for support!"
            ]);
        }
    }
}
