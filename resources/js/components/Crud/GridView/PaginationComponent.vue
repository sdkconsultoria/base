<template>
  <div class="flex justify-between">
    <p>
        {{ $parent.translations.pagination.showing }}
        <span class="font-medium">{{ data.from }}</span>
        -
        <span class="font-medium">{{ data.to }}</span>
        {{ $parent.translations.pagination.of }}
        <span class="font-medium">{{ data.total }}</span>
        {{ $parent.translations.pagination.results }}
    </p>
    <div class="btn-group">
        <button
            class="btn"
            :class="{'btn-disabled': !data.prev_page_url}"
            @click="reloadDataFromApi(data.prev_page_url)"
        >
          {{ $parent.translations.pagination.previous }}
        </button>
        <template v-for="(page, index) in data.last_page" :key=index>
            <button
                class="btn"
                :class="{'btn-active': data.current_page == index+1}"

                v-if="showNumeber(index+1, data)"
                @click="reloadDataFromApi(data.first_page_url.replace('page=1', `page=${index+1}`))"
                >
                    {{index + 1}}
            </button>
        </template>
        <button
          class="btn"
          :class="{'btn-disabled': !data.next_page_url}"
          @click="reloadDataFromApi(data.next_page_url)"
        >
          {{ $parent.translations.pagination.next }}
        </button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "Pagination",
  props: {
    data: Object,
  },
  methods: {
    setQueryToUrl(url) {
      let new_url = new URL(url);
      let query_params = new URLSearchParams(new_url.search);

      history.replaceState(null, null, `?${query_params.toString()}`);
    },
    reloadDataFromApi(url) {
      this.setQueryToUrl(url);
      this.$parent.fetchData(url);
    },
    showNumeber(index, data) {
        if(data.current_page == index) {
            return true;
        }

        if(index == 1) {
            return true;
        }

        if (data.last_page == index) {
            return true;
        }

        if (data.current_page < index+3 && data.current_page > index-3) {
            return true;
        }

        return false;
    }
  },
};
</script>
