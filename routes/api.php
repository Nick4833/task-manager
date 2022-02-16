<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/authenticated', function (Request $request) {
    return true;
});

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout']);


/* Routes for Todon't List Items */
Route::get('/items', [ItemController::class, 'index']);
Route::get('/completed', [ItemController::class, 'completed']);
Route::get('/inprogress', [ItemController::class, 'inProgress']);
Route::get('/numbers', [ItemController::class, 'numbers']);

Route::get('/projects/{id}', [ItemController::class, 'show']);
Route::get('/projects/inprogress/{id}', [ItemController::class, 'showProgress']);
Route::get('/projects/completed/{id}', [ItemController::class, 'showCompleted']);
Route::get('/projects/numbers/{id}', [ItemController::class, 'showNumbers']);

Route::prefix('/item')->group(function() {
    Route::post('/store', [ItemController::class, 'store']);
    Route::put('/{id}', [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);
});

/* Routes for Todon't List categories */
Route::get('/categories', [CategoryController::class, 'index']);

Route::prefix('/category')->group(function() {
    Route::post('/store', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::get('/meetings', [MeetingController::class, 'index']);

Route::prefix('/meeting')->group(function() {
    Route::post('/store', [MeetingController::class, 'store']);
    Route::put('/{id}', [MeetingController::class, 'update']);
    Route::delete('/{id}', [MeetingController::class, 'destroy']);
});