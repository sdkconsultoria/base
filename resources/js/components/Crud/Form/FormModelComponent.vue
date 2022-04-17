<template>
  <div class="p-4 bg-white mb-5 shadow rounded-lg">
    <form
      id="form-create"
      :action="`${routes.api}`"
      method="POST"
      @submit.prevent="onSubmit"
    >
      <input type="hidden" name="_token" :value="csrf" />
      <div v-for="field in fields" :key="field.name" class="form-group pr-1">
        <label for="" class="text-gray-600 font-medium">
          {{ field.label }}
        </label>
        <input
          :name="field.name"
          type="text"
          class="form-control form-control-l form-control-r border-gray-300"
          :class="getFieldClass(field.name)"
          :value="field.value"
        />
        <div class="text-red-500 text-xs font-semibold">
          <p v-for="(error, index) in errors[field.name]" :key="index">
            {{ error }}
          </p>
        </div>
      </div>

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
  data() {
    return {
      errors: {},
      submited: false,
      status: 0,
    };
  },
  methods: {
    getFieldClass(field) {
      if (this.submited) {
        if (this.errors[field]) {
          return "border-red-500";
        }

        return "border-green-500";
      }
    },
    submit(url) {
      let search_form = document.getElementById("form-create");
      let form_data = new FormData(search_form);

      fetch(this.routes.api, {
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
            window.location.assign(`${this.routes.resource}/${response.model.id}`);
            const message = {'text': this.translations.created, 'type': 'success'};
            localStorage.setItem('toast', JSON.stringify(message));
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
