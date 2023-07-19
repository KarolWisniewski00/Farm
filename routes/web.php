<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FriendshipsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ChatController;

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
Route::get('/forget',[ResetPasswordController::class, 'forget'])->name('forget');
Route::post('/forget-mail',[ResetPasswordController::class, 'forget_mail'])->name('forget-mail');

//GAME
Route::get('/game', [GameController::class, 'game'])->name('game')->middleware('isLoggedIn');
Route::post('/game-update', [GameController::class, 'game_update'])->name('game-update')->middleware('isLoggedIn');
Route::get('/game-{id}', [GameController::class, 'game'])->name('game-update')->middleware('isLoggedIn');

//CHAT
Route::get('/chat-get', [ChatController::class, 'get']);
Route::post('/chat-post', [ChatController::class, 'post'])->name('chat-post');

//ACCOUNT
Route::get('/account', [AccountController::class, 'account'])->name('account')->middleware('isLoggedIn');
Route::get('/friends', [AccountController::class, 'friends'])->name('friends')->middleware('isLoggedIn');
Route::get('/characters', [AccountController::class, 'characters'])->name('characters')->middleware('isLoggedIn');
Route::get('/admin', [AccountController::class, 'admin'])->name('admin')->middleware('AdminCheck');
Route::get('/marketplace', [AccountController::class, 'marketplace'])->name('marketplace')->middleware('isLoggedIn');
Route::post('/marketplace-add', [MarketplaceController::class, 'marketplace_add'])->name('marketplace-add')->middleware('isLoggedIn');
Route::get('/marketplace-cancel-{id}', [MarketplaceController::class, 'marketplace_cancel'])->name('marketplace-cancel-{id}')->middleware('isLoggedIn');
Route::get('/marketplace-accept-{id}', [MarketplaceController::class, 'marketplace_accept'])->name('marketplace-accept-{id}')->middleware('isLoggedIn');

Route::get('/character-{id}', [GameController::class, 'character'])->name('character-{id}')->middleware('isLoggedIn');
Route::get('/account-edit', [AccountController::class, 'account_edit'])->name('account-edit')->middleware('isLoggedIn');
Route::post('/account-edit-user', [AccountController::class, 'account_edit_user'])->name('account-edit-user')->middleware('isLoggedIn');
Route::get('/account-delete', [AccountController::class, 'account_delete'])->name('account-delete')->middleware('isLoggedIn');

Route::post('/friend-add', [FriendshipsController::class, 'friend_add'])->name('friend-add')->middleware('isLoggedIn');
Route::post('/friend-update', [FriendshipsController::class, 'friend_update'])->name('friend-update')->middleware('isLoggedIn');

Route::get('/edit-{id}', [AccountController::class, 'account_edit_admin'])->name('edit-{id}')->middleware('AdminCheck');
Route::post('/edit-admin', [AccountController::class, 'account_edit_user_admin'])->name('edit-admin')->middleware('AdminCheck');
Route::get('/delete-{id}', [AccountController::class, 'delete'])->name('edit')->middleware('AdminCheck');
