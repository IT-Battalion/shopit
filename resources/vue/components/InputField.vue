<template>
  <div class="flex flex-col min-w-[10rem] my-5">
    <label class="mb-3 ml-3 text-base text-gray-400">{{ labelName }}</label>
    <div class="flex flex-row px-3 py-2 items-center w-full items-center">
      <input
        class="text-white bg-gray-900 shadow appearance-none rounded-xl w-full"
        ref="input"
        v-model="fieldValue"
        :type="type"
        :placeholder="placeholder"
        :step="step"
        :min="min"
        :max="max"
        :minlength="minlength"
        :maxlength="maxlength"
      />
      <div class="text-gray-400 text-base pl-3"><slot name="unit"></slot></div>
    </div>
    <div class="flex flex-row mt-5" v-if="errorMessage">
      <img v-if="errorIcon" :src="errorIcon" class="w-5 h-5 mr-3" />
      <p class="text-base font-semibold text-red-400">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    labelName: String,
    value: [String, Boolean, Number],
    placeholder: String,
    min: Number,
    max: Number,
    minlength: Number,
    maxlength: Number,
    type: {
      type: String,
      default: "text",
    },
    step: Number,
    errorIcon: String,
    errorMessage: String,
  },
  emits: ["update:value"],
  data() {
    return {
      fieldValue: this.value,
    };
  },
  methods: {
    getValue() {
      return (this.$refs.input as HTMLInputElement).value;
    },
    setValue(value: any) {
      (this.$refs.input as HTMLInputElement).value = value;
    },
  },
  watch: {
    fieldValue(val) {
      this.$emit("update:value", val);
    },
    value(val) {
      this.fieldValue = val;
    },
  },
});
</script>
