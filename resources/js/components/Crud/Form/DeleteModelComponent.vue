<template>
  <form
    :data-title="translations.delete_question"
    :data-confirm="translations.delete"
    :data-cancel="translations.cancel"
    :action="`${routes.resource}/${model_id}`"
    class="form-question"
    method="POST"
    @submit.prevent="onSubmit"
    :id="`delete-${model_id}`"
  >
    <input type="hidden" name="_token" :value="csrf" />
    <input type="hidden" name="_method" value="DELETE" />
    <slot>
      <button class="btn btn-danger ml-2" type="submit">
        {{ translations.delete }}
      </button>
    </slot>
  </form>
</template>

<script>
import Swal from "@node/sweetalert2";
import csrf from "@base/js/csrf_token";

console.log();
export default {
  name: "DeleteModel",
  data() {
    return {
      csrf: csrf(),
    };
  },
  props: {
    translations: JSON,
    routes: JSON,
    model_id: Number,
  },
  methods: {
    deleteModel() {
      let form = document.getElementById(`delete-${this.model_id}`);
      let data = new FormData(form);

      fetch(`${this.routes.api}/${this.model_id}`, {
        body: data,
        method: "post",
      }).then((response) => {
         if (response.ok) {
           const message = {'text': this.translations.deleted, 'type': 'success'};
           localStorage.setItem("toast", JSON.stringify(message));
           window.location.assign(
             `${this.routes.resource}`
           );
         }
        })
    },
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
          this.deleteModel();
        }
      });
    },
  },
};
</script>
