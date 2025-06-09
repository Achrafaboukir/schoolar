<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'number',
        'group_id',
        'password',
        'date_of_birth',
        'photo',
        'cv',
        'role_id',
        'status',
        'is_deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'boolean',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->role->is_admin;
    }

    /**
     * Check if the user is a teacher.
     */
    public function isTeacher()
    {
        return $this->role->is_teacher;
    }

    /**
     * Get the courses that the user teaches (if teacher).
     */
    public function teachingCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Get the user's group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the courses that the user is enrolled in (if student).
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
                    ->withTimestamps();
    }

    /**
     * Get the feedback provided by the user.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
