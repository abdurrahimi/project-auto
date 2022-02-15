<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationImage extends Model
{
    use HasFactory;
    protected $table = 'generation_image';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
