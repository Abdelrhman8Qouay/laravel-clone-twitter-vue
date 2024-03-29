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
            $table->string('name');
            $table->string('handle_name')->unique();
            $table->boolean('blue_mark')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website_url')->nullable();
            $table->string('head_image')->default('/uploads/users/heads/empty_head.jpg');
            $table->string('avatar')->default('/uploads/users/avatars/empty_user.png');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
