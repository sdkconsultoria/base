<template>
    <div class="form-control w-full mb-2">
        <LabelComponent :label="label" :tooltip="tooltip" />
        <select v-model="current_value" :name="name" class="select select-bordered w-full" :class="getFieldClass(name)">
            <option disabled selected>Selecciona una opción</option>
            <option v-for="option in options" :value="option.name">{{option.name}}</option>
        </select>
        <div class="text-red-500 text-xs font-semibold">
            <p v-for="(error, index) in errors[name]" :key="index">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
import getFieldClass from "./getFieldClass";
import LabelComponent from "./components/LabelComponent.vue";
import { resquestToApi } from '@base/js/request/resquestToApi';

export default {
    name: "SelectedField",
    components: {
        LabelComponent
    },
    props: {
        name: String,
        tooltip: String,
        extra: JSON,
        label: String,
        value: String,
        errors: JSON,
        submited: Boolean,
        loadOptionsFromUrl: String,
        options: Array,
    },
    data() {
        return {
            current_value: this.value,
            options: this.options,
        };
    },
    mounted() {
        this.loadFromApi();
    },
    methods: {
        getFieldClass,
        async loadFromApi() {
            if (this.loadOptionsFromUrl) {
                let response = await resquestToApi(this.loadOptionsFromUrl);
                this.options = response.data;
            }
        },
    },
};
</script>
