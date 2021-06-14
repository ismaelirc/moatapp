<?php

use Illuminate\Http\Request;
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
Route::get('/', [App\Http\Controllers\LoginController::class, 'index'])->name('login');

/**
 * Login and registration routes
 */
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'authenticate'])->name('login');
Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'store'])->name('register');

Route::group(['middleware' => ['jwt.verify']], function() {
    /**
     * General routes
     */
    Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    /**
     * Albums routes
     */
    Route::get('/album/new', [App\Http\Controllers\AlbumController::class, 'create'])->name('album.new');
    Route::get('/album/{token?}/{id?}', [App\Http\Controllers\AlbumController::class, 'index'])->name('album');
    Route::post('/album/new', [App\Http\Controllers\AlbumController::class, 'store'])->name('album.create');
    Route::post('/album/update/{id?}/{token?}', [App\Http\Controllers\AlbumController::class, 'update'])->name('album.update');
    Route::get('/album/update/{id?}/{token?}', [App\Http\Controllers\AlbumController::class, 'edit'])->name('album.edit');
    Route::delete('/album/delete/{id?}/{token?}', [App\Http\Controllers\AlbumController::class, 'destroy'])->name('album.delete');
});