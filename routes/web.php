<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\Tweet;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// -------------- User Tweets Pages & Store & Destroy ------------
Route::get('/', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
Route::post('/tweets', [\App\Http\Controllers\TweetController::class, 'store'])->name('tweets.store');
Route::delete('/tweets/{id}', [\App\Http\Controllers\TweetController::class, 'destroy'])->name('tweets.destroy');


// -------------- Auth Middleware Group ------------
Route::middleware('auth')->group(function () {
    // -------------- User Profile Index ------------
    Route::get('/all', [UserController::class, 'index'])->name('users.index');
    // -------------- User Profile All Follows ------------
    Route::get('/profilee/{name}/{what}', [UserController::class, 'showFollowingFollowers'])->name('users.allfollows');
    // -------------- User Profile Show ------------
    Route::get('/profilee/{name}', [UserController::class, 'show'])->name('profiling.show');
    // -------------- User Profile Update ------------
    Route::put('/profiling', [UserController::class, 'update'])->name('profiling.update');
    // -------------- following & followers ( attach , detach ) toggling methods -------------
    Route::post('/profilee/{user_id}/follow', [UserController::class, 'toggleFollow'])->name('users.togglefollow');

    // -------------- Profile Default Pages ------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
