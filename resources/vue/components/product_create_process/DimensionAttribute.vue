<template>
  <div class="flex flex-col items-center justify-center w-1/4 p-5 ml-5  rounded-2xl bg-elevatedDark">
    <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
      Dimensionen
    </h2>
    <InputField labelName="Breite" type="number" ref="product_dimension_width" min="0"/>
    <InputField labelName="Höhe" type="number" ref="product_dimension_height" min="0"/>
    <InputField labelName="Tiefe" type="number" ref="product_dimension_depth" min="0"/>
    <ButtonField icon-src="/img/addBlack.svg" @click="addDimension"/>
  </div>
  <div class="flex flex-col w-1/6">
    <div v-for="(dim, i) in dimensions"
         class="flex flex-row justify-between bg-gray-900 text-white p-5 rounded-2xl ml-3 mt-4">
      <span>{{ dim.width }}cm</span>
      <span>x</span>
      <span>{{ dim.height }}cm</span>
      <span>x</span>
      <span>{{ dim.depth }}cm</span>
      <button @click="deleteDimension(i)">
        <img src="/img/bin.svg" alt="delete" class="w-5">
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import {TemporaryDimension} from "../../types/api";
import {TemporaryDimensionObject} from "../../types/api-values";

export default defineComponent({
  components: {
    ButtonField,
    InputField,
  },
  data() {
    return {
      dimensions: [] as TemporaryDimension[],
      width: {} as typeof InputField,
      height: {} as typeof InputField,
      depth: {} as typeof InputField,
    };
  },
  mounted() {
    this.width = (this.$refs.product_dimension_width as typeof InputField);
    this.height = (this.$refs.product_dimension_height as typeof InputField);
    this.depth = (this.$refs.product_dimension_depth as typeof InputField);
  },
  methods: {
    async addDimension() {
      let obj: TemporaryDimensionObject = new TemporaryDimensionObject(
        this.width.getValue() ?? 0,
        this.height.getValue() ?? 0,
        this.depth.getValue() ?? 0
      );
      this.dimensions.push(obj);
      this.width.setValue("");
      this.height.setValue("");
      this.depth.setValue("");
    },
    async deleteDimension(index: number) {
      this.dimensions.splice(index, 1);
    },
    getWidth() {
      return (this.$refs.product_dimension_width as typeof InputField).getValue();
    },
    setWidth(width: number) {
      (this.$refs.product_dimension_width as typeof InputField).setValue(width);
    },
    getHeight() {
      return (this.$refs.product_dimension_height as typeof InputField).getValue();
    },
    setHeight(height: number) {
      (this.$refs.product_dimension_height as typeof InputField).setValue(height);
    },
    getDepth() {
      return (this.$refs.product_dimension_depth as typeof InputField).getValue();
    },
    setDepth(depth: number) {
      (this.$refs.product_dimension_depth as typeof InputField).setValue(depth);
    },
  },
});
</script>
