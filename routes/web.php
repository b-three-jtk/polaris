<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPengajuanController;
use App\Http\Controllers\LoginController;

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/register ', [AuthController::class, 'register'])->name('register.post');

Route::get('/user/profil', [AuthController::class, 'viewProfile'])->name('user.profile');
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('home.about');
Route::get('/faq', [HomeController::class,'faq'])->name('home.faq');
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('submissions.index');
Route::get('/pengajuan/detail/{kode_pengajuan}', [PengajuanController::class,'show'])->name('submissions.show');
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('submissions.create');
Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('submissions.store');
Route::get('/search', [PengajuanController::class, 'search'])->name('submissions.search');

Route::get('/pengajuan/verification', [PengajuanController::class, 'verification'])->name('submissions.verification');
Route::post('/send-verification-code', [PengajuanController::class, 'sendVerificationCode'])->name('send.verification.code');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('submissions.store');

Route::get('/admin/detail/{id}', [AdminController::class, 'show'])->name('admin.admins.show');
Route::get('/admin/pengajuan', [DataPengajuanController::class, 'index'])->name('dashboard.submissions.index');
Route::get('/admin/pengajuan/detail/{kode_pengajuan}', [DataPengajuanController::class, 'show'])->name('dashboard.submissions.show');