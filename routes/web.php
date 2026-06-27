<?php
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WorkerPortalController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/news', [PublicController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PublicController::class, 'newsShow'])->name('news.show');
Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
Route::get('/page/{slug}', [PublicController::class, 'page'])->name('page.show');

// Public verification portal
Route::get('/verify', [VerificationController::class, 'index'])->name('verify.index');
Route::post('/verify/search', [VerificationController::class, 'search'])->name('verify.search');
Route::get('/verify/{code}', [VerificationController::class, 'show'])->name('verify.show');
Route::get('/verify/qr/{hash}', [VerificationController::class, 'qrScan'])->name('verify.qr');

// Worker portal (authenticated workers)
Route::prefix('portal')->name('portal.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WorkerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [WorkerPortalController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [WorkerPortalController::class, 'updateProfile'])->name('profile.update');
    Route::get('/id-card', [WorkerPortalController::class, 'idCard'])->name('id-card');
    Route::get('/id-card/download', [WorkerPortalController::class, 'downloadIdCard'])->name('id-card.download');
    Route::get('/documents', [WorkerPortalController::class, 'documents'])->name('documents');
    Route::get('/notifications', [WorkerPortalController::class, 'notifications'])->name('notifications');
    Route::get('/history', [WorkerPortalController::class, 'history'])->name('history');
});

// Auth routes (Laravel default)
require __DIR__.'/auth.php';
