<?php

use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;




Route::prefix('web')->group(function () {
    //註冊登入
    Route::get('/google-login',[AuthController::class,'googleLogin']);
    Route::get('/google-callback',[AuthController::class,'googleCallback']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware(['member.authenticate'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/check-login', [AuthController::class, 'checkLogin']);
        //會員
        Route::prefix('auth')->group(function () {
            Route::post('/edit', [AuthController::class, 'edit']);
        });
        //文章
        Route::prefix('article')->group(function () {
            Route::post('/add', [ArticleController::class, 'add']);
        });
        //文章留言
        Route::prefix('article-comment')->group(function () {
            Route::post('/add', [ArticleCommentController::class, 'add']);
        });
    });
    //文章
    Route::prefix('article')->group(function () {
        Route::get('/get-list', [ArticleController::class, 'index']);
        Route::get('/get/{id}', [ArticleController::class, 'get']);
    });
    //文章留言
    Route::prefix('article-comment')->group(function () {
        Route::get('/get-list', [ArticleCommentController::class, 'index']);
    });
});
