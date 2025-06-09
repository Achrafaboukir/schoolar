<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->tinyInteger('is_teacher')->default(0);
            $table->tinyInteger('is_admin')->default(0);
            $table->string('permissions');
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        // Insert default roles
        DB::table('roles')->insert([
            [
                'name' => 'Administrator',
                'is_teacher' => 0,
                'is_admin' => 1,
                'permissions' => 'all',
                'is_deleted' => 0,
                'created_at' => now()
            ],
            [
                'name' => 'Teacher',
                'is_teacher' => 1,
                'is_admin' => 0,
                'permissions' => 'teacher',
                'is_deleted' => 0,
                'created_at' => now()
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
} 