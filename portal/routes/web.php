<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
    'login' => true, // Email Verification Routes...
]);

Route::group(['middleware' => ['web']], function () {
    Route::get('/request-login/{token}/{email}', [LoginController::class, 'requestLogin'])->name('requestLogin');
});

/**
 * apiAuth is a custom middleware which work on session of the api user data
 */
Route::group(['middleware' => ['web', 'apiAuth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/change-email', [HomeController::class, 'changeEmail'])->name('changeEmail');
    Route::post('/change-email-submit', [HomeController::class, 'changeEmailSubmit'])->name('changeEmailSubmit');
});


