<template>
  <div class="flex flex-row items-center justify-center gap-20">
    <InputField
      labelName="Breite"
      type="number"
      ref="product_dimension_width"
      :min="0"
    />
    <InputField
      labelName="Höhe"
      type="number"
      ref="product_dimension_height"
      :min="0"
    />
    <InputField
      labelName="Tiefe"
      type="number"
      ref="product_dimension_depth"
      :min="0"
    />
    <ButtonField
      icon-src="/img/addBlack.svg"
      @click="addDimension"
      class="mt-16"
    />
  </div>
  <div class="flex flex-row max-w-[35rem] gap-4 overflow-x-auto">
    <template v-for="(dimension, i) in dimensions" :key="i">
      <div
        @click="deleteDimension(dimension)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer',
          'min-w-[5rem] group relative border rounded-md py-3 px-4 flex flex-col items-center justify-center text-sm font-medium hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ]"
      >
        <p>{{ dimension.width }} cm x</p>
        <p>{{ dimension.height }} cm x</p>
        <p>{{ dimension.depth }} cm</p>
      </div>
    </template>
  </div>
  <!-- <div class="flex flex-row justify-center w-full gap-4 mx-5 overflow-x-auto">
    <div
      v-for="(dim, i) in dimensions"
      :key="i"
      class="flex flex-row justify-between p-5 mt-4 ml-3 text-white bg-gray-900 rounded-2xl"
    >
      <span>{{ dim.width }}cm</span>
      <span>x</span>
      <span>{{ dim.height }}cm</span>
      <span>x</span>
      <span>{{ dim.depth }}cm</span>
      <button @click="deleteDimension(dim)">
        <img src="/img/bin.svg" alt="delete" class="w-5" />
      </button>
    </div>
  </div> -->
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import { DimensionAttribute } from "../../types/api";
import { AttributeType } from "../../types/api-values";

export default defineComponent({
  components: {
    ButtonField,
    InputField,
  },
  data() {
    return {
      dimensions: new Set<DimensionAttribute>(),
      width: {} as typeof InputField,
      height: {} as typeof InputField,
      depth: {} as typeof InputField,
    };
  },
  mounted() {
    this.width = this.$refs.product_dimension_width as typeof InputField;
    this.height = this.$refs.product_dimension_height as typeof InputField;
    this.depth = this.$refs.product_dimension_depth as typeof InputField;
  },
  methods: {
    async addDimension() {
      let dim: DimensionAttribute = {
        id: 0,
        type: AttributeType.DIMENSION,
        width: this.width.getValue() ?? 0,
        height: this.height.getValue() ?? 0,
        depth: this.depth.getValue() ?? 0,
      };
      if (this.dimensions.has(dim)) {
        return;
      }
      this.dimensions.add(dim);
      console.log(this.dimensions);
      this.width.setValue("");
      this.height.setValue("");
      this.depth.setValue("");
    },
    async deleteDimension(dim: DimensionAttribute) {
      this.dimensions.delete(dim);
    },
    getWidth() {
      return (
        this.$refs.product_dimension_width as typeof InputField
      ).getValue();
    },
    setWidth(width: number) {
      (this.$refs.product_dimension_width as typeof InputField).setValue(width);
    },
    getHeight() {
      return (
        this.$refs.product_dimension_height as typeof InputField
      ).getValue();
    },
    setHeight(height: number) {
      (this.$refs.product_dimension_height as typeof InputField).setValue(
        height
      );
    },
    getDepth() {
      return (
        this.$refs.product_dimension_depth as typeof InputField
      ).getValue();
    },
    setDepth(depth: number) {
      (this.$refs.product_dimension_depth as typeof InputField).setValue(depth);
    },
  },
});
</script>
