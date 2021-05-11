import Swal from '@node/sweetalert2'

function question (element) {
    Swal.fire({
        title: element.dataset.title,
        text: element.dataset.text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: element.dataset.cancel,
        confirmButtonText: element.dataset.confirm,
    }).then((result) => {
        if (result.value) {
            deleteElement(element);
        }
    });
}

function deleteElement(element){
    fetch(element.dataset.href, {
        method: 'DELETE',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(data.data).remove();
    });
}

function initDelete() {
    let elements = document.getElementsByClassName("delete-elements");

    for(let i = 0; i < elements.length; i++) {
        elements[i].onclick = function (event) {
            question(this);
        }
    }
}

initDelete();
window.initDelete = initDelete;
