<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserRequestController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes Untuk Semua Pengguna (Publik)
Route::get('/', function () {
    return view('welcome');
});

// Authenticated & Approved User
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Route Admin ( Untuk manajemen users )
Route::middleware(['auth', 'approved', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // RouteUser Requests (Approval/Rejection)
        Route::get('user-requests', [UserRequestController::class, 'index'])
            ->name('user-requests.index');

        Route::post('user-requests/{user}/approve', [UserRequestController::class, 'approve'])
            ->name('user-requests.approve');

        Route::post('user-requests/{user}/reject', [UserRequestController::class, 'reject'])
            ->name('user-requests.reject');

        // User Management (CRUD)
        Route::resource('users-management', UserManagementController::class)
            ->except(['create', 'edit', 'show']);

        Route::post(
            'users-management/{user}/restore',
            [UserManagementController::class, 'restore']
        )->name('users-management.restore');
    });
