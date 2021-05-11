import Swal from '@node/sweetalert2'

const divs = document.querySelectorAll('.form-question');

divs.forEach(el => el.addEventListener('submit', event => {
    event.preventDefault();

    Swal.fire({
        title: event.target.dataset.title,
        text: event.target.dataset.text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: event.target.dataset.cancel,
        confirmButtonText: event.target.dataset.confirm,
    }).then((result) => {
        if (result.value) {
            event.target.submit();
        }
    });
}));
