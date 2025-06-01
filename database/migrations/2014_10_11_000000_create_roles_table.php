<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_teacher')->default(false);
            $table->boolean('is_student')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_super_admin')->default(false);
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Has complete access to all features',
                'is_super_admin' => true,
                'is_admin' => true,
                'is_teacher' => false,
                'is_student' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Has access to administrative features',
                'is_super_admin' => false,
                'is_admin' => true,
                'is_teacher' => false,
                'is_student' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
                'description' => 'Has access to teaching features',
                'is_super_admin' => false,
                'is_admin' => false,
                'is_teacher' => true,
                'is_student' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Has access to student features',
                'is_super_admin' => false,
                'is_admin' => false,
                'is_teacher' => false,
                'is_student' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}; 