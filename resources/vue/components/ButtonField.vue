<template>
  <button
    class="
      h-10
      py-1
      my-auto
      bg-white
      rounded-3xl
      hover:bg-gray-300
      flex flex-row
      justify-center
      items-center
      px-7
    "
    type="button"
  >
    <span v-if="acceptName" class="mr-3">{{ name }}</span
    ><img :src="iconSrc" class="w-7 h-7" />
  </button>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    iconSrc: String,
    name: String,
    acceptName: Boolean,
  },
});
</script>
