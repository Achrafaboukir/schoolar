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
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Get the teacher who created the course.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')
                    ->whereHas('role', function($query) {
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
     * Get the students enrolled in the course.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student')
                    ->whereHas('role', function($query) {
                        $query->where('is_student', true);
                    })
                    ->withTimestamps();
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
}
