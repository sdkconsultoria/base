<template>
  <div>
    <div>
      <form
        data-title="' . $this->model::getTranslate('delete_question') . '"
        data-confirm="' . $this->model::getTranslate('delete') . '"
        data-cancel="' . __('base::app.common.cancel') . '"
        class="form-question"
        method="POST"
        action="' . $this->model::getRoute('destroy', $this->key) . '"
      >
        <input type="hidden" name="_token" value="' . csrf_token() . '" />
        <input type="hidden" name="_method" value="DELETE" />
        <button class="h-5 w-5 mr-1" type="submit">
          <TrashIcon />
        </button>
      </form>
      <a href=""> <PencilIcon class="h-5 w-5 mr-1" /> </a>
      <a href=""> <EyeIcon class="h-5 w-5 mr-1" /> </a>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { TrashIcon, PencilIcon, EyeIcon } from "@heroicons/vue/solid";

export default {
  name: "ActionColumn",
  props: {
    api: String,
    search: Array,
  },
  components: {
    TrashIcon,
    PencilIcon,
    EyeIcon,
  },
  setup(props) {
    // const error = ref(null);

    onMounted(() => {});

    return {};
  },
};
</script>
