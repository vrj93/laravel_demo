<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;

Route::get('/signup', [SignupController::class, 'index'])->name('signup');
Route::post('/signup', [SignupController::class, 'store']);

Route::get('/', [UserController::class, 'index'])->name('login');
Route::post('/', [UserController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
Route::post('/upload', [DashboardController::class, 'imageupload'])->name('upload')->middleware('auth');
Route::put('/users/{id}', [DashboardController::class, 'edit'])->name('edit')->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin', [AdminController::class, 'store']);

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admindashboard')->middleware('auth');
Route::post('/admin/dashboard', [AdminDashboardController::class, 'logout']);
Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users')->middleware('auth');
Route::delete('/admin/users/{id}', [AdminDashboardController::class, 'delete'])->name('user.delete')->middleware('auth');
Route::post('/admin/users/{id}/{is_admin}', [AdminDashboardController::class, 'edit'])->name('user.edit')->middleware('auth');

Route::get('/posts', [PostController::class, 'index'])->name('posts')->middleware('auth');
Route::post('/create-post', [PostController::class, 'store'])->name('create-post')->middleware('auth');
Route::post('/edit-post', [PostController::class, 'update'])->name('edit-post')->middleware('auth');
Route::delete('/delete-post/{id}', [PostController::class, 'delete'])->name('delete-post')->middleware('auth');
