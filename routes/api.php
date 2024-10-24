<?php

use App\Http\Controllers\AditionalPointsController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthenticateUserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/pipereport', [DatabaseController::class, 'createDatabase']);
Route::get('/pipereports', [DatabaseController::class, 'getAllDatabases']);

Route::post('/user', [UserController::class, 'createUser']);
Route::get('/users', [UserController::class, 'getAllUsers']); 
Route::get('/user/{id}', [UserController::class, 'getUser']);

Route::post('/login', [LoginController::class, 'login']);
Route::get('/consulttoken/{token}', [UserController::class, 'consultToken']);
Route::get('/setnewpassword/{id}', [UserController::class, 'setNewPassword']);
Route::delete('/user/{id}', [UserController::class, 'deleteUser']);


Route::middleware(['auth:sanctum', AuthenticateUserId::class])->group(function () {
 //Route::get('/users', [UserController::class, 'getAllUsers'])->middleware(AdminMiddleware::class); 
  Route::put('/user/{id}', [UserController::class, 'updateUser']);
  Route::get('/logout', [LoginController::class, 'logout']);
});
