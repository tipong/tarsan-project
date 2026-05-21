<?php

use App\Http\Controllers\Admin\{ RoomController, UserController, VoucherController, OrderController, ReviewController, FinancialReportController, FacilityController };
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
use App\Http\Controllers\Tamu\RoomController as TamuRoomController;
use App\Http\Controllers\Tamu\OrderController as TamuOrderController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC - GUEST DAPAT EXPLORE KAMAR TANPA LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('beranda');
Route::get('/kamar', [TamuRoomController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{room}', [TamuRoomController::class, 'show'])->name('kamar.show');
Route::view('/fasilitas', 'tamu.facilities')->name('tamu.facilities');
Route::view('/dining', 'tamu.dining')->name('tamu.dining');
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| LOGIN REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'owner') {
        return redirect()->route('admin.dashboard');
    }

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
Route::middleware(['auth', 'role:admin,owner'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('rooms', RoomController::class);
        Route::resource('users', UserController::class);
        Route::resource('vouchers', VoucherController::class);
        Route::resource('facilities', FacilityController::class);
        Route::resource('orders', OrderController::class);
        Route::post('/orders/{order}/check-in', [OrderController::class, 'checkIn'])->name('orders.checkin');
        Route::post('/orders/{order}/check-out', [OrderController::class, 'checkOut'])->name('orders.checkout');
        Route::resource('reviews', ReviewController::class);
        Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    });

/*
|--------------------------------------------------------------------------
| OWNER (OWNER HAS ALL ADMIN CAPABILITIES)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', function() {
            return redirect()->route('admin.dashboard');
        })->name('dashboard');

        // Financial Reports (Exclusive to Owner)
        Route::get('/reports/financial', [FinancialReportController::class, 'index'])
            ->name('reports.financial');
        Route::get('/reports/financial/export', [FinancialReportController::class, 'export'])
            ->name('reports.financial.export');
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

        Route::get('/orders/{order}', [ResepsionisOrderController::class, 'show'])
            ->name('orders.show');

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

        Route::get('/payment/success', function () {
            return redirect()->route('tamu.orders')
                ->with('success', 'Payment successful. Your order has been confirmed.');
        })->name('payment.success');

        Route::get('/payment/{order?}',
            [PaymentController::class, 'index']
        )->name('payment.index');

        Route::post('/payment/pay', [PaymentController::class, 'pay'])
            ->name('payment.pay');

        Route::post('/payment/orders/{order}/sync', [PaymentController::class, 'sync'])
            ->name('payment.sync');

        Route::post('/payment/orders/{order}/continue', [PaymentController::class, 'continuePayment'])
            ->name('payment.continue');

        Route::post('/payment/orders/{order}/cancel', [PaymentController::class, 'cancel'])
            ->name('payment.cancel');

        Route::get('/orders', [\App\Http\Controllers\Tamu\OrderController::class, 'index'])
        ->middleware('auth')
        ->name('orders');

        // Alias untuk route pesanan.saya (digunakan di views)
        Route::get('/pesanan-saya', [\App\Http\Controllers\Tamu\OrderController::class, 'index'])
        ->middleware('auth')
        ->name('pesanan.saya');

        Route::post('/orders/{order}/cancel', [TamuOrderController::class, 'cancel'])
            ->name('orders.cancel');

        Route::get('/orders/{order}', [TamuOrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{order}/review', [\App\Http\Controllers\Tamu\ReviewController::class, 'store'])
            ->name('orders.review');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Tamu\NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Tamu\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Tamu\NotificationController::class, 'markAllAsRead'])
            ->name('notifications.read-all');
        Route::get('/notifications/unread-count', [\App\Http\Controllers\Tamu\NotificationController::class, 'unreadCount'])
            ->name('notifications.unread-count');
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

/*
|--------------------------------------------------------------------------
| SHARED - INVOICE (TAMU, ADMIN, RESEPSIONIS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:tamu,admin,resepsionis,owner'])
    ->group(function () {
        Route::get('/tamu/invoice/{order}/download', [InvoiceController::class, 'download'])
            ->name('tamu.invoice.download');
        Route::get('/tamu/invoice/{order}', [InvoiceController::class, 'show'])
            ->name('tamu.invoice.show');
    });
