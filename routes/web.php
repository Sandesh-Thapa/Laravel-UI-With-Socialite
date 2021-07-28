<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialMediaController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');


// Sociolite routes
//google
Route::get('/login/google', [SocialMediaController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialMediaController::class, 'handleGoogleCallback']);

//facebook
Route::get('/login/facebook', [SocialMediaController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [SocialMediaController::class, 'handleFacebookCallback']);

//github
Route::get('/login/github', [SocialMediaController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [SocialMediaController::class, 'handleGithubCallback']);

//Linkedin
Route::get('/login/linkedin', [SocialMediaController::class, 'redirectToLinkedin'])->name('login.linkedin');
Route::get('/login/linkedin/callback', [SocialMediaController::class, 'handleLinkedinCallback']);

//twitter
Route::get('/login/twitter', [SocialMediaController::class, 'redirectToLinkedin'])->name('login.twitter');



