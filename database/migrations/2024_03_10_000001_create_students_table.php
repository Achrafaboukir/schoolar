<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('student_number')->unique();
            $table->string('password');
            $table->integer('group_id');
            $table->date('date_of_birth');
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
} 