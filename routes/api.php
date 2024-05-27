<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/registers', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/logout', [AuthController::class, 'logout']); 

// Route Note
Route::post('/create-note', [NoteController::class, 'store']);
Route::get('/notes', [NoteController::class, 'index']);
Route::get('/notes/{slug}', [NoteController::class, 'show']);
Route::put('/update-note/{slug}', [NoteController::class, 'update']);
Route::delete('/delete-note/{slug}', [NoteController::class, 'destroy']);
Route::get('/update-pinned/{slug}', [NoteController::class, 'updateIsPinned']);
});