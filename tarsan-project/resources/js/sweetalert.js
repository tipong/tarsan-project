// resources/js/sweetalert.js
import Swal from 'sweetalert2';

window.Swal = Swal;

// Helper function untuk success notification
window.showSuccess = (title, message = '') => {
    Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 3000,
        timerProgressBar: true,
        confirmButtonColor: '#3b82f6'
    });
};

// Helper function untuk error notification
window.showError = (title, message = '') => {
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#ef4444'
    });
};

// Helper function untuk warning notification
window.showWarning = (title, message = '') => {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonColor: '#f59e0b'
    });
};

// Helper function untuk info notification
window.showInfo = (title, message = '') => {
    Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        timer: 3000,
        timerProgressBar: true,
        confirmButtonColor: '#3b82f6'
    });
};

// Helper function untuk confirmation dialog
window.showConfirm = (title, message, onConfirm) => {
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
};
