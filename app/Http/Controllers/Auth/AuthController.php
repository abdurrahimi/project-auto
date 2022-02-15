<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleMenu;
use App\Models\Roles;
use Hash;

class AuthController extends Controller
{
    //

    public function Admin()
    {
        if(Auth::check()){
            return redirect(url('admin/dashboard'));
        }
        return view('auth/admin');
    }

    public function Auth(Request $request)
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                "status" => "OK",
                "msg" => "Berhasil Login",
            ]);
        }


        return response()->json([
            "status" => "FAILED",
            "msg" => "Username or password does not match",
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/admin/login'));
    }
}
