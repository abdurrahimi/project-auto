<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserManagementController extends Controller
{
    //

    public function admin(Request $req)
    {
        if($req->ajax()){
            $user = User::where('role_id',1)->get();
            return response()->json([
                'status'=>"OK",
                "data"=>$user
            ]);
        }
        $data['title'] = "Admin";
        return view("admin.user-management.index",$data);
    }

    public function user(Request $req)
    {
        if($req->ajax()){
            $user = User::where('role_id',2)->get();
            return response()->json([
                'status'=>"OK",
                "data"=>$user
            ]);
        }
        $data['title'] = "User";
        return view("admin.user-management.index",$data);
    }

    public function store(Request $req)
    {
        
        

        if(!empty($req->id)){
            $data = $req->validate([
                'username' => 'required|max:50',
                'name' => 'required',
                'email' => 'required|email'
            ]);

            $user = User::find($req->id);
        }else{
            $data = $req->validate([
                'username' => 'required|unique:users|max:50',
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);

            $user = new User();
            $user->password = Hash::make($data['password']);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'];

        if($req->title == "Admin")
        {
            $user->role_id = 1;
        }else{
            $user->role_id = 2;
        }

        if($user->save()){
            return response()->json([
                "status" => "OK",
                "msg"   => "data saved successfully"
            ]);
        }

        return response()->json([
            "status" => "FAILED",
            "msg"   => "Error, please contact the author for support!"
        ]); 
    }
}
