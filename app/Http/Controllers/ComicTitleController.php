<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Genre;
use App\Models\Title;
use App\Models\Artist;
use App\Models\Author;
use App\Models\TitleGenre;
use App\Models\ArtistTitle;
use App\Models\AuthorTitle;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TitleRequest;
use Illuminate\Support\Facades\Storage;

class ComicTitleController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen Comic Titles';
        if ($request->ajax()) {
            $query = Title::select(['id', 'title', 'slug', 'type', 'released_year', 'country', 'views', 'rating', 'status', 'created_at'])
                ->whereIn('type', ['manga', 'manhua', 'manhwa'])
                ->with(['authors:id,name', 'artists:id,name', 'genres:id,name']);
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return $row->id;
                })
                ->addColumn('views', function ($row) {
                    return $row->views ?? 0;
                })
                ->addColumn('rating', function ($row) {
                    return $row->rating ?? 0;
                })
                ->addColumn('authors', function ($row) {
                    return $row->authors->pluck('name')->join(', ');
                })
                ->addColumn('artists', function ($row) {
                    return $row->artists->pluck('name')->join(', ');
                })
                ->addColumn('genres', function ($row) {
                    return $row->genres->pluck('name')->join(', ');
                })
                ->addColumn('status', function ($row) {
                    $class = match ($row->status) {
                        'ongoing' => 'badge bg-success',
                        'completed' => 'badge bg-primary',
                        'hiatus' => 'badge bg-warning text-dark',
                        default => 'badge bg-secondary',
                    };
                    return '<span class="' . $class . '">' . ucfirst($row->status) . '</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.comic_title.index', compact('title'));
    }

    public function view($id)
    {
        $data = Title::select(['id', 'title', 'slug', 'type', 'released_year', 'country', 'views', 'rating', 'status', 'cover_image', 'synopsis', 'created_at'])
            ->with(['authors:id,name', 'artists:id,name', 'genres:id,name'])->find($id);
        return view('admin.comic_title.view', compact('data'));
    }

    public function create()
    {
        $title = 'Create Judul';
        $data['genres'] = Genre::select(['id', 'name'])->get();
        $data['authors'] = Author::select(['id', 'name'])->get();
        $data['artists'] = Artist::select(['id', 'name'])->get();

        return view('admin.comic_title.create', compact('title', 'data'));
    }

    public function store(TitleRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $extension = $file->getClientOriginalExtension();
                $filename = $validated['slug'] . '-' . time() . '.' . $extension;
                $file->storeAs('covers', $filename, 'public');
            }

            $data = Title::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'synopsis' => $validated['synopsis'],
                'cover_image' => $filename,
                'released_year' => $validated['released_year'],
                'country' => $validated['country']
            ]);

            foreach (['author_id' => AuthorTitle::class, 'artist_id' => ArtistTitle::class, 'genre_id' => TitleGenre::class] as $key => $model) {
                if ($request->has($key)) {
                    $records = collect($request->$key)->map(function ($id) use ($key, $data) {
                        $column = str_replace('_id', '', $key) . '_id';
                        return ['title_id' => $data->id, $column => $id];
                    })->toArray();
                    $model::insert($records);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menambah Title',
                'data' => [
                    'id' => $data->id,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan title.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $title = 'Edit Judul';
        $data = Title::select(['id', 'title', 'slug', 'type', 'released_year', 'country', 'views', 'rating', 'status', 'synopsis', 'cover_image', 'created_at'])
            ->with(['authors', 'artists', 'genres'])->find($id);
        $data->author_id = $data->authors->pluck('id')->toArray();
        $data->artist_id = $data->artists->pluck('id')->toArray();
        $data->genre_id = $data->genres->pluck('id')->toArray();

        $data['genres'] = Genre::select(['id', 'name'])->get();
        $data['authors'] = Author::select(['id', 'name'])->get();
        $data['artists'] = Artist::select(['id', 'name'])->get();

        return view('admin.comic_title.edit', compact('title', 'data'));
    }

    public function update(TitleRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $data = Title::findOrFail($id);
            if (!$request->hasFile('cover_image') && $data->cover_image) {
                $oldPath = 'covers/' . $data->cover_image;
                $extension = pathinfo($data->cover_image, PATHINFO_EXTENSION);
                $newFilename = $validated['slug'] . '-' . time() . '.' . $extension;
                $newPath = 'covers/' . $newFilename;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->move($oldPath, $newPath);
                    $filename = $newFilename;
                } else {
                    $filename = $data->cover_image;
                }
            }

            $data->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'synopsis' => $validated['synopsis'],
                'cover_image' => $filename,
                'released_year' => $validated['released_year'],
                'country' => $validated['country']
            ]);

            $relationMap = [
                'author_id' => [AuthorTitle::class, 'author_id'],
                'artist_id' => [ArtistTitle::class, 'artist_id'],
                'genre_id' => [TitleGenre::class, 'genre_id'],
            ];

            foreach ($relationMap as $key => [$model, $column]) {
                $model::where('title_id', $data->id)->forceDelete();
                if ($request->has($key)) {
                    $records = collect($request->$key)->map(function ($id) use ($column, $data) {
                        return ['title_id' => $data->id, $column => $id];
                    })->toArray();
                    $model::insert($records);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil mengupdate Title',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal mengupdate title.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $title = Title::find($id);
            $title->delete();
            ArtistTitle::where('title_id', $id)->delete();
            AuthorTitle::where('title_id', $id)->delete();
            TitleGenre::where('title_id', $id)->delete();

            DB::commit();
            return response()->json([
                'message' => 'Title Berhasil di hapus',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus Title',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
