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
        Schema::create('tweets_replies', function (Blueprint $table) {
            $table->id();
            $table->text('reply')->nullable();
            $table->string('file')->nullable();
            $table->enum('is_video', ['e', 'n', 'y'])->default('e'); // e >> empty, n >> no, y >> yes.
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('tweet_id')->unsigned();
            $table->unsignedBigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tweet_id')->references('id')->on('tweets')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets_replies');
    }
};
