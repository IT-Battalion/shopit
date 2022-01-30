<template>
  <div
    :class="[this.class]"
    class="flex flex-col gap-2 my-4 text-xs font-light text-white"
  >
    <div v-if="attributes['3']" class="flex flex-row">
      <span>Farbe: {{ attributes[3].name }}</span>
      <div
        class="rounded-xl border border-white h-4 w-4 ml-[.5ch]"
        :style="'background-color: #' + attributes[3].color"
      />
    </div>
    <div v-if="attributes['0']">
      Kleidergröße: {{ clothingSizeValues[attributes["0"].size] }}
    </div>
    <div
      v-if="attributes['1']"
      class="grid grid-cols-2 grid-rows-3 place-items-start w-36"
    >
      <span class="self-start row-span-3 cols-span-1">Dimension: </span
      ><span class="row-span-1 cols-span-1"
        >{{ attributes[1].width.value }}{{ attributes[1].width.unit }} x</span
      >
      <span class="row-span-1 cols-span-1"
        >{{ attributes[1].height.value }}{{ attributes[1].height.unit }} x</span
      >
      <span class="row-span-1 cols-span-1"
        >{{ attributes[1].depth.value }}{{ attributes[1].depth.unit }}</span
      >
    </div>
    <div v-if="attributes['2']">
      Volumen: {{ attributes[2].volume.value }}{{ attributes[2].volume.unit }}
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
