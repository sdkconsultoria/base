<template>
  <div class="flex">
    <form
      id="form-create"
      :action="`${routes.api}`"
      method="POST"
      @submit.prevent="onSubmit"
    >
      <input type="hidden" name="_token" :value="csrf" />

      <button class="btn btn-primary" type="submit" name="button">
        {{ translations.create }}
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Form",
  props: {
    fields: Array,
    translations: JSON,
    routes: JSON,
    csrf: String,
  },
  methods: {
    submit(url) {
      let search_form = document.getElementById("form-create");
      let form_data = new FormData(search_form);

      fetch(this.routes.api, {
        body: form_data,
        method: "post",
      })
        .then((response) => response.json())
        .then((response) => {
          data.value = response;
        })
        .catch((error) => {
          // handle the error
        });
    },
    onSubmit(event) {
      this.submit();
      console.log("anime");
    },
  },
};
</script>
