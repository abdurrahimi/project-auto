<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleMenu;

class DashboardController extends Controller
{
    //
    function index()
    {
        $menu = session()->get('userData.menu');
        
        return view('admin.dashboard.index');
    }
}
