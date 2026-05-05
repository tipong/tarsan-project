@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-6">

    {{-- LEFT --}}
    <div class="md:col-span-2 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Booking Summary</h2>

        @foreach($cart as $item)
            <div class="border-b py-3">
                <p class="font-semibold">{{ $item['room_name'] }}</p>
                <p class="text-sm text-gray-500">
                    {{ $item['check_in'] }} → {{ $item['check_out'] }}
                    ({{ $item['nights'] }} night)
                </p>
                <p>Rp {{ number_format($item['subtotal']) }}</p>
            </div>
        @endforeach

        <div class="flex justify-between font-bold text-lg mt-4">
            <span>Total</span>
            <span class="text-orange-500">
                Rp {{ number_format($finalTotal) }}
            </span>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold mb-4">Guest Info</h3>
        <p>{{ session('guest.name') }}</p>
        <p>{{ session('guest.phone') }}</p>

        <button id="pay-button"
            class="w-full bg-green-600 text-white py-3 rounded mt-4">
            Pay Now
        </button>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').addEventListener('click', async function () {

    console.log('PAY BUTTON CLICKED');

    const response = await fetch("{{ route('tamu.payment.pay') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    });

    if (!response.ok) {
        const text = await response.text();
        console.error('SERVER ERROR:', text);
        alert('Server error. Check Laravel log.');
        return;
    }

    const data = await response.json();
    console.log('PAYMENT RESPONSE:', data);

    if (!data.snap_token) {
        alert(data.error ?? 'Snap token not found');
        return;
    }

    snap.pay(data.snap_token, {
    onSuccess: function () {
            window.location.href = "{{ route('tamu.payment.success') }}";
        },
        onPending: function () {
            alert('Waiting for payment...');
        },
        onError: function () {
            alert('Payment failed');
        }
    });

});
</script>
@endsection

