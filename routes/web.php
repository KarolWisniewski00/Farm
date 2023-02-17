<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\FriendshipsController;

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

//INDEX
Route::get('/', function () {return view('index');})->middleware('AlreadyLoggedIn');

//LOGIN/REGISTER
Route::post('/register-user',[UserController::class,'register_user'])->name('register-user');
Route::post('/login-user',[UserController::class,'login_user'])->name('login-user');
Route::get('/logout',[UserController::class, 'logout'])->middleware('isLoggedIn');

//GAME
Route::get('/game', [GameController::class, 'game'])->name('game')->middleware('isLoggedIn');
Route::post('/game-update', [GameController::class, 'game_update'])->name('game-update');

//ACCOUNT
Route::get('/account', [UserController::class, 'account'])->name('account')->middleware('isLoggedIn');
Route::get('/friends', [UserController::class, 'friends'])->name('friends')->middleware('isLoggedIn');
Route::get('/characters', [UserController::class, 'characters'])->name('characters')->middleware('isLoggedIn');
Route::get('/admin', [UserController::class, 'admin'])->name('admin')->middleware('isLoggedIn');

Route::get('/character-{id}', [GameController::class, 'character'])->name('character-{id}')->middleware('isLoggedIn');
Route::get('/account-edit', [UserController::class, 'account_edit'])->name('account-edit')->middleware('isLoggedIn');
Route::post('/account-edit-user', [UserController::class, 'account_edit_user'])->name('account-edit-user')->middleware('isLoggedIn');
Route::get('/account-delete', [UserController::class, 'account_delete'])->name('account-delete')->middleware('isLoggedIn');

Route::post('/friend-add', [FriendshipsController::class, 'friend_add'])->name('friend-add')->middleware('isLoggedIn');
Route::post('/friend-update', [FriendshipsController::class, 'friend_update'])->name('friend-update')->middleware('isLoggedIn');
