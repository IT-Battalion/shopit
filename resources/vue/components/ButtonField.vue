<template>
  <button
    :disabled="loading"
    :type="type"
    class="flex flex-row gap-3 items-center justify-center h-10 py-1 my-auto text-black bg-white  rounded-full hover:bg-gray-300 px-7"
    @click="this.$emit('click')"
  >
    <slot name="text"/>
    <span
      v-if="!loading"
      class="flex items-center justify-center w-7 h-7"
    >
      <slot name="icon"/>
    </span>
    <svg
      v-if="loading"
      class="w-5 h-5 mx-1 animate-spin"
      fill="none"
      stroke="currentColor"
      viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
      />
    </svg>
  </button>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";

export default defineComponent({
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: "button",
    },
  },
  emits: ['click'],
  computed: {
    buttonType(): "button" | "submit" | "reset" | undefined {
      const types = ["button", "submit", "reset"];
      if (this.type in types) return this.type as "button" | "submit" | "reset";
      return undefined;
    },
  },
});
</script>
