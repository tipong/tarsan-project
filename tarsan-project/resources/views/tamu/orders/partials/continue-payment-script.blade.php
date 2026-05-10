<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
const orderBaseUrl = "{{ url('/tamu/orders') }}";
const paymentOrderBaseUrl = "{{ url('/tamu/payment/orders') }}";

async function syncExistingOrderPayment(orderId, result = {}) {
    const response = await fetch(`${paymentOrderBaseUrl}/${orderId}/sync`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(result)
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error ?? 'Gagal menyinkronkan status pembayaran.');
    }

    return data;
}

async function continuePayment(orderId, button) {
    const originalLabel = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '⏳ Memproses...';

    try {
        const response = await fetch(`${paymentOrderBaseUrl}/${orderId}/continue`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error ?? 'Gagal melanjutkan pembayaran.');
        }

        if (data.payment_status === 'paid') {
            Swal.fire('Sukses', data.message ?? 'Pembayaran sudah terverifikasi.', 'success')
                .then(() => window.location.reload());
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: async function(result) {
                try {
                    await syncExistingOrderPayment(orderId, result);

                    Swal.fire('Sukses!', 'Pembayaran berhasil. Terima kasih!', 'success')
                        .then(() => window.location.reload());
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = originalLabel;
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onPending: async function(result) {
                try {
                    await syncExistingOrderPayment(orderId, result);

                    Swal.fire('Menunggu', 'Pembayaran Anda sedang diproses...', 'info')
                        .then(() => window.location.href = `${orderBaseUrl}/${orderId}`);
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = originalLabel;
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onError: function() {
                Swal.fire('Gagal', 'Pembayaran gagal. Silahkan coba lagi.', 'error');
                button.disabled = false;
                button.innerHTML = originalLabel;
            },
            onClose: function() {
                button.disabled = false;
                button.innerHTML = originalLabel;
            }
        });
    } catch (error) {
        console.error('CONTINUE PAYMENT ERROR:', error);
        Swal.fire('Error', error.message ?? 'Terjadi kesalahan. Silahkan coba lagi.', 'error');
        button.disabled = false;
        button.innerHTML = originalLabel;
    }
}

document.querySelectorAll('[data-continue-payment]').forEach((button) => {
    button.addEventListener('click', () => continuePayment(button.dataset.orderId, button));
});
</script>
