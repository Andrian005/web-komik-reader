<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Title;
use App\Models\Chapter;
use App\Models\ChapterPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    public function create($comic_title_id)
    {
        $title = 'Create Chapter Page';
        $data = Title::select('id', 'title')->find($comic_title_id);
        return view('admin.chapter_halaman.create', compact('title', 'data'));
    }

    public function store(Request $request, $comic_title_id)
    {
        try {
            $releaseDate = Carbon::parse($request->release_date)->format('Y-m-d');

            $chapter = Chapter::create([
                'title_id' => $comic_title_id,
                'chapter_number' => $request->chapter_number,
                'chapter_title' => $request->chapter_title,
                'release_date' => $releaseDate,
                'views' => 0,
            ]);

            $titleModel = Title::findOrFail($comic_title_id);
            $uploadedFiles = json_decode($request->input('uploaded_files'), true);
            if (is_array($uploadedFiles) && count($uploadedFiles) > 0) {
                $title = Str::slug($titleModel->title);
                $chapterTitle = Str::slug($request->chapter_title ?? 'chapter');
                $pageNumber = 1;

                foreach ($uploadedFiles as $filename) {
                    $oldPath = 'chapter-pages/tmp/' . $filename;
                    $newFilename = $title . '-' . $chapterTitle . '-' . $pageNumber . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                    $newPath = 'chapter-pages/' . $newFilename;

                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->move($oldPath, $newPath);
                        ChapterPage::create([
                            'chapter_id' => $chapter->id,
                            'page_number' => $pageNumber++,
                            'image_path' => $newFilename,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Chapter berhasil disimpan.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function viewChapter($comic_title_id)
    {
        $title = 'View Chapter';
        $data = Title::with([
            'chapters' => function ($q) {
                $q->with('chapterPages')->orderBy('chapter_number', 'asc');
            }
        ])->findOrFail($comic_title_id);

        return view('admin.chapter_halaman.view_chapter', compact('title', 'data'));
    }
}
