<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\emailNotificationsController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('home.about');
Route::get('/help', [HomeController::class,'help'])->name('home.help');
Route::get('/feedback', [HomeController::class,'feedback'])->name('home.feedback');
Route::post('/feedback', [HomeController::class, 'feedbackStore'])->name('feedback.store');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register/user', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login/user', [AuthController::class, 'submitlogin'])->name('login.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showForm'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->middleware('guest')->name('password.update');
});

Route::get('/organization/search', [OrganizationController::class, 'search'])->name('organization.search');
Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organization.store');

Route::get('/pengajuan', [SubmissionController::class, 'index'])->name('submissions.index');
Route::get('/pengajuan/detail/{submission_code}', [SubmissionController::class,'show'])->name('submissions.show');
Route::get('/search', [SubmissionController::class, 'search'])->name('submissions.search');

// Routes that require authentication
Route::group(['middleware' => 'auth'], function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [HomeController::class, 'dashboard'])->middleware('verified')->name('dashboard');
        Route::get('/pengajuan', [SubmissionController::class, 'showAllSubmissions'])->name('dashboard.submissions.index');
        Route::get('/pengajuan/detail/{submission_code}', [SubmissionController::class, 'showSubmission'])->name('dashboard.submissions.show');
        Route::get('/pengajuan/{submission_code}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/pengajuan/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
        Route::get('/pengajuan/create', [SubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/pengajuan/store', [SubmissionController::class, 'store'])->name('submissions.store');
        Route::delete('/pengajuan/delete/{submission_code}', [SubmissionController::class, 'destroy'])->name('submission.destroy')->middleware('role:submitter');
        Route::resource('/admin', AdminController::class)->middleware('role:admin');
        Route::resource('/review', ReviewController::class)->middleware('role:reviewer');
        Route::resource('/organization', OrganizationController::class);
        Route::post('/pengajuan/store', [SubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/pengajuan/print', [SubmissionController::class, 'print'])->name('dashboard.submissions.print');  
        Route::post('/submission/{submission_code}/archive', [SubmissionController::class, 'archiveSubmission'])->name('submission.archive');
        Route::get('/review', [ReviewController::class, 'showHistory'])->name('review.index');
    });
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
       // Untuk menampilkan notifikasi di navbar
    Route::get('/navbar-notifications', [NotificationController::class, 'index'])->name('notifications.index');

       // Untuk menampilkan halaman semua notifikasi
    Route::get('/all-notifications', [NotificationController::class, 'show'])->name('notifications.show');

       // Route untuk menghitung jumlah notifikasi yang belum terbaca
    Route::get('/notifications/unread-count', [NotificationController::class, 'countUnreadNotifications']);
    Route::resource('/user', UserController::class);
    Route::resource('/organization', OrganizationController::class);
    Route::post('/logout', [UserController::class, 'signOut'])->name('logout');

    // Email Verification Notice route
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])
    ->middleware('auth')
    ->name('verification.notice');

    // Email Verification Handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

    // Resending the Verification Email
    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


// Open Routes
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/send-notification/{submission}', [EmailNotificationsController::class, 'sendNotification'])->name('send-notification');

});

