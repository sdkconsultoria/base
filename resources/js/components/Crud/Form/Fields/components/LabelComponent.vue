<template>
      <label for="" class="label">
        <span class="label-text" :class="{'tooltip tooltip-right': tooltip}" :data-tip="tooltip">{{ label }}</span>
      </label>
  </template>

  <script>

  export default {
    name: "Label",
    props: {
      label: String,
      tooltip: String,
    }
  };
  </script>
