<template>
  <div
    :class="[this.class]"
    class="
      grid grid-cols-1
      text-xs
      font-light
      text-gray-400
      grid-rows-3
      items-center
    "
  >
    <div v-if="attributes['0']">
      Kleidergröße: {{ clothingSizeValues[attributes["0"].size] }}
    </div>
    <div
      v-if="attributes['1']"
      class="grid grid-cols-2 grid-rows-3 place-items-start w-36"
    >
      <a class="row-span-3 cols-span-1 self-start">Dimension: </a
      ><a class="row-span-1 cols-span-1"
        >{{ attributes[1].width.value }}{{ attributes[1].width.unit }} x</a
      >
      <a class="row-span-1 cols-span-1"
        >{{ attributes[1].height.value }}{{ attributes[1].height.unit }} x</a
      >
      <a class="row-span-1 cols-span-1"
        >{{ attributes[1].depth.value }}{{ attributes[1].depth.unit }}</a
      >
    </div>
    <div v-if="attributes['2']">
      Volumen: {{ attributes[2].volume.value }}{{ attributes[2].volume.unit }}
    </div>
    <div v-if="attributes['3']" class="flex flex-row">
      <a>Farbe: {{ attributes[3].name }}</a>
      <div
        class="rounded-full h-3 w-3 ml-3"
        :style="'background-color: #' + attributes[3].color"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { SelectedAttributes } from "../types/api";
import { AttributeType, clothingSizeLabels } from "../types/api-values";

export default defineComponent({
  props: {
    selectedAttributes: {
      type: Object as PropType<SelectedAttributes>,
      required: true,
    },
    class: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      attributes: this.selectedAttributes,
      clothingSizeValues: clothingSizeLabels,
    };
  },
});
</script>
