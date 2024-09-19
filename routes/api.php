<?php

use App\Http\Controllers\AditionalPointsController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthenticateUserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user', [UserController::class, 'createUser']);
Route::post('/passrecover', [UserController::class, 'passwordRecover']);
Route::get('/consulttoken/{token}', [UserController::class, 'consultToken']);
Route::put('/changepassword', [UserController::class, 'changePassword']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/pipereport', [DatabaseController::class, 'createDatabase']);
Route::get('/pipereports', [DatabaseController::class, 'getAllDatabases']);
Route::get('/pipereport/{id}', [DatabaseController::class, 'getDatabase']);
Route::delete('/pipereport/{id}', [DatabaseController::class, 'deleteDatabase']);

Route::middleware(['auth:sanctum', AuthenticateUserId::class])->group(function () {
  Route::get('/users', [UserController::class, 'getAllUsers'])->middleware(AdminMiddleware::class); 
  Route::get('/adminusers', [UserController::class, 'getAllAdminUsers'])->middleware(AdminMiddleware::class); 
  Route::get('/user/{id}', [UserController::class, 'getUser']);
  Route::put('/user/{id}', [UserController::class, 'updateUser']);
  Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
  Route::get('/logout', [LoginController::class, 'logout']);
});
