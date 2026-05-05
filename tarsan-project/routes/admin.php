<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ReviewController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('rooms', RoomController::class);
        Route::resource('users', controller: UserController::class);
        Route::resource('vouchers', VoucherController::class)
            ->only(['index', 'create', 'store', 'destroy']);
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

            Route::post('/orders/{order}/check-in',
                [OrderController::class, 'checkIn'])
                ->name('orders.checkin');

        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])
                        ->name('index');
                
            Route::post('/{review}/reply', [ReviewController::class, 'reply'])
                        ->name('reply');
        });
    });
