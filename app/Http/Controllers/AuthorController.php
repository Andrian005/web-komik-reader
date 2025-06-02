<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Author';
        if ($request->ajax()) {
            $query = Author::all();
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return $row->id;
                })
                ->make(true);
        }
        return view('admin.master_data.author.index', compact('title'));
    }

    public function view($id)
    {
        $data = Author::find($id);
        return view('admin.master_data.author.view', compact('data'));
    }

    public function create()
    {
        return view('admin.master_data.author.create');
    }

    public function store(AuthorRequest $request)
    {
        $validated = $request->validated();
        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $validated['slug'] . '-' . time() . '.' . $extension;
                $file->storeAs('photo_author', $filename, 'public');
            }

            $data = Author::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'bio' => $validated['bio'],
                'photo' => $filename ?? null
            ]);

            return response()->json([
                'message' => 'Author berhasil ditambahkan.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan Author',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Author::findOrFail($id);
        return view('admin.master_data.author.edit', compact('data'));
    }

    public function update(AuthorRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $author = Author::findOrFail($id);

            if ($request->hasFile('photo')) {
                if ($author->photo && Storage::disk('public')->exists('photo_author/' . $author->photo)) {
                    Storage::disk('public')->delete('photo_author/' . $author->photo);
                }

                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $validated['slug'] . '-' . time() . '.' . $extension;
                $file->storeAs('photo_author', $filename, 'public');
            } else {
                $filename = $author->photo;
            }

            $author->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'bio' => $validated['bio'],
                'photo' => $filename ?? null
            ]);

            return response()->json([
                'message' => 'Author berhasil diperbarui.',
                'data' => $author
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui Author',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $data = Author::find($id);
            $data->delete();

            return response()->json([
                'message' => 'Author Berhasil di hapus',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus Author',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
