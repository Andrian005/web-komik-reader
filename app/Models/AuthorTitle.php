<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorTitle extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'author_title';
    protected $fillable = ['author_id', 'title_id'];
}
