<template>
  <div class="flex flex-col w-40 my-5">
    <label class="mb-3 ml-3 text-base text-gray-400">{{ labelName }}</label>
    <input
      class="px-3 py-2 text-white bg-gray-900 shadow appearance-none rounded-xl"
      ref="input"
      :value="value"
      :type="type"
      :placeholder="placeholder"
      :step="step"
    />
    <div class="flex flex-row mt-5" v-if="errorMessage">
      <img v-if="errorIcon" :src="errorIcon" class="h-5 w-5 mr-3" />
      <p class="text-red-400 text-base font-semibold">{{ errorMessage }}</p>
    </div>
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
    step: Number,
    errorIcon: String,
    errorMessage: String,
  },
  methods: {
    getValue() {
      return (this.$refs.input as HTMLInputElement).value;
    },
  },
});
</script>
