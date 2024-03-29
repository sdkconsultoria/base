import { createApp } from 'vue'
import GridViewComponent from "./components/Crud/GridView/GridViewComponent.vue";
import FormModelComponent from "./components/Crud/Form/FormModelComponent.vue";
import DeleteModelComponent from "./components/Crud/Form/DeleteModelComponent.vue";
import TextFieldComponent from "./components/Crud/Form/Fields/TextFieldComponent.vue";
import NumericFieldComponent from "./components/Crud/Form/Fields/NumericFieldComponent.vue";
import FileFieldComponent from "./components/Crud/Form/Fields/FileFieldComponent.vue";
import PasswordFieldComponent from "./components/Crud/Form/Fields/PasswordFieldComponent.vue";
import SelectedFieldComponent from "./components/Crud/Form/Fields/SelectedFieldComponent.vue";
import CustomLink from "./components/Crud/GridView/CustomLink.vue";
import Swal from "@node/sweetalert2";


let element = document.getElementById('app')

if (element !== null) {
    const app = createApp({});

    app.component('GridView', GridViewComponent)
    app.component('FormModel', FormModelComponent)
    app.component('DeleteModel', DeleteModelComponent)
    app.component('TextField', TextFieldComponent)
    app.component('FileField', FileFieldComponent)
    app.component('NumericField', NumericFieldComponent)
    app.component('PasswordFieldComponent', PasswordFieldComponent)
    app.component('SelectedField', SelectedFieldComponent)
    app.component('CustomLink', CustomLink)

    app.mount('#app');
}


document.querySelectorAll('.question').forEach(item => {
    item.addEventListener('click', async event => {
        if (event.target.dataset.question == undefined) return true;
        event.preventDefault();
        Swal.fire({
            title: event.target.dataset.question,
            icon: "question",
            confirmButtonText: 'Si, Continuar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                window.location.href = event.target.href;
            }
        });

    });
});
