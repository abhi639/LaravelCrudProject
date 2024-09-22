<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::middleware('auth:api')->get('logout','logout');

});
//Route::apiResource('/users',UserController::class);
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/getpostbyid',[PostController::class,'show']);
    Route::get('/getposts',[PostController::class,'index']);
    Route::delete('/deletePost',[PostController::class,'destroy']);
    Route::put('/updatePost',[PostController::class,'update']);
    Route::post('/addPost',[PostController::class,'store']);
  
});
