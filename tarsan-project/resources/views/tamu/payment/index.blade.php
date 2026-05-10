@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Konfirmasi Pembayaran</h1>
            <p class="text-slate-600">Tinjau pesanan Anda sebelum melakukan pembayaran</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            {{-- LEFT: Order Details --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Booking Summary Card --}}
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-start pb-4 border-b border-slate-200 last:border-0">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">{{ $item['room_name'] }}</p>
                                    <p class="text-sm text-slate-600 mt-2">
                                        📅 {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-slate-600">🌙 {{ $item['nights'] }} malam</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp {{ number_format($item['subtotal']) }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Rp {{ number_format($item['price'] ?? 0) }}/malam</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-200 my-4"></div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-slate-900">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($finalTotal) }}</span>
                    </div>
                </div>

                {{-- Guest Information Card --}}
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Data Tamu</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-600">Nama Tamu</p>
                            <p class="font-semibold text-slate-900">{{ session('guest.name', 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Nomor Telepon</p>
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
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Metode Pembayaran</h3>

                    <div class="space-y-3 mb-6 text-sm text-slate-600">
                        <p><strong>Midtrans Snap</strong> menerima berbagai metode pembayaran:</p>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Kartu Kredit / Debit
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Transfer Bank
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
                                QRIS & Gerai Ritel
                            </li>
                        </ul>
                    </div>

                    <button id="pay-button"
                            class="w-full px-6 py-3 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-bold text-center">
                        💳 Lanjut Pembayaran
                    </button>

                    <p class="text-xs text-slate-500 text-center mt-4">
                        Pembayaran Anda dilindungi oleh Midtrans
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
        throw new Error(data.error ?? 'Gagal menyinkronkan status pembayaran.');
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
            let serverMessage = 'Terjadi kesalahan pada server. Silahkan coba lagi.';

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
            button.innerHTML = '💳 Lanjut Pembayaran';
            return;
        }

        const data = await response.json();
        console.log('PAYMENT RESPONSE:', data);

        if (!data.snap_token) {
            Swal.fire('Error', data.error ?? 'Gagal membuat token pembayaran', 'error');
            button.disabled = false;
            button.innerHTML = '💳 Lanjut Pembayaran';
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);

                    Swal.fire('Sukses!', 'Pembayaran berhasil. Terima kasih!', 'success').then(() => {
                        window.location.href = "{{ route('tamu.payment.success') }}";
                    });
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = '💳 Lanjut Pembayaran';
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onPending: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);

                    Swal.fire('Menunggu', 'Pembayaran Anda sedang diproses...', 'info').then(() => {
                        window.location.href = `${orderBaseUrl}/${data.order_id}`;
                    });
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = '💳 Lanjut Pembayaran';
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onError: function () {
                Swal.fire('Gagal', 'Pembayaran gagal. Silahkan coba lagi.', 'error');
                button.disabled = false;
                button.innerHTML = '💳 Lanjut Pembayaran';
            },
            onClose: function () {
                button.disabled = false;
                button.innerHTML = '💳 Lanjut Pembayaran';
            }
        });
    } catch (error) {
        console.error('ERROR:', error);
        Swal.fire('Error', 'Terjadi kesalahan. Silahkan coba lagi.', 'error');
        button.disabled = false;
        button.innerHTML = '💳 Lanjut Pembayaran';
    }
});
</script>
@endsection
