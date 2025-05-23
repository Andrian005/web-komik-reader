<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Genre';
        if ($request->ajax()) {
            $query = Genre::All();
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.genre.index', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres,slug',
        ], [
            'nama.required' => 'Nama Harus di Isi',
            'slug.required' => 'Slug Harus di Isi',
            'slug.unique' => 'Slug sudah digunakan, gunakan slug lain',
        ]);

        $genre = Genre::create([
            'name' => $validated['nama'],
            'slug' => $validated['slug'],
        ]);

        return response()->json([
            'message' => 'Genre berhasil ditambahkan.',
            'data' => $genre
        ]);
    }
}
