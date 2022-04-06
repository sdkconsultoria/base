<template>
  <div class="flex">
    <form
      :data-title="$parent.translations.delete_question"
      :data-confirm="$parent.translations.delete"
      :data-cancel="$parent.translations.cancel"
      :action="`${$parent.routes.resource}/${model_id}`"
      class="form-question"
      method="POST"
      @submit.prevent="onSubmit"
    >
      <input type="hidden" name="_token" value="' . csrf_token() . '" />
      <input type="hidden" name="_method" value="DELETE" />
      <button class="h-5 w-5 mr-1 text-gray-400" type="submit">
        <TrashIcon />
      </button>
    </form>
    <a :href="`${$parent.routes.resource}/update/${model_id}`">
      <PencilIcon class="h-5 w-5 mr-1 text-gray-400" />
    </a>
    <a :href="`${$parent.routes.resource}/${model_id}`">
      <EyeIcon class="h-5 w-5 mr-1 text-gray-400" />
    </a>
  </div>
</template>

<script>
import Swal from "@node/sweetalert2";
import { TrashIcon, PencilIcon, EyeIcon } from "@heroicons/vue/outline";
// import
// var csrf_token = $('meta[name="csrf-token"]').attr('content');

export default {
  name: "ActionColumn",
  props: {
    model_id: Number,
  },
  components: {
    TrashIcon,
    PencilIcon,
    EyeIcon,
  },
  methods: {
    onSubmit(event) {
      Swal.fire({
        title: event.target.dataset.title,
        text: event.target.dataset.text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: event.target.dataset.cancel,
        confirmButtonText: event.target.dataset.confirm,
      }).then((result) => {
        if (result.value) {
          event.target.submit();
        }
      });
    },
  },
};
</script>
