<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Laravel 11
|--------------------------------------------------------------------------
*/

// 1. PINTU OTOMATIS (Redirect sesuai status login)
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->username === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('home');
    }
    return redirect()->route('register');
});

// 2. AUTHENTICATION
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. HALAMAN PUBLIC (Setelah Login)
Route::get('/beranda', function () {
    $contents = \App\Models\Content::pluck('value', 'key');
    // Laravel akan mencari file di: resources/views/public/home.blade.php
    return view('public.home', compact('contents'));
})->name('home');

// 4. AREA ADMIN (Terproteksi Middleware Auth)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard / Visual Editor
    Route::get('/', function () { 
         $contents = \App\Models\Content::pluck('value', 'key');
         return view('admin.visual-editor', compact('contents')); 
    })->name('admin.dashboard');

    Route::get('/visual-editor', function() {
        $contents = \App\Models\Content::pluck('value', 'key');
        return view('admin.visual-editor', compact('contents'));
    })->name('admin.visual-editor');

    // Proses Update Konten
    Route::post('/content/update', [ContentController::class, 'update'])->name('admin.content.update');

    // --- USER MANAGEMENT (Penyebab Error Route Not Found) ---
    Route::get('/users', [ContentController::class, 'userIndex'])->name('admin.users');
    Route::post('/users', [ContentController::class, 'userStore'])->name('admin.users.store');
    Route::put('/users/update/{id}', [ContentController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/users/{id}', [ContentController::class, 'userDelete'])->name('admin.users.delete');
});
Route::post('/send-investment-contact', [App\Http\Controllers\ContactController::class, 'sendInvestment'])->name('send.investment.contact');