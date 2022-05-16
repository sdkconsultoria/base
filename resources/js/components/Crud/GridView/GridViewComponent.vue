<template>
  <div>
    <SearchComponent />
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div
            class="
              shadow
              overflow-hidden
              border-b border-gray-200
              sm:rounded-lg
            "
          >
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
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
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="model in data.data" :key="model.id">
                  <td
                    v-for="field in fields"
                    :key="field"
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                  >
                    {{ model[field] }}
                  </td>
                  <td><ActionColumn :model_id="model.id"/></td>
                </tr>
              </tbody>
            </table>
            <PaginationComponent :data="data" />
          </div>
        </div>
      </div>
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
