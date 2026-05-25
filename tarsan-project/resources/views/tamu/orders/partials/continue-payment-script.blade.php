<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
const orderBaseUrl = "{{ url('/tamu/orders') }}";
const paymentOrderBaseUrl = "{{ url('/tamu/payment/orders') }}";

async function syncExistingOrderPayment(orderId, result = {}) {
    const url = "{{ route('tamu.payment.sync', ':id') }}".replace(':id', orderId);
    const response = await fetch(url, {
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
        throw new Error(data.error ?? 'Failed to sync payment status.');
    }

    return data;
}

async function continuePayment(orderId, button) {
    const originalLabel = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '⏳ Memproses...';

    try {
        const url = "{{ route('tamu.payment.continue', ':id') }}".replace(':id', orderId);
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error ?? 'Failed to continue payment.');
        }

        if (data.payment_status === 'paid') {
            Swal.fire('Success', data.message ?? 'Payment has been verified.', 'success')
                .then(() => window.location.reload());
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: async function(result) {
                try {
                    await syncExistingOrderPayment(orderId, result);

                    Swal.fire('Success!', 'Payment successful. Thank you!', 'success')
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

                    Swal.fire('Pending', 'Your payment is being processed...', 'info')
                        .then(() => window.location.href = `${orderBaseUrl}/${orderId}`);
                } catch (syncError) {
                    console.error('SYNC ERROR:', syncError);
                    button.disabled = false;
                    button.innerHTML = originalLabel;
                    Swal.fire('Error', syncError.message, 'error');
                }
            },
            onError: function() {
                Swal.fire('Failed', 'Payment failed. Please try again.', 'error');
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
        Swal.fire('Error', error.message ?? 'An error occurred. Please try again.', 'error');
        button.disabled = false;
        button.innerHTML = originalLabel;
    }
}

document.querySelectorAll('[data-continue-payment]').forEach((button) => {
    button.addEventListener('click', () => continuePayment(button.dataset.orderId, button));
});
</script>
