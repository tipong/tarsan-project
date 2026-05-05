@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <h2 class="text-2xl font-bold mb-6">My Orders</h2>

    @forelse($orders as $order)
        <div class="border p-4 rounded mb-4 bg-white shadow">
            <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
            <p><strong>Guest:</strong> {{ $order->guest_name }}</p>
            <p><strong>Phone:</strong> {{ $order->guest_phone }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price) }}</p>
            <p><strong>Payment Status:</strong>
                <span class="font-semibold text-green-600">
                    {{ strtoupper($order->payment_status) }}
                </span>
            </p>

            @if($order->payment_status === 'paid')
                <a href="{{ route('tamu.invoice.show', $order->id) }}"
                   class="inline-block mt-2 text-blue-600 underline">
                    View Invoice
                </a>
            @endif
        </div>
    @empty
        <p class="text-gray-500">You have no orders yet.</p>
    @endforelse

</div>
@endsection