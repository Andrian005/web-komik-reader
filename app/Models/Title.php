<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use SoftDeletes;
    
    protected $primary_key = 'id';
    protected $table = 'titles';
    protected $fillable = [
        'title',
        'slug',
        'type',
        'author',
        'artist',
        'status',
        'synopsis',
        'genre_id',
        'cover_image',
        'released_year',
        'country',
        'views',
        'rating',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_title', 'title_id', 'author_id');
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_title', 'title_id', 'artist_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'title_genre', 'title_id', 'genre_id');
    }

}
