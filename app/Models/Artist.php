<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'artists';
    protected $fillable = ['name', 'slug', 'bio', 'photo'];
}
