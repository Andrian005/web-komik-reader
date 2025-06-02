<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Artist;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArtistRequest;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Artist';
        if ($request->ajax()) {
            $query = Artist::all();
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return $row->id;
                })
                ->make(true);
        }
        return view('admin.master_data.artist.index', compact('title'));
    }
    public function view($id)
    {
        $data = Artist::find($id);
        return view('admin.master_data.artist.view', compact('data'));
    }

    public function create()
    {
        return view('admin.master_data.artist.create');
    }

    public function store(ArtistRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $validated['slug'] . '-' . time() . '.' . $extension;
                $file->storeAs('photo_artist', $filename, 'public');
            }

            $data = Artist::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'bio' => $validated['bio'],
                'photo' => $filename ?? null
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Artist berhasil ditambahkan.',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menambahkan Artist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Artist::findOrFail($id);
        return view('admin.master_data.artist.edit', compact('data'));
    }

    public function update(ArtistRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $artist = Artist::findOrFail($id);

            if ($request->hasFile('photo')) {
                if ($artist->photo && Storage::disk('public')->exists('photo_artist/' . $artist->photo)) {
                    Storage::disk('public')->delete('photo_artist/' . $artist->photo);
                }

                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $validated['slug'] . '-' . time() . '.' . $extension;
                $file->storeAs('photo_artist', $filename, 'public');
            } else {
                $filename = $artist->photo;
            }

            $artist->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'bio' => $validated['bio'],
                'photo' => $filename ?? null
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Artist berhasil diperbarui.',
                'data' => $artist
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui Artist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = Artist::find($id);
            $data->delete();

            DB::commit();
            return response()->json([
                'message' => 'Artist Berhasil di hapus',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus Artist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
