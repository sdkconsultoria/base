import { createApp } from 'vue'
import GridViewComponent from "./components/Crud/GridView/GridViewComponent.vue";
import FormModelComponent from "./components/Crud/Form/FormModelComponent.vue";
import DeleteModelComponent from "./components/Crud/Form/DeleteModelComponent.vue";

const app = createApp({});

app.component('GridView', GridViewComponent)
app.component('FormModel', FormModelComponent)
app.component('DeleteModel', DeleteModelComponent)

app.mount('#app');