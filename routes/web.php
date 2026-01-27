<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserRequestController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\StockInputController;
use App\Http\Controllers\Admin\StockRequestController;
use App\Http\Controllers\Admin\StockManagementController;

use App\Models\Product;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
*/

// PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])->name('dashboard');

// PROFILE (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// ADMIN PANEL
Route::middleware(['auth', 'approved'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // USERS 
        Route::middleware('admin')->group(function () {

            // USERS REQUESTS
            Route::controller(UserRequestController::class)->group(function () {
                Route::get('user-requests', 'index')->name('user-requests.index');
                Route::post('user-requests/{user}/approve', 'approve')->name('user-requests.approve');
                Route::post('user-requests/{user}/reject', 'reject')->name('user-requests.reject');
            });

            // USERS MANAGEMENT (CRUD)
            Route::controller(UserManagementController::class)->group(function () {
                Route::get('users-management', 'index')->name('users-management.index');
                Route::post('users-management', 'store')->name('users-management.store');
                Route::put('users-management/{user}', 'update')->name('users-management.update');
                Route::delete('users-management/{user}', 'destroy')->name('users-management.destroy');

                Route::get('users-management/bin', 'bin')->name('users-management.bin');
                Route::post('users-management/{id}/restore', 'restore')->name('users-management.restore');
            });

        });


        // SUPPLIERS 
        // SUPPLIERS VIEWS DATA (ADMIN, MANAGER, STAFF)
        Route::middleware('role:admin,manajer_gudang,staff_gudang')
            ->controller(SupplierController::class)
            ->group(function () {
                Route::get('suppliers-management', 'index')->name('suppliers-management.index');
                Route::get('suppliers-management/bin', 'bin')->name('suppliers-management.bin');
            });

        // SUPPLIERS CRUD (ADMIN ONLY)
        Route::middleware('admin')
            ->controller(SupplierController::class)
            ->group(function () {
                Route::post('suppliers-management', 'store')->name('suppliers-management.store');
                Route::put('suppliers-management/{supplier}', 'update')->name('suppliers-management.update');
                Route::delete('suppliers-management/{supplier}', 'destroy')->name('suppliers-management.destroy');
                Route::post('suppliers-management/{id}/restore', 'restore')->name('suppliers-management.restore');
            });


        // CATEGORIES 
        // CATEGORIES VIEWS DATA (ADMIN, MANAGER, STAFF)
        Route::middleware('role:admin,manajer_gudang,staff_gudang')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('categories-management', 'index')->name('categories-management.index');
                Route::get('categories-management/bin', 'bin')->name('categories-management.bin');
            });

        // CATEGORIES CRUD (ADMIN ONLY)
        Route::middleware('admin')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::post('categories-management', 'store')->name('categories-management.store');
                Route::put('categories-management/{category}', 'update')->name('categories-management.update');
                Route::delete('categories-management/{category}', 'destroy')->name('categories-management.destroy');
                Route::post('categories-management/{id}/restore', 'restore')->name('categories-management.restore');
            });


        // PRODUCTS MANAGEMENT
        // PRODUCTS VIEWS DATA (ADMIN, MANAGER, STAFF)
        Route::middleware('role:admin,manajer_gudang,staff_gudang')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('products-management', 'index')->name('products-management.index');
                Route::get('products-management/bin', 'bin')->name('products-management.bin');
            });

        // PRODUCTS CRUD (ADMIN + MANAGER)
        Route::middleware('role:admin,manajer_gudang')
            ->controller(ProductController::class)
            ->group(function () {
                
                Route::post('products-management', 'store')->name('products-management.store');
                Route::put('products-management/{product}', 'update')->name('products-management.update');
                Route::delete('products-management/{product}', 'destroy')->name('products-management.destroy');
                Route::post('products-management/{id}/restore', 'restore')->name('products-management.restore');
            });

        // PRODUCT ATTRIBUTES
        // PRODUCT ATTRIBUTES VIEWS DATA (ADMIN, MANAGER, STAFF)
        Route::middleware('role:admin,manajer_gudang,staff_gudang')
            ->controller(ProductAttributeController::class)
            ->group(function () {
                Route::get('product-attributes', 'index')->name('product-attributes.index');
                Route::get('product-attributes/bin', 'bin')->name('product-attributes.bin');
            });

        // PRODUCT ATTRIBUTES CRUD (ADMIN + MANAGER)
        Route::middleware('role:admin,manajer_gudang')
            ->controller(ProductAttributeController::class)
            ->group(function () {
                
                Route::post('product-attributes', 'store')->name('product-attributes.store');
                Route::put('product-attributes/{attribute}', 'update')->name('product-attributes.update');
                Route::delete('product-attributes/{attribute}', 'destroy')->name('product-attributes.destroy');
                Route::post('product-attributes/{id}/restore', 'restore')->name('product-attributes.restore');
            });

        // STOCK
        // STOCK INPUT (STAFF)
        Route::middleware('role:admin,staff_gudang')
            ->controller(StockInputController::class)
            ->group(function () {
                Route::get('stock-inputs', 'index')->name('stock-inputs.index');
                Route::post('stock-inputs', 'store')->name('stock-inputs.store');

                Route::get('products/{id}/stock', function ($id) {
                    $p = Product::findOrFail($id);

                    return response()->json([
                        'current_stock' => $p->current_stock,
                        'minimum_stock' => $p->minimum_stock,
                    ]);
                });

            });

        // STOCK REQUEST (ADMIN + MANAGER)
        Route::middleware('role:admin,manajer_gudang')
            ->controller(StockRequestController::class)
            ->group(function () {
                Route::get('stock-requests', 'index')->name('stock-requests.index');
                Route::post('stock-requests/{id}/approve', 'approve')->name('stock-requests.approve');
                Route::post('stock-requests/{id}/reject', 'reject')->name('stock-requests.reject');
            });

        // STOCK MANAGEMENT (ADMIN + MANAGER)
        Route::middleware('role:admin,manajer_gudang')
            ->controller(StockManagementController::class)
            ->group(function () {
                Route::get('stocks-management', 'index')->name('stocks-management.index');
            });


    });
