<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterPageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('chapter_pages')) {
            $file = $request->file('chapter_pages');
            if (is_array($file)) {
                $file = $file[0];
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '-' . uniqid() . '-' . Str::slug($originalName) . '.' . $extension;
            $file->storeAs('chapter-pages/tmp', $filename, 'public');

            return response($filename, 200);
        }
        return response('No file uploaded', 400);
    }


    public function delete(Request $request)
    {
        $filename = $request->getContent();
        $tmpPath = 'chapter-pages/tmp/' . $filename;

        if ($filename && Storage::disk('public')->exists($tmpPath)) {
            Storage::disk('public')->delete($tmpPath);
            return response('File deleted', 200);
        }

        return response('File not found', 404);
    }

}
