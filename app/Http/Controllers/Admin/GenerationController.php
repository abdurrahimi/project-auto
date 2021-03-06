<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models;
use App\Models\Generation;
use App\Models\GenerationDetail;

class GenerationController extends Controller
{
    //
    public function index($id, Request $req)
    {
        $data['detail'] = Models::with(['brand'])->where('id',$id)->first();
        if($req->ajax()){
            $generation = Generation::where('model_id',$id)->get();
            return response()->json([
                'status'=>"OK",
                "data"=>$generation
            ]);
        }
        return view('admin.generation.index',$data);
    }

    public function store()
    {
        //tba
    }

    public function delete($id)
    {
        if(Generation::find($id)->delete()){
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
