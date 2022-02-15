<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GenerationDetail;
use App\Models\GenerationImage;
use App\Models\Type;

class TypeController extends Controller
{
    //
    public function index($id,Request $req)
    {
        
        if($req->ajax()){
            $datas = Type::where('generation_id',$id)->get();
            return response()->json([
                'status'=>"OK",
                "data"=>$datas
            ]);
        }
        $data = [
            "image" => GenerationImage::where('generation_id',$id)->get(),
            "detail" => GenerationDetail::where('generation_id',$id)->first()
        ];
        return view('admin.type.index',$data);
    }
}
