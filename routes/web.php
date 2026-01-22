<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserRequestController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CategoryController;

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
Route::middleware(['auth', 'approved'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        // USERS
        // Users (Admin Only)
        Route::middleware('admin')->group(function (){

            // User Requests Approval/Rejection
            Route::controller(UserRequestController::class)->group(function () {
                Route::get('user-requests', 'index')->name('user-requests.index');
                Route::post('user-requests/{user}/approve', 'approve')->name('user-requests.approve');
                Route::post('user-requests/{user}/reject', 'reject')->name('user-requests.reject');
            });

            // Users Management CRUD
            Route::controller(UserManagementController::class)->group(function () {

                // Main CRUD
                Route::get('users-management', 'index')->name('users-management.index');
                Route::post('users-management', 'store')->name('users-management.store');
                Route::put('users-management/{user}', 'update')->name('users-management.update');
                Route::delete('users-management/{user}', 'destroy')->name('users-management.destroy');

                // Bin (Soft Deleted Users)
                Route::get('users-management/bin', [UserManagementController::class, 'bin'])->name('users-management.bin');

                // Restore dari Bin
                Route::post('users-management/{id}/restore', [UserManagementController::class, 'restore'])->name('users-management.restore');
            });

        });


        // SUPPLIERS
        // Suppliers View (Admin, Manager, Staff)
        Route::middleware('role:admin,manajer_gudang,staff_gudang')->controller(SupplierController::class)->group(function () {

            // Data Table Utama Suppliers
            Route::get('suppliers-management', 'index')->name('suppliers-management.index');

            // Data Table Bin Suppliers
            Route::get('suppliers-management/bin', 'bin')->name('suppliers-management.bin');

        });

        // Suppliers Management CRUD (Admin Only)
        Route::middleware('admin')->controller(SupplierController::class)->group(function () {

                // Main CRUD
                Route::post('suppliers-management', 'store')->name('suppliers-management.store');
                Route::put('suppliers-management/{supplier}', 'update')->name('suppliers-management.update');
                Route::delete('suppliers-management/{supplier}', 'destroy')->name('suppliers-management.destroy');

                // Restore dari Bin
                Route::post('suppliers-management/{id}/restore', 'restore')->name('suppliers-management.restore');
        });


        // CATEGORIES
        // Categories View (Admin, Manager, Staff)
        Route::middleware(['role:admin,manajer_gudang,staff_gudang'])->controller(CategoryController::class)->group(function () {

            // Data Table Utama Categories
            Route::get('categories-management', 'index')->name('categories-management.index');

            // Data Table Bin Categories
            Route::get('categories-management/bin', 'bin')->name('categories-management.bin');
        });


        // Categories Management CRUD (Admin Only)
        Route::middleware(['admin'])->controller(CategoryController::class)->group(function () {

        // Main CRUD
        Route::post('categories-management', 'store')->name('categories-management.store');
        Route::put('categories-management/{category}', 'update')->name('categories-management.update');
        Route::delete('categories-management/{category}', 'destroy')->name('categories-management.destroy');

        // Restore dari Bin
        Route::post('categories-management/{id}/restore', 'restore')->name('categories-management.restore');
    });

    });
