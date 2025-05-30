<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtistTitle extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'artist_title';
    protected $fillable = ['artist_id', 'title_id'];
}
