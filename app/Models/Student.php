<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

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
        'group_id',
        'date_of_birth',
        'photo',
        'status',
        'is_deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
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
     * Get the student's group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the student's courses through their group.
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, Group::class);
    }

    /**
     * Get the student's full name.
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get the student's feedback.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}