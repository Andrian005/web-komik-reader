<?php

namespace App\Http\Controllers;

use App\Models\ChapterPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterPageController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('chapter_pages')) {
            return response('No file uploaded', 400);
        }

        $files = $request->file('chapter_pages');
        if (is_array($files)) {
            $file = $files[0];
        } else {
            $file = $files;
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $filename = time() . '-' . uniqid() . '-' . Str::slug($originalName) . '.' . $extension;
        $file->storeAs('chapter-pages/tmp', $filename, 'public');
        return response($filename, 200);
    }

    public function delete(Request $request)
    {
        $filename = trim($request->getContent());
        $tmpPath = 'chapter-pages/tmp/' . $filename;
        if (!$filename || !Storage::disk('public')->exists($tmpPath)) {
            return response('File not found', 404);
        }
        Storage::disk('public')->delete($tmpPath);
        return response('File deleted', 200);
    }
}
