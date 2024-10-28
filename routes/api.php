<?php

use App\Http\Controllers\AditionalPointsController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthenticateUserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', AuthenticateUserId::class])->group(function () {
  Route::post('/pipereport', [DatabaseController::class, 'createDatabase'])->middleware(AdminMiddleware::class);
  Route::get('/pipereports', [DatabaseController::class, 'getAllDatabases']);

  Route::post('/user', [UserController::class, 'createUser'])->middleware(AdminMiddleware::class);
  Route::get('/users', [UserController::class, 'getAllUsers'])->middleware(AdminMiddleware::class);
  Route::get('/user/{id}', [UserController::class, 'getUser']);
  Route::put('/user/{id}', [UserController::class, 'updateUser']);
  Route::delete('/user/{id}', [UserController::class, 'deleteUser'])->middleware(AdminMiddleware::class);

  Route::get('/setnewpassword/{id}', [UserController::class, 'setNewPassword']);
  Route::get('/logout', [LoginController::class, 'logout']);
});
