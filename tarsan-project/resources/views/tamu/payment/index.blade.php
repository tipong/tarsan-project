@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Payment Confirmation</h1>
            <p class="text-slate-600">Review your order before payment</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            {{-- LEFT: Order Details --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Booking Summary Card --}}
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Order Summary</h2>

                    <div class="space-y-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-start pb-4 border-b border-slate-200 last:border-0">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">{{ $item['room_name'] }}</p>
                                    <p class="text-sm text-slate-600 mt-2">
                                        📅 {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-slate-600">🌙 {{ $item['nights'] }} nights</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp {{ number_format($item['subtotal']) }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Rp {{ number_format($item['price'] ?? 0) }}/night</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-200 my-4"></div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-slate-900">Total Payment</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($finalTotal) }}</span>
                    </div>
                </div>

                {{-- Guest Information Card --}}
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Guest Data</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-600">Guest Name</p>
                            <p class="font-semibold text-slate-900">{{ session('guest.name', 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Phone Number</p>
                            <p class="font-semibold text-slate-900">{{ session('guest.phone', 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Email</p>
                            <p class="font-semibold text-slate-900">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Payment Methods --}}
            <div>
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Payment Methods</h3>

                    <div class="space-y-3 mb-6 text-sm text-slate-600">
                        <p><strong>Midtrans Snap</strong> accepts various payment methods:</p>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Credit / Debit Card
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Bank Transfer
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                E-Wallet (GCash, OVO, Dana)
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                QRIS & Retail Stores
                            </li>
                        </ul>
                    </div>

                    <button id="pay-button"
                            class="w-full px-6 py-3 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-bold text-center">
                        💳 Continue Payment
                    </button>

                    <p class="text-xs text-slate-500 text-center mt-4">
                        Your payment is protected by Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
const orderBaseUrl = "{{ url('/tamu/orders') }}";
const paymentOrderBaseUrl = "{{ url('/tamu/payment/orders') }}";

async function syncPaymentStatus(orderId, result = {}) {
    const response = await fetch(`${paymentOrderBaseUrl}/${orderId}/sync`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify(result)
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error ?? 'Failed to sync payment status.');
    }

    return data;
}

document.getElementById('pay-button').addEventListener('click', async function () {
    const button = this;
    button.disabled = true;
    button.innerHTML = '⏳ Memproses...';

    try {
        const response = await fetch("{{ route('tamu.payment.pay') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        });

        if (!response.ok) {
            let serverMessage = 'An error occurred on the server. Please try again.';

            try {
                const errorData = await response.json();
                serverMessage = errorData.error ?? serverMessage;
                console.error('SERVER ERROR:', errorData);
            } catch (parseError) {
                const text = await response.text();
                console.error('SERVER ERROR:', text, parseError);
            }

            Swal.fire('Error', serverMessage, 'error');
            button.disabled = false;
            button.innerHTML = '💳 Continue Payment';
            return;
        }

        const data = await response.json();
        console.log('PAYMENT RESPONSE:', data);

        if (!data.snap_token) {
            Swal.fire('Error', data.error ?? 'Failed to create payment token', 'error');
            button.disabled = false;
            button.innerHTML = '💳 Continue Payment';
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);

                    Swal.fire('Success!', 'Payment successful. Thank you!', 'success').then(() => {
                        window.location.href = "{{ route('tamu.payment.success') }}";
                    });
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = '💳 Continue Payment';
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onPending: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);

                    Swal.fire('Pending', 'Your payment is being processed...', 'info').then(() => {
                        window.location.href = `${orderBaseUrl}/${data.order_id}`;
                    });
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = '💳 Continue Payment';
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onError: function () {
                Swal.fire('Failed', 'Payment failed. Please try again.', 'error');
                button.disabled = false;
                button.innerHTML = '💳 Continue Payment';
            },
            onClose: function () {
                button.disabled = false;
                button.innerHTML = '💳 Continue Payment';
            }
        });
    } catch (error) {
        console.error('ERROR:', error);
        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
        button.disabled = false;
        button.innerHTML = '💳 Continue Payment';
    }
});
</script>
@endsection
