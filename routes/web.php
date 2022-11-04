<?php

use App\Http\Controllers\Admin\PostsImageUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsCommentsController;
use App\Http\Controllers\PostsController;
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

Route::get('/', [HomeController::class, 'index']);
Route::resource('posts', PostsController::class)->except('show')->middleware('admin');
Route::post('upload', [PostsImageUploadController::class, 'upload'])->name('upload')->middleware('admin');
Route::get('posts/{post}', [PostsController::class, 'show'])->name('posts.show');
Route::resource('posts.comments', PostsCommentsController::class)->middleware('auth');

Auth::routes();
