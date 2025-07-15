<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CourseDocumentController extends Controller
{
    /**
     * Display a listing of documents for a course.
     */
    public function index(Course $course)
    {
        $query = $course->documents()->where('is_deleted', false);
        
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        
        $documents = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('courses.documents.index', compact('course', 'documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function createForm(Course $course)
    {
        return view('courses.documents.create-ajax', compact('course'));
    }

    /**
     * Store a newly created document.
     */
    public function store(Request $request, Course $course)
    {
        try {
            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or missing file.',
                ], 422);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'file_type' => 'required|in:video,image,pdf',
                'document' => 'required|file|mimes:pdf,jpeg,jpg,png,mp4,avi,mov,webm|max:10240',
            ]);

            $file = $request->file('document');
            $extension = strtolower($file->getClientOriginalExtension());

            $validExtensions = [
                'video' => ['mp4', 'avi', 'mov', 'webm'],
                'image' => ['jpeg', 'jpg', 'png'],
                'pdf' => ['pdf']
            ];

            if (!in_array($extension, $validExtensions[$validated['file_type']])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Extension does not match file type.',
                ], 422);
            }

            $path = $file->store('documents', 'public');

            $document = $course->documents()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_type' => $validated['file_type'],
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_deleted' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => $document,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred while uploading the document.',
                'errors' => ['document' => [$e->getMessage()]],
            ], 500);
        }
    }


    /**
     * Show the form for editing a document.
     */
    public function editForm(Course $course, CourseDocument $document)
    {
        return view('courses.documents.edit-ajax', compact('course', 'document'));
    }

    /**
     * Update the specified document.
     */
    public function update(Request $request, Course $course, CourseDocument $document)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'file_type' => 'required|in:video,image,pdf',
                'document' => [
                    'nullable',
                    'file',
                    'mimes:pdf,jpeg,jpg,png,mp4,avi,mov,webm',
                    'max:10240', // 10MB max
                ],
            ]);

            $document->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_type' => $validated['file_type'],
            ]);

            // Handle file update if new file is uploaded
            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                // Delete old file
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                // Store new file
                $file = $request->file('document');
                $path = $file->store('documents', 'public');
                
                $document->update([
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Document updated successfully',
                'document' => $document,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Document update error: ' . $e->getMessage(), [
                'exception' => $e,
                'document_id' => $document->id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred while updating the document.',
                'errors' => ['document' => ['Server error: ' . $e->getMessage()]],
            ], 500);
        }
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Course $course, CourseDocument $document)
    {
        try {
            Log::info('Attempting to delete document', [
                'document_id' => $document->id,
                'file_path' => $document->file_path
            ]);
            
            // Delete the file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
                Log::info('File deleted from storage', ['path' => $document->file_path]);
            } else {
                Log::warning('File not found in storage', ['path' => $document->file_path]);
            }
            
            // Mark as deleted instead of hard delete
            $document->update(['is_deleted' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error deleting document', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download the specified document.
     */
    public function download(Course $course, CourseDocument $document)
    {
        try {
            if ($document->is_deleted) {
                return response()->json(['error' => 'Document not found'], 404);
            }
            
            // Check if this is a student request and verify access
            if (session('student_id')) {
                $student = \App\Models\Student::find(session('student_id'));
                if (!$student || $student->group_id !== $course->group_id) {
                    return response()->json(['error' => 'Access denied'], 403);
                }
            }
            
            $filePath = $document->file_path;
            
            if (!Storage::disk('public')->exists($filePath)) {
                Log::error('File not found for download', [
                    'document_id' => $document->id,
                    'file_path' => $filePath
                ]);
                return response()->json(['error' => 'File not found'], 404);
            }
            
            $fileName = $document->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
            
            Log::info('Document downloaded', [
                'document_id' => $document->id,
                'file_path' => $filePath
            ]);
            
            return Storage::disk('public')->download($filePath, $fileName, [
                'Content-Type' => $document->mime_type ?? 'application/octet-stream'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error downloading document', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to download document: ' . $e->getMessage()
            ], 500);
        }
    }
}