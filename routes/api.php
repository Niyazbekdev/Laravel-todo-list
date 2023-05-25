<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){
    Route::post('/SignUp', [UserController::class, 'register']);
    Route::post('/SignIn', [UserController::class, 'login']);
});
Route::middleware('auth:sanctum')
    ->prefix('/tasks')
    ->group(function(){
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::patch('/{id}', [TaskController::class, 'update']);
        Route::put('/{id}', [TaskController::class, 'edit']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
    });

