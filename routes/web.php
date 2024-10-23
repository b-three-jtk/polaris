<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/user', [AuthController::class, 'register'])->name('user.register');
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('home.about');
Route::get('/faq', [HomeController::class,'faq'])->name('home.faq');
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('submissions.index');
Route::get('/pengajuan/detail/{kode_pengajuan}', [PengajuanController::class,'show'])->name('submissions.show');
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('submissions.create');
Route::get('/search', [PengajuanController::class, 'search'])->name('submissions.search');

Route::get('/pengajuan/verification', [PengajuanController::class, 'verification'])->name('submissions.verification');
Route::post('/send-verification-code', [PengajuanController::class, 'sendVerificationCode'])->name('send.verification.code');
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('submissions.create');
<<<<<<< HEAD
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuans.store');
=======
Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('submissions.store');
>>>>>>> 63899f6253462e2f161e203109451124d74b37c2
