<template>
  <div class="flex">
    <DeleteModel
      :translations="$parent.translations"
      :routes="$parent.routes"
      :model_id="model_id"
    >
      <button class="h-5 w-5 mr-1 text-gray-400" type="submit">
        <TrashIcon />
      </button>
    </DeleteModel>
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
import DeleteModel from "./../Form/DeleteModelComponent.vue";

export default {
  name: "ActionColumn",
  props: {
    model_id: Number,
  },
  components: {
    TrashIcon,
    PencilIcon,
    EyeIcon,
    DeleteModel,
  },
};
</script>
