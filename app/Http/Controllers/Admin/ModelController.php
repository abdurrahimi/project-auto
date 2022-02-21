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

    public function store(Request $req)
    {
        if($req->ajax()){
            if(isset($req->id) && !empty($req->id)){
                $model = Models::find($req->id);
            }else{
                $model = new Models();
            }

            $model->brand_id = $req->brand_id;
            $model->model = $req->model;
            if($req->image !== null){
                $imageName = $req->model.'.'.$req->image->extension();
                $req->image->move(public_path('assets/photos/model'), $imageName);
                $model->image = 'public/assets/photos/model/'.$imageName;
            }
            if($model->save()){
                return response()->json([
                    "status" => "OK",
                    "msg"   =>"Data successfully saved"
                ]);
            }else{
                return response()->json([
                    "status" => "FAILED",
                    "msg"   => "Error, please contact the author for support!"
                ]);
            }
        }
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
