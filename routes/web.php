<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\Auth\AuthLoginController;

Route::redirect('/', '/user/note')->name('home');

// Login & Register
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthLoginController::class, 'loginPage'])->name('login');
    Route::get('register', [AuthLoginController::class, 'registerPage'])->name('register');
    Route::post('login-post', [AuthLoginController::class, 'loginPost'])->name('login.post');
    Route::post('register-post', [AuthLoginController::class, 'registerPost'])->name('register.post');
});

Route::get('logout', [AuthLoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('user')->name('user.')->middleware('auth', 'verified')->group(function () {
    Route::prefix('note')->name('note.')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('all');
        Route::get('add', [NoteController::class, 'add'])->name('add');
        Route::post('create', [NoteController::class, 'create'])->name('create');
        Route::get('show/{id}', [NoteController::class, 'show'])->name('show');
        Route::get('edit/{id}', [NoteController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [NoteController::class, 'update'])->name('update');
        Route::get('delete/{id}', [NoteController::class, 'delete'])->name('delete');
        Route::get('status/{id}', [NoteController::class, 'status'])->name('status');
    });
});

Route::post('ckeditor/upload', [NoteController::class, 'upload'])->name('upload');
