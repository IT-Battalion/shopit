<template>
  <div class="flex flex-col w-40 my-5">
    <label class="mb-3 ml-3 text-base text-gray-400">{{ labelName }}</label>
    <input
      class="px-3 py-2 text-white bg-gray-900 shadow appearance-none rounded-xl"
      ref="input"
      :value="value"
      :type="type"
      :placeholder="placeholder"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    labelName: String,
    value: String,
    placeholder: String,
    type: {
      type: String,
      default: "text",
    },
  },
  methods: {
    getValue() {
      return (this.$refs.input as HTMLInputElement).value;
    },
  },
});
</script>
