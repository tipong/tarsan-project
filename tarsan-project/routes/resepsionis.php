<?php

use App\Http\Controllers\Resepsionis\DashboardController;
use App\Http\Controllers\Resepsionis\OrderController;

Route::middleware(['auth', 'role:resepsionis'])
    ->prefix('resepsionis')
    ->name('resepsionis.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::post('/orders/{order}/check-in', [OrderController::class, 'checkIn'])
            ->name('orders.checkin');

        Route::post('/orders/{order}/check-out', [OrderController::class, 'checkOut'])
            ->name('orders.checkout');

        // WALK-IN
        Route::get('/orders/create', [OrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [OrderController::class, 'store'])
            ->name('orders.store');
    });
