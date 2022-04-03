<template>
  <div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
      <div class="flex-1 flex justify-between sm:hidden">
        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-600 bg-white hover:bg-gray-50"> Previous </a>
        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-600 bg-white hover:bg-gray-50"> Next </a>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-600">
            Showing
            <span class="font-medium">{{data.from}}</span>
            -
            <span class="font-medium">{{data.to}}</span>
            of
            <span class="font-medium">{{data.total}}</span>
            results
          </p>
        </div>
        <div>
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <label
              v-for="(link, index) in data.links" :key="index"
              v-html="link.label"
              @click="reloadDataFromApi(link.url, data.current_page)"
              :class="getClass(index)">
            </label>
            <!-- <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 3 </a>
            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-600"> ... </span>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 8 </a> -->
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  name: 'Pagination',
  props: {
    data: Object,
  },
  methods: {
    getClass(index)
    {
      let {current_page, links} = { ...this.data };

      if(index == 0){
        return "relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 cursor-pointer";
      }

      if(index == links.length - 1){
        return "relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 cursor-pointer";
      }

      if(index == current_page){
        return "bg-blue-100 bg-white border-gray-300 text-gray-500 hover:bg-gray-500 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-pointer";
      }

      return "bg-white border-gray-300 text-gray-500 hover:bg-gray-500 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-pointer";
    },
    setQueryToUrl(url)
    {
      let new_url = new URL(url);
      let query_params = new URLSearchParams(new_url.search);

      history.replaceState(null, null, `?${query_params.toString()}`);
    },
    reloadDataFromApi(url, current_page) {
      this.setQueryToUrl(url);
      this.$parent.fetchData(url);
    },
  }
};
</script>
