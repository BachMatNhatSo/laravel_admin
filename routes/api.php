<?php

use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KhachHangController;

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

Route::post('/books', [HomeController::class, 'store']);
Route::put('/books/update/{id}',[HomeController::class,'update']);
Route::delete('/books/delete/{id}',[HomeController::class,'delete']);


Route::get('/users',[KhachHangController::class,'post']);
Route::post('/users',[KhachHangController::class,'insert']);
Route::put('/users/update/{id}',[KhachHangController::class,'update']);
Route::delete('/users/delete/{id}',[KhachHangController::class,'delete']);