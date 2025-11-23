// Custom Alert Function using SweetAlert2
function showAlert(title, text, icon = 'info', confirmButtonText = 'OK') {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
        confirmButtonColor: '#f97316',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-6 py-3'
        }
    });
}

function showConfirm(title, text, confirmButtonText = 'Ya', cancelButtonText = 'Batal') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#6b7280',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-6 py-3',
            cancelButton: 'rounded-xl px-6 py-3'
        }
    });
}

function showSuccess(title, text, redirect = null) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#f97316',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-6 py-3'
        }
    }).then(() => {
        if (redirect) {
            window.location.href = redirect;
        }
    });
}

function showError(title, text) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#f97316',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-6 py-3'
        }
    });
}
