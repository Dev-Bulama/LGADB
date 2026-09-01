<?php
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WorkerPortalController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'contactSubmit'])->name('contact.submit')->middleware('throttle:contact');
Route::get('/news', [PublicController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PublicController::class, 'newsShow'])->name('news.show');
Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
Route::get('/page/{slug}', [PublicController::class, 'page'])->name('page.show');

// Public verification portal
Route::get('/verify', [VerificationController::class, 'index'])->name('verify.index');
Route::post('/verify/search', [VerificationController::class, 'search'])->name('verify.search')->middleware('throttle:verification');
Route::get('/verify/qr/{hash}', [VerificationController::class, 'qrScan'])->name('verify.qr');
Route::get('/verify/{code}', [VerificationController::class, 'show'])->name('verify.show');

// Worker portal (authenticated workers)
Route::prefix('portal')->name('portal.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WorkerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [WorkerPortalController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [WorkerPortalController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [WorkerPortalController::class, 'changePassword'])->name('profile.password');
    Route::get('/id-card', [WorkerPortalController::class, 'idCard'])->name('id-card');
    Route::get('/id-card/download', [WorkerPortalController::class, 'downloadIdCard'])->name('id-card.download');
    Route::get('/documents', [WorkerPortalController::class, 'documents'])->name('documents');
    Route::get('/documents/{document}/download', [WorkerPortalController::class, 'downloadDocument'])->name('documents.download');
    Route::get('/notifications', [WorkerPortalController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read', [WorkerPortalController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [WorkerPortalController::class, 'markAllNotificationsRead'])->name('notifications.read-all');
    Route::get('/history', [WorkerPortalController::class, 'history'])->name('history');
});

// Admin ID card download (Filament admin area, auth guarded)
Route::get('/admin/workers/{worker}/id-card/download', function (\App\Models\Worker $worker) {
    abort_unless(
        auth()->check() && auth()->user()->hasAnyRole(['super_admin', 'hr_officer', 'department_manager']),
        403
    );
    return (new \App\Services\IdCardService())->download($worker);
})->name('admin.workers.id-card.download')->middleware(['auth']);

// Public AJAX endpoint — LGAs for a given state ID
Route::get('/api/lgas/{stateId}', function (int $stateId) {
    return response()->json(
        \App\Models\Lga::where('state_id', $stateId)
            ->orderBy('name')
            ->get(['id', 'name'])
    );
})->name('api.lgas')->middleware('throttle:60,1')->where('stateId', '[0-9]+');

// Auth routes (Laravel default)
require __DIR__.'/auth.php';
