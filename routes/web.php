<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {return view('index');})->middleware('AlreadyLoggedIn');
Route::post('/register-user',[UserController::class,'register_user'])->name('register-user');
Route::post('/login-user',[UserController::class,'login_user'])->name('login-user');
Route::get('/logout',[UserController::class, 'logout'])->middleware('isLoggedIn');
Route::get('/game', function () {return view('game');})->middleware('isLoggedIn');