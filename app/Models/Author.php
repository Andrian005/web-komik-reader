<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'authors';
    protected $fillable = ['name', 'slug', 'bio', 'photo'];
}
