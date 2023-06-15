<?php

// use App\Http\Controllers\ProfileController;
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

Route::get('/', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
Route::post('/tweets', [\App\Http\Controllers\TweetController::class, 'store'])->name('tweets.store');
Route::delete('/tweets/{id}', [\App\Http\Controllers\TweetController::class, 'destroy'])->name('tweets.destroy');



Route::middleware('auth')->group(function () {
    Route::get('/profiling/{name}', function($name) {
        return Inertia::render('Profiling', [
            'user_own' => User::where('name', '=',$name)->first(),
            'check_auth' => auth()->check(),
            'user_auth' => auth()->user(),
        ]);
    })->name('profiling.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
