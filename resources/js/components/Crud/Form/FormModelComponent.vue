<template>
  <div class="p-4 bg-base-200 mb-5 shadow rounded-lg">
    <form
      id="form-create"
      :action="`${routes.api}`"
      method="POST"
      @submit.prevent="onSubmit"
    >
      <slot></slot>
      <input type="hidden" name="_token" :value="csrf" />
      <div v-for="field in fields" :key="field.name" class="form-group pr-1">
        <component
          :is="field.component"
          :name="field.name"
          :label="field.label"
          :tooltip="field.tooltip"
          :extra="field.extra"
          :value="field.value"
          :loadOptionsFromUrl="field.loadOptionsFromUrl"
          :errors="errors"
          :submited="submited"
        >
        </component>
      </div>
      <button class="btn btn-primary" type="submit" name="button">
        {{ button_text }}
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
    model_id: String,
  },
  data() {
    return {
      errors: {},
      submited: false,
      status: 0,
      button_text: "",
      url: this.routes.api,
    };
  },
  mounted() {
    if (this.model_id) {
      this.button_text = this.translations.edit;
      this.url += `/${this.model_id}`;
    } else {
      this.button_text = this.translations.create;
    }
  },
  methods: {
    submit(url) {
      let search_form = document.getElementById("form-create");
      let form_data = new FormData(search_form);

      fetch(this.url, {
        body: form_data,
        method: "post",
      })
        .then((response) => {
          this.status = response.status;
          this.submited = true;
          return response.json();
        })
        .then((response) => {
          if (this.status == 200) {
            let message;
            if (this.model_id) {
              message = {
                text: this.translations.edited,
                type: "success",
              };
            } else {
              message = {
                text: this.translations.created,
                type: "success",
              };
            }

            localStorage.setItem("toast", JSON.stringify(message));
            window.location.assign(
              `${this.routes.resource}/${response.model.id}`
            );
          }

          this.errors = response;
        });
    },
    onSubmit(event) {
      this.submit();
    },
  },
};
</script>
