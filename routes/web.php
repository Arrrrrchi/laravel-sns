<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserPageController;




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


Route::get('/', function () {
    return view('welcome');
});

/* 記事管理 */
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('/articles', ArticleController::class)->except(['index','show'])->middleware('auth');
Route::resource('/articles', ArticleController::class)->only(['show']);
Route::prefix('articles')->name('articles.')->group(function(){
    Route::put('/{article}/like', [ArticleController::class, 'like'])->name('like')->middleware('auth');
    Route::delete('/{article}/like', [ArticleController::class, 'unlike'])->name('unlike')->middleware('auth');
});

/* タグ別記事一覧 */
Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');

/* ユーザー管理 */
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

/* ログイン */
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/* パスワードリセット */
Route::prefix('password_reset')->name('password_reset.')->group(function () {
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/', [PasswordController::class, 'emailFormResetPassword'])->name('form'); // パスワードリセットメール送信フォームページ
        Route::post('/', [PasswordController::class, 'sendEmailResetPassword'])->name('send'); // メール送信処理
        Route::get('/send_complete', [PasswordController::class, 'sendComplete'])->name('send_completed'); // メール送信完了ページ
    });
    Route::get('/edit', [PasswordController::class, 'edit'])->name('edit'); // パスワード再設定ページ
    Route::post('/update', [PasswordController::class, 'update'])->name('update'); // パスワード更新処理
    Route::get('/edited', [PasswordController::class, 'edited'])->name('edited'); // パスワード更新終了ページ
});

/* ユーザー情報 */
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/{name}', [UserPageController::class, 'show'])->name('show');
    Route::get('/{name}/likes', [UserPageController::class, 'likes'])->name('likes');

    /* フォロー機能 */
    Route::middleware('auth')->group(function () {
        Route::put('/{name}/follow', [UserPageController::class, 'follow'])->name('follow');
        Route::delete('/{name}/follow', [UserPageController::class, 'unfollow'])->name(('unfollow'));
    });
});