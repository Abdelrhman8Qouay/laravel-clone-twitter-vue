<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\Tweet;
use App\Models\User;

define('PAGINATION_COUNT', 10);

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


// Note: {name} >> send handle name of user not the name of user.

// -------------- Main Page Twitter ------------
Route::get('/', function() {
    return Inertia::render('WelcomeOnly');
})->name('welcome');
// -------------- User Tweets Pages & Store & Destroy ------------
Route::get('/home', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
// -------------- Tweet Show ------------
Route::get('/{name}/status/{tweet_id}', [\App\Http\Controllers\TweetController::class, 'show'])->name('tweets.show');


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


    // -------------- Store Tweet >> Tweet class -------------
    Route::post('/tweets', [\App\Http\Controllers\TweetController::class, 'store'])->name('tweets.store');
    // -------------- Destroy Tweet >> Tweet class -------------
    Route::delete('/tweets/{id}', [\App\Http\Controllers\TweetController::class, 'destroy'])->name('tweets.destroy');
    // -------------- Likes ( attach , detach ) toggling method >> Tweet class -------------
    Route::post('/tweets/{tweet_id}/likes', [\App\Http\Controllers\TweetController::class, 'toggleLikes'])->name('tweets.likes');
    // -------------- Retweeting ( attach , detach ) toggling method >> Tweet class -------------
    Route::post('/tweets/{tweet_id}/retweeting', [\App\Http\Controllers\TweetController::class, 'toggleRetweets'])->name('tweets.retweeting');
    // -------------- bookmarking ( attach , detach ) toggling method >> Tweet class -------------
    Route::post('/tweets/{tweet_id}/bookmarking', [\App\Http\Controllers\TweetController::class, 'toggleBookmarks'])->name('tweets.bookmarks');
    // -------------- bookmarking ( attach , detach ) toggling method >> Tweet class -------------
    Route::post('/tweets/{tweet_id}/viewed', [\App\Http\Controllers\TweetController::class, 'toggleViewed'])->name('tweets.viewed');
    // -------------- bookmarking ( attach , detach ) toggling method >> Tweet class -------------
    Route::post('/tweets/{tweet_id}/pinned', [\App\Http\Controllers\TweetController::class, 'togglePin'])->name('tweets.pinned');


    // -------------- add reply for tweet >> Reply class -------------
    Route::post('/tweets/{tweet_id}/addreply', [\App\Http\Controllers\ReplyController::class, 'store'])->name('replies.store');
    // -------------- Likes ( attach , detach ) toggling method >> Reply class -------------
    Route::post('/replies/{reply_id}/likes', [\App\Http\Controllers\ReplyController::class, 'toggleLikes'])->name('replies.likes');
    // -------------- bookmarking ( attach , detach ) toggling method >> Reply class -------------
    Route::post('/replies/{reply_id}/bookmarking', [\App\Http\Controllers\ReplyController::class, 'toggleBookmarks'])->name('replies.bookmarks');
    // -------------- viewed ( attach , detach ) toggling method >> Reply class -------------
    Route::post('/replies/{reply_id}/viewed', [\App\Http\Controllers\ReplyController::class, 'toggleViewed'])->name('replies.viewed');


    // -------------- Profile Default Pages ------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
