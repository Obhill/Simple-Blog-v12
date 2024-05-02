<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;

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

Route::resource('comments', CommentController::class);
Route::resource('posts', PostController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('redirect.after.login');

Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showloginform'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

Route::redirect('/', 'posts');

Route::post('post/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/users/{user}/comments', [UserController::class, 'showComments'])->name('users.comments');

Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

Route::put('/posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/posts/create', 'PostController@create')->middleware('admin')->name('posts.create');