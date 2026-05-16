<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

<!-- Compiled Assets (Static) -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- SweetAlert2 (If not bundled) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<!-- Custom Script for SweetAlert Helpers -->
<script>
    // SweetAlert2 Helpers
    window.showSuccess = (title, message = '') => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: title,
                text: message,
                timer: 3000,
                timerProgressBar: true,
                confirmButtonColor: '#3b82f6'
            });
        }
    };
    window.showError = (title, message = '') => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                confirmButtonColor: '#ef4444'
            });
        }
    };
    window.showWarning = (title, message = '') => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: title,
                text: message,
                confirmButtonColor: '#f59e0b'
            });
        }
    };
    window.showInfo = (title, message = '') => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: title,
                text: message,
                timer: 3000,
                timerProgressBar: true,
                confirmButtonColor: '#3b82f6'
            });
        }
    };
    window.showConfirm = (title, message, onConfirm) => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    onConfirm();
                }
            });
        }
    };
</script>
