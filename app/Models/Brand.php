<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brand';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function model()
    {
        return $this->hasMany('App\Models\Models','brand_id','id');
    }
}
