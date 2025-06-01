<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question',
        'options_json',
        'correct_answer',
    ];

    /**
     * Get the course that the quiz belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the responses for the quiz.
     */
    public function responses()
    {
        return $this->hasMany(QuizResponse::class);
    }
}
