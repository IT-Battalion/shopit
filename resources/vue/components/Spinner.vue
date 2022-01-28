<template>
  <svg
    v-if="loading"
    class="w-5 h-5 animate-spin animate-reverse"
    style="animation-direction: alternate-reverse; animation-timing-function: ease-in-out"
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    title="Loading..."
  >
    <path
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
    />
  </svg>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
  },
});
</script>
