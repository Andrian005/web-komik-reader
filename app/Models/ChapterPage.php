<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterPage extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'chapter_pages';
    protected $fillable = ['chapter_id', 'page_number', 'image_path'];
}
