<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/* generales */
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* usuarios */
Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
Route::get('/perfil/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
/* ruta para ver todos los usuarios */
Route::get('/gente/{search?}', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');



/* imagenes */
Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.file');
Route::get('/imagen/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');
Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/imagen/editar/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');
/* metodo para actualizar imagen de la publicacion */
Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');


/* comentarios */
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');


/* ruta de likes */
Route::get('/like/{image_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('dislike.delete');
Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');



