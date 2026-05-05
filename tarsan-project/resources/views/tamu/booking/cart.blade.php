@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 shadow rounded">

    <h2 class="text-2xl font-bold mb-6">Your Cart</h2>

    @php $total = 0; @endphp

    @forelse(session('cart', []) as $item)
        @php $total += $item['subtotal']; @endphp

        <div class="border-b py-4 flex justify-between">
            <div>
                <h3 class="font-semibold">{{ $item['room_name'] }}</h3>
                <p class="text-sm text-gray-500">
                    {{ $item['check_in'] }} → {{ $item['check_out'] }}
                    ({{ $item['nights'] }} nights)
                </p>
            </div>

            <div class="font-semibold">
                Rp {{ number_format($item['subtotal']) }}
            </div>
        </div>
    @empty
        <p class="text-gray-500">Your cart is empty</p>
    @endforelse

    <div class="mt-6 flex justify-between items-center">
        <span class="text-lg font-bold">
            Total: Rp {{ number_format($total) }}
        </span>

        <a href="{{ route('tamu.checkout.index') }}"
           class="bg-green-600 text-white px-6 py-2 rounded">
            Proceed to Checkout
        </a>
    </div>
</div>
@endsection