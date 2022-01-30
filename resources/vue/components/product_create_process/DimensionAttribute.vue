<template>
  <div class="flex flex-row items-center justify-center gap-20">
    <InputField
      labelName="Breite"
      type="number"
      ref="product_dimension_width"
      :min="0"
      :errorMessage="widthError"
    />
    <InputField
      labelName="Höhe"
      type="number"
      ref="product_dimension_height"
      :min="0"
      :errorMessage="heightError"
    />
    <InputField
      labelName="Tiefe"
      type="number"
      ref="product_dimension_depth"
      :min="0"
      :errorMessage="depthError"
    />
    <ButtonField
      @click="addDimension"
      class="mt-16"
    >
      <template v-slot:icon><img src="/img/addBlack.svg" /></template>
    </ButtonField>
  </div>
  <div class="flex flex-row max-w-[35rem] gap-4 overflow-x-auto">
    <template v-for="(dimension, i) in dimensions" :key="i">
      <div
        @click="deleteDimension(dimension)"
        @mouseover="hover.set(i, true)"
        @mouseleave="hover.delete(i)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer',
          'min-w-[5rem] group relative border rounded-md py-3 px-4 flex flex-col items-center justify-center text-sm font-medium hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ]"
      >
        <div v-if="!hover.get(i)">
          <p>{{ dimension.width }} cm x</p>
          <p>{{ dimension.height }} cm x</p>
          <p>{{ dimension.depth }} cm</p>
        </div>
        <img v-else src="/img/bin.svg" alt="löschen" class="w-5 h-5" />
      </div>
    </template>
  </div>
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
      widthError: "",
      heightError: "",
      depthError: "",
      hover: new Map<number, Boolean>(),
    };
  },
  mounted() {
    this.width = this.$refs.product_dimension_width as typeof InputField;
    this.height = this.$refs.product_dimension_height as typeof InputField;
    this.depth = this.$refs.product_dimension_depth as typeof InputField;
  },
  methods: {
    async addDimension() {
      this.widthError = "";
      this.heightError = "";
      this.depthError = "";
      if (
        this.width.getValue() &&
        this.height.getValue() &&
        this.depth.getValue()
      ) {
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
      } else {
        if (!this.width.getValue()) this.widthError = "Weite ist erforderlich!";
        if (!this.height.getValue())
          this.heightError = "Höhe ist erforderlich!";
        if (!this.depth.getValue()) this.depthError = "Tiefe ist erforderlich!";
      }
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
