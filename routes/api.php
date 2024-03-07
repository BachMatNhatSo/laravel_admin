<?php

use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MuonTraController;
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

Route::middleware(['custom.api'])->group(function () {
    
Route::get('/',[HomeController::class,'index']);

Route::get('books',[HomeController::class,'getAllBooks']);
Route::get('getdbbook',[HomeController::class,'getAllBooksjson_api']);
Route::post('/books', [HomeController::class, 'insert_api']);
Route::put('/books/update/{id}',[HomeController::class,'update_api']);
Route::delete('/books/delete/{id}',[HomeController::class,'delete_api']);


Route::get('/users',[KhachHangController::class,'get']);
Route::get('/users/get',[KhachHangController::class,'getAllUser_api']);
Route::post('/users',[KhachHangController::class,'insert_api']);
Route::put('/users/update/{id}',[KhachHangController::class,'update_api']);
Route::delete('/users/delete/{id}',[KhachHangController::class,'delete_api']);


Route::get('/muonsach/toDateFromDate',[MuonTraController::class,'searchTDFT']);
Route::get('/muonsach',[MuonTraController::class,'index']);
Route::get('/muonsach/get',[MuonTraController::class,'getAll_api']);
Route::get('/getIds',[MuonTraController::class,'dropdowlist']);
Route::post('/muonsach/them',[MuonTraController::class,'insert_api']);
Route::put('/muonsach/capnhat/{id}',[MuonTraController::class,'update_api']);
Route::delete('/muonsach/xoa/{id}',[MuonTraController::class,'delete_api']);




});