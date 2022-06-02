<template>
  <!-- Colors -->
  <div>
    <div v-if="attributes[3]?.length > 0">
      <h3 class="text-sm font-medium text-white">Color</h3>

      <RadioGroup v-model="selectedColor" class="mt-4">
        <RadioGroupLabel class="sr-only"> Choose a color</RadioGroupLabel>
        <div class="flex items-center space-x-3">
          <RadioGroupOption
            v-for="(color, index) in attributes[3]"
            :key="color.name"
            v-slot="{ active, checked }"
            :value="index"
          >
            <div
              :class="[
                selectedColor,
                active && checked ? 'ring ring-offset-1' : '',
                !active && checked ? 'ring-2' : '',
                '-m-0.5 relative p-0.5 ring-white rounded-xl flex items-center justify-center cursor-pointer focus:outline-none w-8 h-8',
              ]"
              :style="'background-color: #' + color.color"
              :title="color.name"
            >
              <RadioGroupLabel as="p" class="sr-only">
                {{ color.name }}
              </RadioGroupLabel>
              <!--span
                aria-hidden="true"
                class="w-8 h-8 border border-white rounded-full border-opacity-10"
                :style="'background-color: #' + color.color"
              /-->
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>

    <!-- Sizes -->
    <div v-if="attributes[0]?.length > 0" class="mt-10">
      <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-white">Größe</h3>
        <!--        <a-->
        <!--          href="#"-->
        <!--          class="text-sm font-medium text-gray-400 hover:text-gray-700"-->
        <!--          >Size guide</a-->
        <!--        >-->
      </div>

      <RadioGroup v-model="selectedSize" class="mt-4">
        <RadioGroupLabel class="sr-only"> Choose a size</RadioGroupLabel>
        <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
          <RadioGroupOption
            v-for="(size, index) in attributes[0]"
            :key="size.size"
            v-slot="{ checked }"
            :title="clothingSizeValues[size.size]"
            :value="index"
            as="template"
          >
            <div
              class="shadow-sm text-white cursor-pointer group relative rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase focus:outline-none sm:flex-1 sm:py-6 hover:scale-105 focus:scale-105"
            >
              <RadioGroupLabel as="p">
                {{ clothingSizeValues[size.size] }}
              </RadioGroupLabel>
              <div
                :class="[
                  checked ? 'border-indigo-500 border-2' : 'border-gray-400 border',
                  'absolute -inset-px rounded-md pointer-events-none',
                ]"
                aria-hidden="true"
              />
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>

    <!-- Dimension -->
    <div v-if="attributes[1]?.length > 0" class="mt-10">
      <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-white">Dimensionen</h3>
        <!--        <a-->
        <!--          href="#"-->
        <!--          class="text-sm font-medium text-gray-400 hover:text-gray-700"-->
        <!--          >Size guide</a-->
        <!--        >-->
      </div>

      <RadioGroup v-model="selectedDimension" class="mt-4">
        <RadioGroupLabel class="sr-only"> Choose a size</RadioGroupLabel>
        <div class="flex flex-row flex-wrap gap-4">
          <RadioGroupOption
            v-for="(dimension, index) in attributes[1]"
            :key="dimension.type"
            v-slot="{ checked }"
            :value="index"
            as="template"
          >
            <div
              :class="[
                'shadow-sm text-gray-300 cursor-pointer',
                'min-w-[2rem] group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm text-center font-medium focus:outline-none sm:flex-1 sm:py-6 w-20 hover:scale-105 focus:scale-105',
              ]"
            >
              <RadioGroupLabel as="p">
                <span>{{ dimension.width.value }}{{ dimension.width.unit }} x </span>
                <span>{{ dimension.height.value }}{{ dimension.height.unit }} x </span>
                <span>{{ dimension.depth.value }}{{ dimension.depth.unit }}</span>
              </RadioGroupLabel>
              <div
                :class="[
                  checked ? 'border-indigo-500 border-2' : 'border-gray-400 border',
                  'absolute -inset-px rounded-md pointer-events-none',
                ]"
                aria-hidden="true"
              />
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>

    <!-- Volume -->
    <div v-if="attributes[2]?.length > 0" class="mt-10">
      <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-white">Volumen</h3>
        <!--        <a-->
        <!--          href="#"-->
        <!--          class="text-sm font-medium text-gray-400 hover:text-gray-700"-->
        <!--          >Size guide</a-->
        <!--        >-->
      </div>

      <RadioGroup v-model="selectedVolume" class="mt-4">
        <RadioGroupLabel class="sr-only"> Choose a size</RadioGroupLabel>
        <div class="flex flex-row flex-wrap gap-4">
          <RadioGroupOption
            v-for="(volume, index) in attributes[2]"
            :key="volume.type"
            v-slot="{ active, checked }"
            :title="volume.volume.value + volume.volume.unit"
            :value="index"
            as="template"
          >
            <div
              class="shadow-sm text-gray-300 cursor-pointer min-w-[2rem] group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase focus:outline-none sm:flex-1 sm:py-6 hover:scale-105 focus:scale-105"
            >
              <RadioGroupLabel as="p">
                {{ volume.volume.value }}{{ volume.volume.unit }}
              </RadioGroupLabel>
              <div
                :class="[
                  checked ? 'border-indigo-500 border-2' : 'border-gray-400 border',
                  'absolute -inset-px rounded-md pointer-events-none',
                ]"
                aria-hidden="true"
              />
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from "@headlessui/vue";
import {Attributes, SelectedAttributes} from "../types/api";
import {AttributeType, clothingSizeLabels} from "../types/api-values";
import {PropType} from "vue";

export default defineComponent({
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  },
  props: {
    productAttributes: {
      type: Object as PropType<Attributes>,
      default: {},
    },
  },
  data() {
    return {
      selectedColor: 0,
      selectedSize: 0,
      selectedDimension: 0,
      selectedVolume: 0,
      attributes: this.productAttributes,
      clothingSizeValues: clothingSizeLabels,
    };
  },
  computed: {
    selectedAttributes() {
      let selectedAttributes: SelectedAttributes = {};
      if (this.selectedColor in this.productAttributes[AttributeType.COLOR]) {
        selectedAttributes[AttributeType.COLOR] =
          this.productAttributes[AttributeType.COLOR][this.selectedColor];
      }
      if (this.selectedSize in this.productAttributes[AttributeType.CLOTHING]) {
        selectedAttributes[AttributeType.CLOTHING] =
          this.productAttributes[AttributeType.CLOTHING][this.selectedSize];
      }
      if (
        this.selectedDimension in
        this.productAttributes[AttributeType.DIMENSION]
      ) {
        selectedAttributes[AttributeType.DIMENSION] =
          this.productAttributes[AttributeType.DIMENSION][
            this.selectedDimension
            ];
      }
      if (this.selectedVolume in this.productAttributes[AttributeType.VOLUME]) {
        selectedAttributes[AttributeType.VOLUME] =
          this.productAttributes[AttributeType.VOLUME][this.selectedVolume];
      }
      return selectedAttributes;
    },
  },
  methods: {
    getSelected() {
      return this.selectedAttributes;
    },
  },
});
</script>

<style>
</style>
