<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Title;
use App\Models\Chapter;
use App\Models\ChapterPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    public function create($comic_title_id)
    {
        $title = 'Create Chapter Page';
        $data = Title::with('chapters')->findOrFail($comic_title_id);
        $lastChapterNumber = $data->chapters->max('chapter_number') ?? 0;
        $nextChapterNumber = floor($lastChapterNumber) == $lastChapterNumber
            ? $lastChapterNumber + 1
            : ceil($lastChapterNumber);
        return view('admin.chapter.create', compact('title', 'data', 'nextChapterNumber'));
    }

    public function store(Request $request, $titleId)
    {
        $validator = Validator::make($request->all(), [
            'chapter_number' => [
                'required',
                'regex:/^\d+(\.\d+)?$/',
                Rule::unique('chapters')->where(fn($q) => $q->where('title_id', $titleId)),
            ],
            'chapter_title' => 'required|string|max:255',
            'release_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $chapter = Chapter::create([
                'title_id' => $titleId,
                'chapter_number' => $request->chapter_number,
                'chapter_title' => $request->chapter_title,
                'release_date' => $request->release_date,
                'views' => 0,
            ]);

            $files = json_decode($request->input('chapter_pages'), true);

            if (is_array($files) && !empty($files)) {
                $slugTitle = Str::slug(Title::findOrFail($titleId)->title);
                $slugChapter = Str::slug($request->chapter_title ?? 'chapter');
                $pageNum = 1;

                foreach ($files as $file) {
                    $tmpPath = "chapter-pages/tmp/{$file}";

                    if (!Storage::disk('public')->exists($tmpPath)) {
                        continue;
                    }

                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $newFile = "{$slugTitle}-{$slugChapter}-{$pageNum}-" . now()->timestamp . '-' . Str::random(4) . ".{$ext}";
                    $newPath = "chapter-pages/{$newFile}";

                    Storage::disk('public')->move($tmpPath, $newPath);

                    ChapterPage::create([
                        'chapter_id' => $chapter->id,
                        'page_number' => $pageNum++,
                        'image_path' => $newFile,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Chapter berhasil disimpan.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function viewChapter(Request $request, $comic_title_id)
    {
        $title = 'View Chapter';

        $data = Title::findOrFail($comic_title_id);

        $chapters = Chapter::where('title_id', $comic_title_id)
            ->with('chapterPages')
            ->orderBy('chapter_number', 'asc')
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.partial.chapter-list', compact('data','chapters'))->render();
        }

        return view('admin.chapter.view', compact('title', 'data', 'chapters'));
    }

    public function edit(Chapter $chapter)
    {
        $title = 'Edit Chapter';

        $chapter = Chapter::with('chapterPages')->findOrFail($chapter->id);
        $chapterPages = $chapter->chapterPages()->orderBy('page_number', 'desc')->get()
    ->map(function ($page) {
        $disk = Storage::disk('public');
        $filePath = 'chapter-pages/' . $page->image_path;
        return [
            'filename' => $page->image_path,
            'size' => $disk->exists($filePath) ? $disk->size($filePath) : 0,
        ];
    })
    ->toArray();

        return view('admin.chapter.edit', compact('title', 'chapter', 'chapterPages'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        $validator = Validator::make($request->all(), [
            'chapter_number' => [
                'required',
                'regex:/^\d+(\.\d+)?$/',
                Rule::unique('chapters')->where(function ($q) use ($chapter) {
                    return $q->where('title_id', $chapter->title_id)
                        ->where('id', '<>', $chapter->id);
                }),
            ],
            'chapter_title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'ordered_files' => 'required|json',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $slugChapter = Str::slug($request->chapter_title);
            $slugTitle = Str::slug(Title::findOrFail($chapter->title_id)->title);

            $chapter->update([
                'chapter_number' => $request->chapter_number,
                'chapter_title' => $request->chapter_title,
                'chapter_slug' => $slugChapter,
                'release_date' => $request->release_date,
            ]);

            $files = json_decode($request->ordered_files, true);

            foreach ($chapter->chapterPages as $page) {
                if (!in_array($page->image_path, $files)) {
                    Storage::disk('public')->delete('chapter-pages/' . $page->image_path);
                    $page->delete();
                }
            }

            foreach ($files as $i => $file) {
                $pageNum = $i + 1;
                $page = $chapter->chapterPages()->where('image_path', $file)->first();

                if ($page) {
                    $oldFile = $page->image_path;
                    $ext = pathinfo($oldFile, PATHINFO_EXTENSION);
                    $newFile = "{$slugTitle}-{$slugChapter}-{$pageNum}-" . now()->timestamp . '-' . Str::random(4) . ".{$ext}";

                    $oldPath = "chapter-pages/{$oldFile}";
                    $newPath = "chapter-pages/{$newFile}";

                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->move($oldPath, $newPath);
                        $page->update([
                            'page_number' => $pageNum,
                            'image_path' => $newFile,
                        ]);
                    } else {
                        $page->update(['page_number' => $pageNum]);
                    }
                } else {
                    $tmp = 'chapter-pages/tmp/' . $file;
                    if (!Storage::disk('public')->exists($tmp)) {
                        continue;
                    }

                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $newFile = "{$slugTitle}-{$slugChapter}-{$pageNum}-" . now()->timestamp . '-' . Str::random(4) . ".{$ext}";
                    $newPath = 'chapter-pages/' . $newFile;

                    Storage::disk('public')->move($tmp, $newPath);

                    ChapterPage::create([
                        'chapter_id' => $chapter->id,
                        'page_number' => $pageNum,
                        'image_path' => $newFile,
                    ]);
                }
            }

            $pages = $chapter->chapterPages()->orderBy('page_number', 'desc')->get()->map(function ($page) {
                $path = 'chapter-pages/' . $page->image_path;
                return [
                    'filename' => $page->image_path,
                    'size' => Storage::disk('public')->exists($path)
                        ? Storage::disk('public')->size($path)
                        : 0,
                ];
            });

            DB::commit();
            return response()->json([
                'message' => 'Chapter berhasil diperbarui.',
                'chapterPages' => $pages,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($chapter)
    {
        DB::beginTransaction();
        try {
            $chapter = Chapter::with('chapterPages')->findOrFail($chapter);

            foreach ($chapter->chapterPages as $page) {
                if ($page->image_path && Storage::disk('public')->exists('chapter-pages/' . $page->image_path)) {
                    Storage::disk('public')->delete('chapter-pages/' . $page->image_path);
                }
            }
            $chapter->chapterPages()->delete();
            $chapter->forceDelete();

            DB::commit();
            return response()->json([
                'message' => 'Chapter berhasil dihapus.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus Chapter',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
