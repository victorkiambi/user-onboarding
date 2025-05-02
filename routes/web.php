<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/documents', [ProfileController::class, 'editDocuments'])->name('profile.documents.edit');
    Route::post('/profile/documents', [ProfileController::class, 'updateDocuments'])->name('profile.documents.update');
    // User dashboard route
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    // User profile edit routes
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard (list pending users)
    Route::get('/dashboard', [\App\Http\Controllers\Admin\UserReviewController::class, 'index'])->name('dashboard');
    // View user details
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserReviewController::class, 'show'])->name('users.show');
    // Approve user
    Route::post('/users/{user}/approve', [\App\Http\Controllers\Admin\UserReviewController::class, 'approve'])->name('users.approve');
    // Reject user
    Route::post('/users/{user}/reject', [\App\Http\Controllers\Admin\UserReviewController::class, 'reject'])->name('users.reject');
});

require __DIR__.'/auth.php';
