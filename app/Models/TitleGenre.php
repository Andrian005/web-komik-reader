<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitleGenre extends Model
{
    protected $primary_key = 'id';
    protected $table = 'title_genre';
    protected $fillable = ['title_id', 'genre_id'];
}
