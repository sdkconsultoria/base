<template>
  <div class="form-control w-full mb-2">
    <LabelComponent :label="label" :tooltip="tooltip" />
    <input
      :name="name"
      type="text"
      class="input input-bordered w-full"
      :class="getFieldClass(name)"
      v-model="current_value"
    />
    <div class="text-red-500 text-xs font-semibold">
      <p v-for="(error, index) in errors[name]" :key="index">
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script>
import getFieldClass from "./getFieldClass";
import LabelComponent from "./components/LabelComponent.vue";

export default {
  name: "FileField",
  components: {
    LabelComponent
  },
  props: {
    name: String,
    tooltip: String,
    extra: JSON,
    label: String,
    value: String,
    errors: JSON,
    submited: Boolean,
  },
  data() {
    return {
      current_value: this.value,
    };
  },
  methods: {
    getFieldClass,
  },
};
</script>
