<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/login',function(){
    return view('login');
});

//註冊登入
Route::get('/google-login', [AuthController::class, 'googleLogin'])->name('google.login');
Route::get('/google-callback', [AuthController::class, 'googleCallback'])->name('google.callback');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

