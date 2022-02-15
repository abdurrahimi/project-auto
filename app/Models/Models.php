<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
    protected $table = 'model';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}
