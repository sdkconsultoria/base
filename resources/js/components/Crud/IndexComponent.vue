<template>
  <div>
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
                  <!-- aqui van los headers -->
                  <th v-for="field in fields" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      {{field}}
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="model in data.data">
                      <td v-for="field in fields" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{model[field]}}
                      </td>
                  </tr>
                <!-- aqui van los bodies -->
              </tbody>
            </table>
            <pagination-component/>
            <!-- links -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import PaginationComponent from './PaginationComponent.vue';

export default {
  name: 'GridView',
  props: {
    api: String,
    fields: Array,
  },
  components: {
    PaginationComponent
  },
  setup(props) {
    const data = ref({});
    const loading = ref(true);
    const error = ref(null);

    function fetchData() {
      loading.value = true;
      return fetch(props.api)
        .then(response => response.json())
        .then(response => {
            data.value = response;
        })
        .catch((error) => {
          // handle the error
        })
        .then(() => loading.value = false);
    }

    onMounted(() => {
      fetchData();
    });

    return {
      data,
      loading,
      error,
    };
  },
};
</script>
