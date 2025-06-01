<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;

    protected $primary_key = 'id';
    protected $table = 'chapters';
    protected $fillable = ['title_id', 'chapter_number', 'chapter_title', 'release_date', 'views'];

    public function chapterPages()
    {
        return $this->hasMany(ChapterPage::class, 'chapter_id', 'id');
    }

}
