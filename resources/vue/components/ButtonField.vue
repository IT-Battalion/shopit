<template>
  <button
    class="flex flex-row gap-3 items-center justify-center h-10 py-1 my-auto text-black bg-white  rounded-3xl hover:bg-gray-300 px-7"
    :type="type"
    :disabled="loading || iconSpinner"
  >
    <svg
      v-if="loading"
      class="w-5 h-5 mx-1 animate-spin"
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
    <slot name="text" v-if="!loading" />
    <span
      v-if="!loading && !iconSpinner"
      class="flex items-center justify-center w-7 h-7"
    >
      <slot name="icon" />
    </span>
    <svg
      v-if="iconSpinner"
      class="w-5 h-5 mx-1 animate-spin"
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
    buttonType: {
      type: String,
      default: "button",
    },
  },
  computed: {
    type() {
      switch (this.buttonType) {
        case "button":
          return "button";
        case "submit":
          return "submit";
        case "reset":
          return "reset";
        default:
          return undefined;
      }
    },
  },
});
</script>
