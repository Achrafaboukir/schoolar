<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'student_number',
        'password',
        'date_of_birth',
        'photo',
        'status',
        'baccaloriat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    /**
     * Get the role associated with the student.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the groups this student belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student')
                    ->withTimestamps();
    }

    /**
     * Get the courses this student is enrolled in through their groups.
     */
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            Group::class,
            'id', // Foreign key on group_student table...
            'group_id', // Foreign key on courses table...
            'id', // Local key on students table...
            'id' // Local key on groups table...
        );
    }

    /**
     * Get the feedback provided by the student.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the quiz responses submitted by the student.
     */
    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class);
    }
}