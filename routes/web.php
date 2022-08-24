<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'guest'],function(){
Route::get('login',[AuthController::class,'index'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('register',[AuthController::class,'register_view'])->name('register');
Route::post('register',[AuthController::class,'register'])->name('register');
Route::get('forget-password',[AuthController::class,'getEmail'])->name('forget-password');
Route::post('forget-password',[AuthController::class,'postEmail'])->name('forget-password');
Route::get('reset-password/{token}', [AuthController::class, 'ResetPassword'])->name('ResetPasswordGet');
Route::post('reset-password', [AuthController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');


});
Route::group(['middleware'=>'auth'],function(){
Route::get('home',[AuthController::class,'home'])->name('home');
Route::get('logout',[AuthController::class,'logout'])->name('logout');
});