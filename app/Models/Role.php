<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_teacher',
        'is_admin',
        'permissions',
        'is_deleted'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_teacher' => 'boolean',
        'is_admin' => 'boolean',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
} 