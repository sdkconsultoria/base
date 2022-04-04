<template>
  <div
    v-contextmenu:contextmenu
    class="wrapper"
  >
    <code>Menu</code>
  </div>

  <v-contextmenu ref="contextmenu">
    <v-contextmenu-item>Detalles</v-contextmenu-item>
    <v-contextmenu-item>Editar</v-contextmenu-item>
    <v-contextmenu-item>Eliminar</v-contextmenu-item>
  </v-contextmenu>
</template>

<script lang="ts">
import { defineComponent } from "vue";

const {
  directive,
  version,
  Contextmenu,
  ContextmenuItem,
  ContextmenuDivider,
  ContextmenuSubmenu,
  ContextmenuGroup,
} = VContextmenu;

export default defineComponent({
  name: "ContextMenu",

  components: {
    [Contextmenu.name]: Contextmenu,
    [ContextmenuItem.name]: ContextmenuItem,
    [ContextmenuDivider.name]: ContextmenuDivider,
    [ContextmenuSubmenu.name]: ContextmenuSubmenu,
    [ContextmenuGroup.name]: ContextmenuGroup,
  },

  directives: {
    contextmenu: directive,
  },
});
</script>

<style scoped>
  .wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 300px;
    height: 200px;
    border: 3px dashed rgba(90, 167, 164, 0.9);
    border-radius: 8px;
    background-color: rgba(90, 167, 164, 0.2);
  }
</style>