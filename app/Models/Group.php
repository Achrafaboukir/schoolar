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
        'department_id',
        'year',
        'status',
        'description',
        'is_deleted'
    ];

    protected $casts = [
        'year' => 'integer',
        'status' => 'boolean',
        'department_id' => 'integer',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the students in this group.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the teachers assigned to this group.
     */
    public function teachers()
    {
        return $this->hasMany(User::class)->whereHas('role', function($query) {
            $query->where('is_teacher', true);
        });
    }

    /**
     * Get the courses for this group.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
} 