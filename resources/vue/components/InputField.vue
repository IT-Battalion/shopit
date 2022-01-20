<template>
  <form action="GET" class="flex flex-col w-40 my-10">
    <label class="mb-3 ml-3 text-base text-gray-400">{{ labelName }}</label>
    <input
      class="px-3 py-2 text-white bg-gray-900 shadow appearance-none rounded-xl"
      ref="input"
    />
  </form>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    labelName: String,
    value: String,
  },
  methods: {
    getValue() {
      return (this.$refs.input as HTMLInputElement).value;
    },
  },
});
</script>
