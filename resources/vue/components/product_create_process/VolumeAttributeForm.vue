<template>
  <div class="flex flex-col items-center justify-center w-full gap-4">
    <InputField
      type="number"
      v-model:value="volume.value"
      :min="1"
      :errorMessage="errorMessage"
    >
      <template v-slot:unit>
        <select v-model="volume.unit" class="text-black">
          <option value="ml">ml</option>
          <option value="cl">cl</option>
          <option value="dl">dl</option>
          <option value="l">l</option>
        </select>
      </template>
    </InputField>
    <ButtonField @click="addVolume">
      <template v-slot:icon><img src="/img/addBlack.svg" /></template>
    </ButtonField>
  </div>
  <div class="flex flex-row max-w-[35rem] gap-4 overflow-x-auto">
    <template v-for="(vol, i) in volumes" :key="i">
      <div
        @click="deleteVolume(i)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer min-w-[5rem] group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ] + (highlight === i ? [' border-red-400'] : [])"
      >
        <p class="whitespace-nowrap">
          {{ vol.volume.value }} {{ vol.volume.unit }}
        </p>
        <img src="/img/bin.svg" alt="löschen" class="w-5 h-5" />
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import {Liter, VolumeAttribute} from "../../types/api";
import { AttributeType } from "../../types/api-values";
import {PropType} from "vue";

export default defineComponent({
  name: 'VolumeAttributeForm',
  components: {
    InputField,
    ButtonField,
  },
  props: {
    volumes: {
      type: Array as PropType<VolumeAttribute[]>,
      required: true,
    },
  },
  emits: ['update:volumes'],
  data() {
    return {
      localVolumes: [] as VolumeAttribute[],
      volume: {value: 0, unit: 'l'} as Liter,
      highlight: -1,
      errorMessage: "",
    };
  },
  methods: {
    async addVolume() {
      this.errorMessage = "";
      this.highlight = -1;
      if (this.volume.value === 0) {
        this.errorMessage = "Dieses Feld darf nicht leer sein!";
        return;
      }
      let vol: VolumeAttribute = {
        id: 0,
        type: AttributeType.VOLUME,
        volume: {
          value: this.volume.value,
          unit: this.volume.unit,
        },
      };
      for (let index in this.localVolumes) {
        let element = this.localVolumes[index];
        if (element.volume.value === this.volume.value && element.volume.unit === this.volume.unit) {
          this.errorMessage = "Dieser Wert ist bereits hinzugefügt";
          this.highlight = Number.parseInt(index);
          return;
        }
      }
      this.localVolumes.push(vol);
      this.volume = {value: 0, unit: 'l'} as Liter;
      this.$emit('update:volumes', this.localVolumes);
    },
    async deleteVolume(index: number) {
      this.localVolumes.splice(index, 1);
      this.$emit('update:volumes', this.localVolumes);
    },
  },
});
</script>

<style scoped>
</style>
