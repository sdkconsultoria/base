import Swal from "@node/sweetalert2";


export default function() {
    let toast_active = JSON.parse(localStorage.getItem('toast'));

    if (toast_active) {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: toast_active.type,
            title: toast_active.text
        })
        localStorage.removeItem('toast');
    }
}