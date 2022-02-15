<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;
    protected $table = 'role_menu';
    public $timestamps = false;
    protected $primaryKey = 'id';

    function menu()
    {
        return $this->hasMany('App\Models\Menu','id');
    }
}
