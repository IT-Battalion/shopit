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
      gap-3
      px-7
      text-black
    "
    type="button"
    :disabled="loading || iconSpinner"
  >
    <svg
      v-if="loading"
      class="animate-spin h-5 w-5 mx-1"
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
    <slot v-if="!loading" name="text" />
    <span v-if="!loading && !iconSpinner" class="w-7 h-7 flex items-center justify-center">
      <slot name="icon" />
    </span>
    <svg
      v-if="iconSpinner"
      class="animate-spin h-5 w-5 mx-1"
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
  </button>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    iconSpinner: {
      type: Boolean,
      default: false,
    },
  },
});
</script>
