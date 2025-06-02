<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Genre;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GenreRequest;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Genre';
        if ($request->ajax()) {
            $query = Genre::all();
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return $row->id;
                })
                ->make(true);
        }
        return view('admin.master_data.genre.index', compact('title'));
    }

    public function view($id)
    {
        $data = Genre::findOrFail($id);
        return view('admin.master_data.genre.view', compact('data'));
    }

    public function create()
    {
        return view('admin.master_data.genre.create');
    }

    public function store(GenreRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $genre = Genre::create([
                'name' => $validated['nama'],
                'slug' => $validated['slug'],
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Genre berhasil ditambahkan.',
                'data' => $genre
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menyimpan genre.'], 500);
        }
    }

    public function edit($id)
    {
        $data = Genre::findOrFail($id);
        return view('admin.master_data.genre.edit', compact('data'));
    }

    public function update(GenreRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $data = Genre::findOrFail($id);

            $data->update([
                'name' => $validated['nama'],
                'slug' => $validated['slug'],
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Genre berhasil diupdate.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal mengupdate genre.'], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = Genre::find($id)->delete();

            DB::commit();
            return response()->json([
                'message' => 'Genre berhasil didelete.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menghapus genre.'], 500);
        }
    }
}
