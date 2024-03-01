<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return view('welcome');
});

Route::controller(AuthController::class)->middleware('guest')->group(function() {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/verify/{user}', 'showVerifyForm')
        ->where('user', '[0-9]+')
        ->name('verify');
    Route::post('/verify/{user}', 'verify')->where('user', '[0-9]+');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/home', fn() => view('home'))->name('home');
    Route::get('/profile', fn() => view('home'))->name('user.profile');
    //        Route::post('/logout', 'logout')->name('logout');
});

Route::get('/verify/notify', fn() => 'Notice')
    ->middleware('auth')
    ->name('verify.notice');
