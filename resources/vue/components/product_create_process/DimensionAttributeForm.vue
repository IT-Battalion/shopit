<template>
  <form class="flex flex-row items-center justify-center" @submit.prevent="addDimension">
    <InputField
      labelName="Breite"
      type="number"
      v-model:value="width.value"
      :min="0"
      :errorMessage="widthError"
    >
      <template v-slot:unit>
        <select v-model="width.unit" class="text-black">
          <option value="mm">mm</option>
          <option value="cm">cm</option>
          <option value="dm">dm</option>
          <option value="m">m</option>
        </select>
      </template>
    </InputField>
    <InputField
      labelName="Höhe"
      type="number"
      v-model:value="height.value"
      :min="0"
      :errorMessage="heightError"
    >
      <template v-slot:unit>
        <select v-model="height.unit" class="text-black">
          <option value="mm">mm</option>
          <option value="cm">cm</option>
          <option value="dm">dm</option>
          <option value="m">m</option>
        </select>
      </template>
    </InputField>
    <InputField
      labelName="Tiefe"
      type="number"
      v-model:value="depth.value"
      :min="0"
      :errorMessage="depthError"
    >
      <template v-slot:unit>
        <select v-model="depth.unit" class="text-black">
          <option value="mm">mm</option>
          <option value="cm">cm</option>
          <option value="dm">dm</option>
          <option value="m">m</option>
        </select>
      </template>
    </InputField>
    <ButtonField
      class="mt-16"
      type="submit"
    >
      <template v-slot:icon><img src="/img/addBlack.svg"/></template>
    </ButtonField>
  </form>
  <p class="text-red-400 text-base font-semibold mb-3" v-if="error !== ''">{{ error }}</p>
  <div class="flex flex-row gap-4 overflow-x-auto">
    <template v-for="(dimension, i) in dimensions" :key="i">
      <div
        @click="deleteDimension(i)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer min-w-[5rem] max-w-[35rem] group relative border rounded-md py-3 px-4 flex flex-col items-center justify-center text-sm font-medium hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ] + (highlight === i ? [' border-red-400'] : [])"
      >
        <div>
          <span class="whitespace-nowrap">{{ dimension.width.value }} {{ dimension.width.unit }} x </span>
          <span class="whitespace-nowrap">{{ dimension.height.value }} {{ dimension.height.unit }} x </span>
          <span class="whitespace-nowrap">{{ dimension.depth.value }} {{ dimension.depth.unit }} </span>
          <img src="/img/bin.svg" alt="löschen" class="w-5 h-5 ml-1 inline" />
        </div>
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import {DimensionAttribute, Meter} from "../../types/api";
import {AttributeType} from "../../types/api-values";
import {PropType} from "vue";

export default defineComponent({
  name: 'DimensionAttributeForm',
  components: {
    ButtonField,
    InputField,
  },
  props: {
    dimensions: {
      type: Array as PropType<Array<DimensionAttribute>>,
      required: true,
    },
  },
  emits: ['update:dimensions'],
  data() {
    return {
      localDimensions: this.dimensions as DimensionAttribute[],
      width: {value: 0, unit: 'mm'} as Meter,
      height: {value: 0, unit: 'mm'} as Meter,
      depth: {value: 0, unit: 'mm'} as Meter,
      highlight: -1,
      widthError: "",
      heightError: "",
      depthError: "",
      error: "",
    };
  },
  methods: {
    async addDimension() {
      this.widthError = "";
      this.heightError = "";
      this.depthError = "";
      this.error = "";
      this.highlight = -1;
      if (
        this.width.value && this.width.unit &&
        this.height.value && this.height.unit &&
        this.depth.value && this.depth.unit
      ) {
        let dim: DimensionAttribute = {
          id: 0,
          type: AttributeType.DIMENSION,
          width: this.width,
          height: this.height,
          depth: this.depth,
        };
        for (let index in this.localDimensions) {
          let dimension = this.localDimensions[index];
          if (dimension.width.value === dim.width.value && dimension.width.unit === dim.width.unit &&
            dimension.height.value === dim.height.value && dimension.height.unit === dim.height.unit &&
            dimension.depth.value === dim.depth.value && dimension.depth.unit === dim.depth.unit) {
            this.error = "Diese Werte sind bereits hinzugefügt";
            this.highlight = Number.parseInt(index);
            return;
          }
        }
        this.localDimensions.push(dim);
        this.width = {value: 0, unit: 'mm'};
        this.height = {value: 0, unit: 'mm'};
        this.depth = {value: 0, unit: 'mm'};
        this.$emit('update:dimensions', this.localDimensions);
      } else {
        if (!this.width.value) this.widthError = "Weite ist erforderlich!";
        if (!this.height.value) this.heightError = "Höhe ist erforderlich!";
        if (!this.depth.value) this.depthError = "Tiefe ist erforderlich!";
      }
    },
    async deleteDimension(index: number) {
      this.localDimensions.splice(index, 1);
      this.$emit('update:dimensions', this.localDimensions);
    },
  },
});
</script>
