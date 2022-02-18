<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'generation_detail';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
