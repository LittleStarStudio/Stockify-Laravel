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


// Route untuk halaman public (Umum)
Route::get('/', function () {
    return view('welcome');
});



// Dashboard (Hanya untuk user yang sudah Authenticated & Approved)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])->name('dashboard');



// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



// Admin routes
Route::middleware(['auth', 'approved', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        // User Requests (Approval/Rejection)
        Route::controller(UserRequestController::class)->group(function () {
            Route::get('user-requests', 'index')->name('user-requests.index');
            Route::post('user-requests/{user}/approve', 'approve')->name('user-requests.approve');
            Route::post('user-requests/{user}/reject', 'reject')->name('user-requests.reject');
        });


        // User Management (CRUD)
        Route::controller(UserManagementController::class)->group(function () {

            // Main CRUD
            Route::get('users-management', 'index')->name('users-management.index');
            Route::post('users-management', 'store')->name('users-management.store');
            Route::put('users-management/{user}', 'update')->name('users-management.update');
            Route::delete('users-management/{user}', 'destroy')->name('users-management.destroy');

            // Bin (Soft Deleted Users)
            Route::get(
                'users-management/bin', 
                [UserManagementController::class, 'bin']
            )->name('users-management.bin');

            // Restore dari Bin
            Route::post(
                'users-management/{id}/restore',
                [UserManagementController::class, 'restore']
            )->name('users-management.restore');
            
        });
    });
