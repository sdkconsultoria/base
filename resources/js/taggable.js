import Swal from '@node/sweetalert2'

function taggable() {
    let types = document.getElementsByClassName("taggable-button");

    for(let i = 0; i < types.length; i++) {
        types[i].onclick = function (event) {
            let value = document.getElementById(this.dataset.value).value;
            console.log(value);
            fetch(this.dataset.href, {
                method: 'POST',
                headers:{
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({tag: value})
            })
            .then(response => response.json())
            .then(data => {

            });
        }
    }
}

taggable();
window.taggable = taggable;
