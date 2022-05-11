<template>
  <div class="flex flex-col items-center justify-center w-full gap-4">
    <InputField
      type="number"
      ref="product_volume"
      :min="1"
      :errorMessage="errorMessage"
    />
    <ButtonField @click="addVolume">
      <template v-slot:icon><img src="/img/addBlack.svg" /></template>
    </ButtonField>
  </div>
  <div class="flex flex-row max-w-[35rem] gap-4 overflow-x-auto">
    <template v-for="(vol, i) in volumes" :key="i">
      <div
        @click="deleteVolume(vol)"
        @mouseover="hover.set(i, true)"
        @mouseleave="hover.delete(i)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer',
          'min-w-[5rem] group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ]"
      >
        <p v-if="!hover.get(i)" class="whitespace-nowrap">
          {{ vol.volume.value }} {{ vol.volume.unit }}
        </p>
        <img v-else src="/img/bin.svg" alt="löschen" class="w-5 h-5" />
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import { VolumeAttribute } from "../../types/api";
import { AttributeType } from "../../types/api-values";

export default defineComponent({
  components: {
    InputField,
    ButtonField,
  },
  data() {
    return {
      volumes: new Set<VolumeAttribute>(),
      volume: InputField,
      errorMessage: "",
      hover: new Map<number, Boolean>(),
    };
  },
  mounted() {
    this.volume = this.$refs.product_volume as typeof InputField;
  },
  methods: {
    async addVolume() {
      this.errorMessage = "";
      if (this.volume.getValue() == "") {
        this.errorMessage = "Dieses Feld darf nicht leer sein!";
        return;
      }
      let vol: VolumeAttribute = {
        id: 0,
        type: AttributeType.VOLUME,
        volume: {
          value: this.volume.getValue(),
          unit: "l",
        },
      };
      this.volumes.add(vol);
    },
    async deleteVolume(vol: VolumeAttribute) {
      this.volumes.delete(vol);
    },
    getVolume() {
      return this.volume.getValue();
    },
    setVolume(volume: number) {
      this.volume.setValue(volume);
    },
    getVolumes(): Set<VolumeAttribute> {
      return this.volumes;
    },
    setVolumes(value: Set<VolumeAttribute>) {
      this.volumes = value;
    },
  },
});
</script>

<style scoped>
</style>
