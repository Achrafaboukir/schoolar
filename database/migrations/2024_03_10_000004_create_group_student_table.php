<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupStudentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_student', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('group_id');
            $table->integer('student_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            // Add unique constraint instead of foreign keys
            $table->unique(['group_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_student');
    }
}
