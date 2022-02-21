<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'model';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}
