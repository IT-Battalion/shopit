<template>
  <div class="flex flex-col items-center justify-center w-full gap-5 mt-10">
    <h2 class="text-2xl font-semibold text-center text-white">
      {{ labelName }}
    </h2>
    <slot></slot>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ButtonField from "./ButtonField.vue";

export default defineComponent({
  name: "FileList",
  components: {
    ButtonField,
  },
  props: {
    labelName: String,
  },
});
</script>
