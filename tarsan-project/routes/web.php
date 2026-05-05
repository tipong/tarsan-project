<?php

use App\Http\Controllers\Admin\{ RoomController, UserController, VoucherController, OrderController, ReviewController };
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resepsionis\AvailabilityController as ResepsionisAvailabilityController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Resepsionis\OrderController as ResepsionisOrderController;
use App\Http\Controllers\Tamu\BookingController;
use App\Http\Controllers\Tamu\CheckoutController;
use App\Http\Controllers\Tamu\InvoiceController;
use App\Http\Controllers\Tamu\PaymentController;
use App\Http\Controllers\Tamu\ReservationController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------- 
| PUBLIC
|-------------------------------------------------------------------------- 
*/
Route::get('/', fn () => view('welcome'))->name('beranda');
Route::get('/kamar', fn () => view('kamar.index'))->name('kamar.index');
Route::get('/pesanan-saya', fn () => view('pesanan.saya'))->name('pesanan.saya');

/*
|-------------------------------------------------------------------------- 
| LOGIN REDIRECT
|-------------------------------------------------------------------------- 
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'resepsionis') {
        return redirect()->route('resepsionis.dashboard');
    }

    if ($user->role === 'tamu') {
        return redirect()->route('tamu.dashboard');
    }

    abort(403);
})->middleware('auth')->name('dashboard');

/*
|-------------------------------------------------------------------------- 
| ADMIN (HANYA ADMIN)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::resource('rooms', RoomController::class);
        Route::resource('users', UserController::class);
        Route::resource('vouchers', VoucherController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('reviews', ReviewController::class);
    });

/*
|-------------------------------------------------------------------------- 
| RESEPSIONIS (HANYA RESEPSIONIS)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:resepsionis'])
    ->prefix('resepsionis')
    ->name('resepsionis.')
    ->group(function () {

        Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders', [ResepsionisOrderController::class, 'index'])
            ->name('orders.index');

        Route::post('/orders/{order}/check-in', [ResepsionisOrderController::class, 'checkIn'])
            ->name('orders.checkin');

        Route::post('/orders/{order}/check-out', [ResepsionisOrderController::class, 'checkOut'])
            ->name('orders.checkout');

        Route::get('/walkin/create', [ResepsionisOrderController::class, 'create'])
            ->name('orders.walkin.create');
        
        Route::post('/walkin', [ResepsionisOrderController::class, 'store'])
            ->name('orders.walkin.store');

        Route::get('/availability', [ResepsionisAvailabilityController::class, 'index'])
            ->name('availability');
        
        Route::post('/availability/check', [ResepsionisAvailabilityController::class, 'check'])
            ->name('availability.check');
    });

/*
|-------------------------------------------------------------------------- 
| TAMU (HANYA TAMU)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:tamu'])
    ->prefix('tamu')
    ->name('tamu.')
    ->group(function () {

        Route::view('/dashboard', 'tamu.dashboard')->name('dashboard');
        Route::view('/rooms', 'tamu.rooms')->name('rooms');
        Route::view('/orders', 'tamu.orders')->name('orders');

        // BOOKING
        Route::get('/booking', [BookingController::class, 'index'])
        ->name('booking.index');

        Route::post('/booking/search', [BookingController::class, 'search'])
        ->name('booking.search');

        Route::get('/tamu/booking/search', function () {
            return redirect()->route('tamu.booking.index')
                ->with('error', 'Please select check-in and check-out date first.');
        });

        // CART
        Route::post('/booking/add', [BookingController::class, 'add'])
        ->name('booking.add');

        Route::get('/booking/cart', [BookingController::class, 'cart'])
        ->name('booking.cart');

        Route::delete('/booking/remove/{roomId}', [BookingController::class, 'remove'])
        ->name('booking.remove');

        // CHECKOUT
        Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

        Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])
        ->name('checkout.confirm');

        // Reservation
        Route::get('/reservation', [ReservationController::class, 'index'])
            ->name('reservation.index');

        Route::post('/reservation/confirm', [ReservationController::class, 'confirm'])
            ->name('reservation.confirm');
            
        Route::post(
                '/reservation/guest',
                [ReservationController::class, 'applyGuestInfo']
            )->name('reservation.guest');  

        Route::get('/payment', 
            [PaymentController::class, 'index']
        )->name('payment.index');

        Route::post('/payment/pay', [PaymentController::class, 'pay'])
        ->name('payment.pay');

        Route::post('/payment/callback', [PaymentController::class, 'callback'])
        ->name('payment.callback');
        
        Route::get('/payment/snap-token',
            [PaymentController::class, 'snapToken']
        )->name('payment.token');

        Route::get('/tamu/invoice/{order}', [InvoiceController::class, 'show'])
        ->name('tamu.invoice.show');

        Route::get('/payment/success', function () {
            return redirect()->route('tamu.orders')
                ->with('success', 'Payment successful. Your order has been confirmed.');
        })->name('payment.success');

        Route::post('tamu/midtrans/callback', [MidtransCallbackController::class, 'handle']);

        Route::get('/orders', [\App\Http\Controllers\Tamu\OrderController::class, 'index'])
        ->middleware('auth')
        ->name('orders');
    });

/*
|-------------------------------------------------------------------------- 
| PROFILE (SEMUA ROLE)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:tamu'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/send-welcome-mail', function () {
    Mail::to('adriantsatrio3@gmail.com')->send(new WelcomeMail());
});