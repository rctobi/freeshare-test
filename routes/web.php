<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;

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

// トップページの表示
Route::get('/', [TweetController::class, 'index'])->name('tweet.index');
// 投稿画面の表示
Route::get('/create', [TweetController::class, 'create'])->name('tweet.create');
// 投稿データの登録
Route::post('/store', [TweetController::class, 'store'])->name('tweet.store');
// 詳細画面の表示
Route::get('/detail/{id}', [TweetController::class, 'show'])->name('tweet.show');
// 編集画面の表示
Route::get('/edit/{id}', [TweetController::class, 'edit'])->name('tweet.edit');
// 編集データの登録
Route::post('/update', [TweetController::class, 'update'])->name('tweet.update');
// 投稿データの削除
Route::post('/destroy/{id}', [TweetController::class, 'destroy'])->name('tweet.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
