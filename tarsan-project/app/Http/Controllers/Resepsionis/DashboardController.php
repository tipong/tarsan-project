<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('resepsionis.dashboard', [
            'upcoming' => Order::whereNull('checked_in_at')
                ->where('check_in', '>', now())
                ->where('status', '!=', 'cancelled')
                ->count(),

            'ongoing' => Order::whereNotNull('checked_in_at')
                ->whereNull('checked_out_at')
                ->where('status', '!=', 'cancelled')
                ->count(),

            'todayCheckin' => Order::whereDate('check_in', today())
                ->where('status', '!=', 'cancelled')
                ->count(),

            'todayCheckout' => Order::whereDate('check_out', today())
                ->where('status', '!=', 'cancelled')
                ->count(),
        ]);
    }
}
