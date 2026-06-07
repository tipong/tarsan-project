<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total orders
        $totalOrders = Order::count();

        // Total revenue (from orders that are already paid)
        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('total_price');

        // Total rooms (number of physical rooms)
        $totalRooms = Room::sum('total_rooms');

        // Orders per status
        $upcomingOrders = Order::whereNull('checked_in_at')
            ->where('check_in', '>', now())
            ->where('status', '!=', 'cancelled')
            ->count();

        $ongoingOrders = Order::whereNotNull('checked_in_at')
            ->whereNull('checked_out_at')
            ->count();

        $completedOrders = Order::whereNotNull('checked_out_at')->count();

        // Fetch latest 5 orders with rooms and user relationships
        $recentOrders = Order::with(['items.room', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalRooms',
            'upcomingOrders',
            'ongoingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }
}
