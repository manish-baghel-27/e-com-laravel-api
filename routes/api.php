<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/learn-events', [HomeController::class, 'index']);

// post
Route::post('store-post',[PostController::class,'store_post']);
Route::post('get-posts',[PostController::class,'get_posts']);
Route::get('get-single-post/{id}',[PostController::class,'getSinglePost']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
