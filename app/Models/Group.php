<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'department',
        'year',
        'status',
        'description'
    ];

    /**
     * Get the students in this group.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student')
                    ->withTimestamps();
    }

    /**
     * Get the teachers assigned to this group.
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'group_teacher')
                    ->whereHas('role', function($query) {
                        $query->where('is_teacher', true);
                    })
                    ->withTimestamps();
    }

    /**
     * Get the courses for this group.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
} 