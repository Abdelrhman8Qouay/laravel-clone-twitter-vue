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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->text('tweet');
            $table->string('file')->nullable();
            $table->boolean('is_video')->nullable();
            $table->enum('visible', [0, 1, 2])->default(0);
            $table->integer('comments');
            $table->integer('retweets');
            $table->integer('likes');
            $table->integer('analytics');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
