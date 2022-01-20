<template>
  <div
    :class="[this.class]"
    class="grid grid-cols-1 text-xs text-gray-400 grid-rows-"
  >
    <div v-if="attributes['0']">Kleidergröße: {{ attributes[0].id }}</div>
    <div
      v-if="attributes['1']"
      class="grid grid-cols-2 grid-rows-3 place-items-center"
    >
      <a class="row-span-3 cols-span-1">Dimension: </a
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
    <div v-if="attributes['3']">Farbe: {{ attributes[3].name }}</div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { SelectedAttributes } from "../types/api";

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
    };
  },
});
</script>
