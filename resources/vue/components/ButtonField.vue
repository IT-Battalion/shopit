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
      text-black
    "
    type="button"
  >
    <svg
      v-if="loading"
      class="animate-spin h-5 w-5"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
      />
    </svg>
    <span v-if="name && !loading" class="mr-3">{{ name }}</span
    ><img v-if="!loading" :src="iconSrc" class="w-7 h-7" />
  </button>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    iconSrc: String,
    name: String,
    loading: {
      type: Boolean,
      default: false,
    },
  },
});
</script>
