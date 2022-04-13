/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import Vue from '@node/vue'
// import { createApp } from 'vue';
//
//
//  import FormComponent from "./components/FormComponent.vue";
//  const app = createApp(FormComponent).mount("#form-component");

// createApp(App).mount("#app");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//import * from './componets'

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('images-component', require('./components/ImagesComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

import { createApp } from 'vue'

import GridViewComponent from "./components/Crud/GridView/GridViewComponent.vue";
import FormModelComponent from "./components/Crud/Form/FormModelComponent.vue";

const app = createApp({});

app.component('GridView', GridViewComponent)
app.component('FormModel', FormModelComponent)

app.mount('#app');