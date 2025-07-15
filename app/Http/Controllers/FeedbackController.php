<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Display a listing of the feedbacks
    public function index(Request $request)
    {
        // TODO: Add permission check for 'access_feedbacks'
        $query = \App\Models\Feedback::with(['student', 'course', 'course.teacher', 'course.group']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%$search%")
                  ->orWhereHas('student', function($q2) use ($search) {
                      $q2->where('firstname', 'like', "%$search%")
                         ->orWhere('lastname', 'like', "%$search%")
                         ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%$search%"]);
                  })
                  ->orWhereHas('course', function($q2) use ($search) {
                      $q2->where('title', 'like', "%$search%")
                         ->orWhereHas('teacher', function($q3) use ($search) {
                             $q3->where('firstname', 'like', "%$search%")
                                ->orWhere('lastname', 'like', "%$search%")
                                ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%$search%"]);
                         });
                  });
            });
        }

        if ($request->filled('anonymity') && in_array($request->anonymity, ['anonymous', 'shown'])) {
            if ($request->anonymity === 'anonymous') {
                $query->where('is_anonymous', true);
            } else {
                $query->where('is_anonymous', false);
            }
        }

        $feedbacks = $query->latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    // Remove the specified feedback from storage
    public function destroy($id)
    {
        // TODO: Add permission check for 'delete_feedback'
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully.');
    }
} 