<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseDocumentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'required|file|max:102400', // 100MB max
            'file_type' => 'required|in:video,image,pdf'
        ]);

        $course = Course::findOrFail($courseId);
        $file = $request->file('document');
        
        $document = new CourseDocument([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_type' => $request->file_type,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize()
        ]);

        // Store file in appropriate directory based on type
        $path = $file->store("courses/{$course->id}/documents", 'public');
        $document->file_path = $path;
        $document->save();

        return response()->json([
            'message' => 'Document uploaded successfully',
            'document' => $document
        ]);
    }

    public function destroy($id)
    {
        $document = CourseDocument::findOrFail($id);
        
        // Delete the file from storage
        Storage::disk('public')->delete($document->file_path);
        
        $document->update(['is_deleted' => true]);
        
        return response()->json([
            'message' => 'Document deleted successfully'
        ]);
    }
}
