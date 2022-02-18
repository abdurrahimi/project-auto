<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopBrand extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'top_brand';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

}
