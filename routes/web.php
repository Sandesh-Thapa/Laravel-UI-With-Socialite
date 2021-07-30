<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialMediaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'user.auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
});

//prefix
Route::prefix('login')->group(function () { 
    // Sociolite routes
    Route::get('/{provider}', [SocialMediaController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [SocialMediaController::class, 'handleProviderCallback']);
});






