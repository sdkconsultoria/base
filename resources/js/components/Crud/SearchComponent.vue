<template>
  <div>
      <button type="button" class="btn btn-warning mb-2 flex flex-row items-center">
          {{$parent.translations.grid.advanced_search}}
          <!-- ' . Base::icon('chevron-right', ['class' => 'h-5 ml-3', 'x-show' => '!open']) .'
          ' . Base::icon('chevron-up', ['class' => 'h-5 ml-3', 'x-show' => 'open']) . ' -->
      </button>
      <form id="search-form"  class="flex flex-row flex-wrap" action="" method="get">
            <!-- ' . $this->forms() . ' -->
          <div class="w-full flex flex-row justify-end">
              <button class="items-center text-sm rounded-l-lg shadow-md text-gray-700 p-1 bg-yellow-300 mb-2 flex flex-row" type="button">
                  <RefreshIcon class= 'h-4 mr-1' /> {{$parent.translations.grid.clear}}
              </button>
              <button class="items-center text-sm rounded-r-lg shadow-md text-gray-700 p-1 bg-blue-300 mb-2 flex flex-row" type="button">
                  <DocumentSearchIcon class= 'h-4 mr-1' /> {{$parent.translations.grid.search}}
              </button>
          </div>
      </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { DocumentSearchIcon, RefreshIcon } from '@heroicons/vue/solid'

export default {
  name: "Search",
  props: {
    api: String,
    search: Array,
  },
  components: {
    DocumentSearchIcon,
    RefreshIcon,
  },
  setup(props) {
    // const error = ref(null);

    onMounted(() => {
    });

    return {
    };
  },
};
</script>
