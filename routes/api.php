<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('task')->middleware('auth:sanctum')->group(function () {
    Route::get('mytasks', [TaskController::class, 'index']);
    Route::post('new', [TaskController::class, 'store']);
    Route::post('assign', [TaskController::class, 'assignStore']);
    Route::put('update/{id}', [TaskController::class, 'update'])->whereNumber('id');
    Route::put('status/{id} ', [TaskController::class, 'editStatus'])->whereNumber('id');
    Route::delete('/{id}', [TaskController::class, 'destroy'])->whereNumber('id');
});

