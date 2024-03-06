<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\MuonTraController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    
Route::get('/',[HomeController::class,'index']);

Route::get('books',[HomeController::class,'getAllBooks']);
Route::get('getdbbook',[HomeController::class,'getAllBooksjson']);
Route::post('/books', [HomeController::class, 'store']);
Route::put('/books/update/{id}',[HomeController::class,'update']);
Route::delete('/books/delete/{id}',[HomeController::class,'delete']);


Route::get('/users',[KhachHangController::class,'get']);
Route::get('/users/get',[KhachHangController::class,'getAllUser']);
Route::post('/users',[KhachHangController::class,'insert']);
Route::put('/users/update/{id}',[KhachHangController::class,'update']);
Route::delete('/users/delete/{id}',[KhachHangController::class,'delete']);

Route::get('/muonsach',[MuonTraController::class,'index']);
Route::get('/muonsach/get',[MuonTraController::class,'getAll']);
Route::get('/getIds',[MuonTraController::class,'dropdowlist']);
Route::post('/muonsach/them',[MuonTraController::class,'insert']);
Route::delete('/muonsach/xoa/{id}',[MuonTraController::class,'delete']);
});


Route::prefix('login')->group(function(){
    Route::get('/',[UserController::class,'index'])->name('login');
    Route::post('/',[UserController::class,'login']);
});