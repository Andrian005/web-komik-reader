<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen Genre';
        if ($request->ajax()) {
            $query = Genre::all();
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return $row->id;
                })
                ->make(true);
        }
        return view('admin.genre.index', compact('title'));
    }

    public function view($id)
    {
        $data = Genre::findOrFail($id);
        return view('admin.genre.view', compact('data'));
    }

    public function create()
    {
        return view('admin.genre.create');
    }

    public function store(GenreRequest $request)
    {
        $validated = $request->validated();
        try {
            $genre = Genre::create([
                'name' => $validated['nama'],
                'slug' => $validated['slug'],
            ]);

            return response()->json([
                'message' => 'Genre berhasil ditambahkan.',
                'data' => $genre
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan genre.'], 500);
        }
    }

    public function edit($id)
    {
        $data = Genre::findOrFail($id);
        return view('admin.genre.edit', compact('data'));
    }

    public function update(GenreRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            $data = Genre::findOrFail($id);

            $data->update([
                'name' => $validated['nama'],
                'slug' => $validated['slug'],
            ]);

            return response()->json([
                'message' => 'Genre berhasil diupdate.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate genre.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $data = Genre::find($id)->delete();
            return response()->json([
                'message' => 'Genre berhasil didelete.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Gagal menghapus genre.'], 500);
        }
    }
}
