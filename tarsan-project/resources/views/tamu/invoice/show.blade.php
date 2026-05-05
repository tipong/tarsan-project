@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 mt-10 rounded shadow">

    <div class="flex justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">INVOICE</h2>
            <p class="text-sm text-gray-500">
                {{ $order->invoice_number }}
            </p>
        </div>
        <div class="text-right">
            <p>Tarsan Homestay</p>
            <p class="text-sm text-gray-500">
                Labuan Bajo
            </p>
        </div>
    </div>

    <hr class="mb-6">

    <div class="mb-4">
        <p><strong>Guest Name:</strong> {{ $order->guest_name }}</p>
        <p><strong>Phone:</strong> {{ $order->guest_phone }}</p>
    </div>

    <div class="mb-6">
        <p><strong>Check In:</strong> {{ $order->check_in }}</p>
        <p><strong>Check Out:</strong> {{ $order->check_out }}</p>
        <p><strong>Nights:</strong> {{ $order->nights }}</p>
    </div>

    <div class="border-t pt-4">
        <div class="flex justify-between text-lg font-semibold">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_price) }}</span>
        </div>

        <p class="mt-2 text-green-600 font-semibold">
            Payment Status: PAID
        </p>
    </div>

    <div class="mt-6 text-center">
        <button onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded">
            Print Invoice
        </button>
    </div>

</div>
@endsection