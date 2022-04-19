import { createApp } from 'vue'
import GridViewComponent from "./components/Crud/GridView/GridViewComponent.vue";
import FormModelComponent from "./components/Crud/Form/FormModelComponent.vue";
import DeleteModelComponent from "./components/Crud/Form/DeleteModelComponent.vue";
import TextFieldComponent from "./components/Crud/Form/Fields/TextFieldComponent.vue";

const app = createApp({});

app.component('GridView', GridViewComponent)
app.component('FormModel', FormModelComponent)
app.component('DeleteModel', DeleteModelComponent)
app.component('TextField', TextFieldComponent)

app.mount('#app');