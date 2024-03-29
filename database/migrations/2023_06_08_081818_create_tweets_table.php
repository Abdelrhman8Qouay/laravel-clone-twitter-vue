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
            $table->text('tweet')->nullable();
            $table->string('file')->nullable();
            $table->enum('is_video', ['e', 'n', 'y'])->default('e'); // e >> empty, n >> no, y >> yes.
            $table->enum('visible', ['a', 'f', 'p'])->default('a'); // a >> all, f >> friends only, p >> private.
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
