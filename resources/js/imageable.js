import Swal from '@node/sweetalert2'

function imageable() {
    let types = document.getElementsByClassName("imageable-type");

    for(let i = 0; i < types.length; i++) {
        types[i].onchange = function (event) {
            fetch(this.dataset.href, {
                method: 'POST',
                headers:{
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({type: this.value})
            })
            .then(response => response.json())
            .then(data => {

            });
        }
    }
}

imageable();
window.imageable = imageable;
