<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'title',
        'content',
        'rating',
        'is_anonymous',
        'is_deleted'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_anonymous' => 'boolean',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the student who submitted the feedback.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course the feedback is for.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
