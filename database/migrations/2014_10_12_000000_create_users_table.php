<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_of_birth');
            $table->string('photo')->nullable();
            $table->string('cv')->nullable(); // For teachers
            $table->string('baccaloriat')->nullable(); // For students
            $table->string('department')->nullable(); // For teachers
            $table->string('group_id')->nullable(); // For students
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}; 