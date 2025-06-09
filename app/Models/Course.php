<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'group_id',
        'start_date',
        'end_date',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the teacher who created the course.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')->whereHas('role', function($query) {
            $query->where('is_teacher', true);
        });
    }

    /**
     * Get the group this course belongs to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the students enrolled in the course through their group.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Group::class);
    }

    /**
     * Get the feedback for the course.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the quizzes for the course.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the documents for the course.
     */
    public function documents()
    {
        return $this->hasMany(CourseDocument::class);
    }
}
