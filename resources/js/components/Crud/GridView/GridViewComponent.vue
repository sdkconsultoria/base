<template>
    <div>
        <SearchComponent :create_route="create_route" :translations="translations" :searchisopen="searchisopen" >
            <slot></slot>
        </SearchComponent>
        <div class="overflow-x-auto">
            <table class="table w-full mt-3 mb-3">
                <thead>
                    <tr>
                        <th v-if="column_action_order == 'start'" width="100px"></th>

                        <OrderComponent v-for="field in fields" :key="field" :field="field" :current_order="current_order"
                            :label="translations[field]" />
                        <th v-if="column_action_order == 'end'" width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="model in data.data" :key="model.id">
                        <td v-if="column_action_order == 'start'">
                            <ActionColumn :template_actions="template_actions" :model_id="model.id" />
                        </td>
                        <td v-for="field in fields" :key="field">
                            {{ getValue(model, field) }}
                        </td>
                        <td v-if="column_action_order == 'end'">
                            <ActionColumn :template_actions="template_actions" :model_id="model.id" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="overflow-x-auto">
            <PaginationComponent :data="data" />
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import PaginationComponent from "./PaginationComponent.vue";
import OrderComponent from "./OrderComponent.vue";
import SearchComponent from "./SearchComponent.vue";
import ActionColumn from "./ActionColumn.vue";

export default {
    name: "GridView",
    props: {
        fields: Array,
        translations: JSON,
        routes: JSON,
        filters: JSON,
        create_route: String,
        template_actions: JSON,
        searchisopen: Boolean,
    },
    components: {
        PaginationComponent,
        OrderComponent,
        SearchComponent,
        ActionColumn,
    },

    methods: {
        getValue(model, field) {
            let array = field.split('.');

            if (array.length > 1) {
                let value = model[array[0]] ?? '-';
                for (let index = 1; index < array.length; index++) {
                    if (value == '-') {
                        return value;
                    }
                    value = value[array[index]] ?? '-';
                }
                return value;

            } else {
                return model[field] ?? '-';
            }
        },
        getSubpropierty(array) {

        }
    },
    setup(props) {
        const data = ref({});
        const column_action_order = import.meta.env.VITE_COLUMN_ACTION_ORDER ?? 'end';
        const loading = ref(true);
        const error = ref(null);
        const current_order = ref({
            field: "",
            order: "",
        });
        function addQueryToUrl(url) {
            return url + window.location.search;
        }

        function fetchData(url) {

            const cookieValue = document.cookie
                .split('; ')
                .find(row => row.startsWith('XSRF-TOKEN='))
                .split('=')[1];

            loading.value = true;
            return fetch(url, {
                "headers": {
                    "Accept": "application/json",
                    'X-XSRF-TOKEN': cookieValue
                }
            })
                .then((response) => response.json())
                .then((response) => {
                    data.value = response;
                })
                .catch((error) => {
                    // handle the error
                })
                .then(() => (loading.value = false));
        }

        onMounted(() => {
            fetchData(addQueryToUrl(props.routes.api));
        });

        return {
            data,
            loading,
            error,
            current_order,
            fetchData,
            column_action_order
        };
    },
};
</script>
