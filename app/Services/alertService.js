import Swal from 'sweetalert2';

export const alertService = {

    success(title, text = '') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'success',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Entendido',
            fontFamily: '"Plus Jakarta Sans", sans-serif'
        });
    },

    error(title, text = '') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'error',
            confirmButtonColor: '#dc2626',
            fontFamily: '"Plus Jakarta Sans", sans-serif'
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
            fontFamily: '"Plus Jakarta Sans", sans-serif'
        });
        return result.isConfirmed;
    }
};
