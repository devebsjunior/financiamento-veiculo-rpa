import Swal from 'sweetalert2';

export const alertService = {

    success(title, text = '') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'success',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'ok',
            allowOutsideClick: false,
        });
    },

    error(title, text = '') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'error',
            confirmButtonColor: '#dc2626',
        });
    },

    async confirm(title, text = '') {
        const result = await Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sim, sair',
            cancelButtonText: 'Cancelar',
        });
        return result.isConfirmed;
    }
};
