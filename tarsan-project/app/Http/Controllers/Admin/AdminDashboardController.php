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

        // Total revenue (hanya order selesai)
        $totalRevenue = Order::where('status', 'completed')
            ->sum('total_price');

        // Total rooms (jumlah fisik kamar)
        $totalRooms = Room::sum('total_rooms');

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalRooms'
        ));
    }
}