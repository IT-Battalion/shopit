<template>
  <v-md-preview :text="text"/>
</template>

<script>
import {defineComponent} from "@vue/runtime-core";

export default defineComponent({
  data() {
    return {
      text: "Hoppala! Leer! Bitte kontaktiere einen Administrator."
    }
  },
  mounted() {
    //TODO: Load text
  }
});
</script>

<style scoped>

</style>
