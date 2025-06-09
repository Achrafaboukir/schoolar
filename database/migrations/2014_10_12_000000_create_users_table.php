<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('number')->unique();
            $table->integer('group_id');
            $table->string('password');
            $table->date('date_of_birth');
            $table->string('photo')->nullable();
            $table->string('cv')->nullable();
            $table->integer('role_id')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('users');
    }
}