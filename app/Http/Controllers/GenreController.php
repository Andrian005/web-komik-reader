<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $title = 'Genre';
        return view('admin.genre.index', compact('title'));
    }
}
