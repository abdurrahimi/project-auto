<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenerationImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'generation_image';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
