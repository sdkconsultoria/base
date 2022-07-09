<template>
  <div>
    <div class="flex mb-1">
        <a type="button" :href="create_route" class="btn btn-primary mr-1"> {{translations.create}} </a>

        <button
        @click="is_open_form = !is_open_form"
        type="button"
        class="btn btn-warning mb"
        >
        {{ $parent.translations.grid.advanced_search }}
        <ChevronRightIcon v-if="!is_open_form" class="h-5 ml-3" />
        <ChevronUpIcon v-if="is_open_form" class="h-5 ml-3" />
        </button>
    </div>
    <form
      @submit.prevent="onSubmit"
      v-if="is_open_form"
      class="flex flex-row flex-wrap"
      action=""
      method="get"
      id="search_form"
    >
      <input type="hidden" name="page" :value="query_params.get('page')">
      <input type="hidden" name="order" :value="query_params.get('order')">
      <div
        v-for="filter in this.$parent.filters"
        :key="filter.field"
        class="form-group pr-1"
      >
        <input
          :placeholder="$parent.translations[filter.field]"
          :name="filter.field"
          type="text"
          class="form-control form-control-l form-control-r border-gray-300"
          :value="query_params.get(filter.field)"
        />
      </div>
      <div class="w-full flex flex-row justify-end">
        <button
          class="
            items-center
            text-sm
            rounded-l-lg
            shadow-md
            text-gray-700
            p-1
            bg-yellow-300
            mb-2
            flex flex-row
          "
          type="button"
          @click="clearApi()"
        >
          <RefreshIcon class="h-4 mr-1" /> {{ $parent.translations.grid.clear }}
        </button>
        <button
          class="
            items-center
            text-sm
            rounded-r-lg
            shadow-md
            text-gray-700
            p-1
            bg-blue-300
            mb-2
            flex flex-row
          "
          type="submit"
        >
          <DocumentSearchIcon class="h-4 mr-1" />
          {{ $parent.translations.grid.search }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import {
  DocumentSearchIcon,
  RefreshIcon,
  ChevronRightIcon,
  ChevronUpIcon,
} from "@heroicons/vue/solid";

export default {
  name: "Search",
  props: {
    api: String,
    search: Array,
    translations: Object,
    create_route: String,
  },
  components: {
    DocumentSearchIcon,
    RefreshIcon,
    ChevronRightIcon,
    ChevronUpIcon,
  },
  data() {
    return {
      is_open_form: false,
      query_params: false,
    };
  },
  mounted() {
    this.query_params = new URLSearchParams(window.location.search);
    this.checkHasSearch();
  },
  methods: {
    checkHasSearch() {
      let search_params = this.query_params.entries();
      const params = [];

      for (let param of search_params) {
        params.push(param[0]);
      }

      for (let search_item of this.$parent.filters) {
        if (params.includes(search_item.field)) {
          this.is_open_form = true;
          return;
        }
      }
    },
    clearApi() {
      this.$parent.fetchData(this.$parent.routes.api);
      history.replaceState(null, null, location.href.split("?")[0]);
      this.query_params = new URLSearchParams(window.location.search);
    },
    onSubmit() {
      let search_form = document.getElementById('search_form');
      let form_data = new FormData(search_form);
      const form_data_string = new URLSearchParams(form_data).toString();
      this.$parent.fetchData(this.$parent.routes.api + '?'+ form_data_string);
      this.query_params = new URLSearchParams(this.$parent.routes.api + '?'+ form_data_string);
      history.pushState(null, null, '?'+ form_data_string);

    },
  },
};
</script>
