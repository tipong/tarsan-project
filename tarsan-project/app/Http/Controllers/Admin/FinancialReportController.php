<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->subMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        $preset = $request->input('preset');
        if (!$request->filled('start_date') && !$request->filled('end_date') && !$request->filled('preset')) {
            $preset = 'last_month';
        }

        // Get paid orders within date range (based on created_at)
        $orders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.room', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Get cash and bank transfer payments
        $cashPayments = $orders->where('payment_method', 'cash')->sum('total_price');
        $bankTransfers = $orders->where('payment_method', 'bank_transfer')->sum('total_price');
        $cardPayments = $orders->where('payment_method', 'card')->sum('total_price');

        // Get daily revenue for chart
        $dailyRevenue = $orders
            ->groupBy(function($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->map(function($items) {
                return $items->sum('total_price');
            })
            ->toArray();

        // Get room-wise revenue from order_items
        $roomRevenue = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if ($item->room_id) {
                    $roomId = $item->room_id;
                    if (!isset($roomRevenue[$roomId])) {
                        $roomRevenue[$roomId] = [
                            'room' => $item->room?->room_name ?? 'N/A',
                            'revenue' => 0,
                            'count' => 0
                        ];
                    }
                    $roomRevenue[$roomId]['revenue'] += $item->subtotal ?? 0;
                    $roomRevenue[$roomId]['count']++;
                }
            }
        }
        $roomRevenue = collect(array_values($roomRevenue))
            ->sortByDesc('revenue')
            ->toArray();

        return view(auth()->user()->role . '.reports.financial', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'cashPayments',
            'bankTransfers',
            'cardPayments',
            'dailyRevenue',
            'roomRevenue',
            'startDate',
            'endDate',
            'preset'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->subMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        $orders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.room', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan-keuangan-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($orders, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['Tarsan Homestay Financial Report', 'Period: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y')]);
            fputcsv($file, []);

            // Column headers
            fputcsv($file, ['Date', 'Order Code', 'Guest', 'Room', 'Total Price', 'Payment Method']);

            // Data
            foreach ($orders as $order) {
                // Get room names from order items
                $roomNames = $order->items->map(function($item) {
                    return $item->room?->room_name;
                })->filter()->implode(', ');

                fputcsv($file, [
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->order_code ?? '-',
                    $order->user?->name ?? $order->guest_name ?? '-',
                    $roomNames ?: '-',
                    $order->total_price,
                    $order->payment_method ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadPdf(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->subMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        // Get paid orders within date range (based on created_at)
        $orders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.room', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $cashPayments = $orders->where('payment_method', 'cash')->sum('total_price');
        $bankTransfers = $orders->where('payment_method', 'bank_transfer')->sum('total_price');
        $cardPayments = $orders->where('payment_method', 'card')->sum('total_price');

        // Get room-wise revenue
        $roomRevenue = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if ($item->room_id) {
                    $roomId = $item->room_id;
                    if (!isset($roomRevenue[$roomId])) {
                        $roomRevenue[$roomId] = [
                            'room' => $item->room?->room_name ?? 'N/A',
                            'revenue' => 0,
                            'count' => 0,
                            'orders' => []
                        ];
                    }
                    $roomRevenue[$roomId]['revenue'] += $item->subtotal ?? 0;
                    $roomRevenue[$roomId]['count']++;
                    $roomRevenue[$roomId]['orders'][] = [
                        'date' => $order->created_at,
                        'order_code' => $order->order_code,
                        'guest' => $order->user?->name ?? $order->guest_name ?? '-',
                        'room' => $item->room?->room_name ?? 'N/A',
                        'total_price' => $item->subtotal ?? 0,
                        'payment_method' => $order->payment_method ?? '-'
                    ];
                }
            }
        }
        $roomRevenue = collect(array_values($roomRevenue))
            ->sortByDesc('revenue')
            ->toArray();

        $pdf = Pdf::loadView('owner.reports.financial_pdf', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'cashPayments',
            'bankTransfers',
            'cardPayments',
            'roomRevenue',
            'startDate',
            'endDate'
        ));

        $filename = 'laporan-keuangan-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
