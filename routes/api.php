<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\CommonController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/init', [SetupController::class, 'init']);
Route::get('/show_tables', [SetupController::class, 'show_tables']);
Route::get('/getall/{e}', [SetupController::class, 'getall']);

Route::post('/insert', [CommonController::class, 'insert']);
Route::post('/update', [CommonController::class, 'update']);
Route::post('/delete', [CommonController::class, 'delete']);
Route::get('/getw/{e}/{f}/{v}', [CommonController::class, 'getw']);