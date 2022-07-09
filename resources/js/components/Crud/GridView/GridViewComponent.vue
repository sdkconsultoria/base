<template>
  <div>
    <SearchComponent :create_route="create_route" :translations="translations" />
    <table class="table w-full mt-3 mb-3">
        <thead>
        <tr>
            <OrderComponent
            v-for="field in fields"
            :key="field"
            :field="field"
            :current_order="current_order"
            :label="translations[field]"
            />
            <th width="100px"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="model in data.data" :key="model.id">
            <td
            v-for="field in fields"
            :key="field"
            >
            {{ model[field] }}
            </td>
            <td><ActionColumn :model_id="model.id"/></td>
        </tr>
        </tbody>
    </table>
    <PaginationComponent :data="data" />
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
  },
  components: {
    PaginationComponent,
    OrderComponent,
    SearchComponent,
    ActionColumn,
  },
  setup(props) {
    const data = ref({});
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
      return fetch(url, {"headers":{
        "Accept": "application/json",
        'X-XSRF-TOKEN': cookieValue
        }})
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
    };
  },
};
</script>
