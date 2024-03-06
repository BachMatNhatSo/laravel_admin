<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KhachHangController;

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

Route::get('/',[HomeController::class,'index']);
Route::get('books',[HomeController::class,'getAllBooks']);
Route::get('api/getdbbook',[HomeController::class,'getAllBooksjson']);
Route::get('gotoinsertbook',[HomeController::class,'gotoinsertbookform']);
Route::post('add-book',[HomeController::class,'adding']);

Route::get('/users',[KhachHangController::class,'get']);