<?php

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

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'authenticate'])->name('login');
Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'store'])->name('register');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/album', [App\Http\Controllers\AlbumController::class, 'index'])->name('album');
    Route::get('/album/new', [App\Http\Controllers\AlbumController::class, 'create'])->name('album.new');
    Route::post('/album/new', [App\Http\Controllers\AlbumController::class, 'store'])->name('album.create');
    Route::post('/album/update', [App\Http\Controllers\AlbumController::class, 'update'])->name('album.update');
});