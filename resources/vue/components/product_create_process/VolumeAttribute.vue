<template>
  <div class="flex flex-col items-center justify-center w-full gap-4">
    <InputField
      type="number"
      ref="product_volume"
      :min="1"
      :errorMessage="errorMessage"
    />
    <ButtonField icon-src="/img/addBlack.svg" @click="addVolume" />
  </div>
  <div class="flex flex-row max-w-[35rem] gap-4 overflow-x-auto">
    <template v-for="(vol, i) in volumes" :key="i">
      <div
        @click="deleteVolume(vol)"
        :class="[
          'shadow-sm text-gray-300 cursor-pointer',
          'min-w-[5rem] group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
        ]"
      >
        <p class="whitespace-nowrap">{{ vol.volume }} {{ vol.type }}</p>
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
      volume: {} as typeof InputField,
      errorMessage: "",
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
        volume: this.volume.getValue(),
      };
      this.volumes.add(vol);
    },
    async deleteVolume(vol: VolumeAttribute) {
      this.volumes.delete(vol);
    },
    getVolume() {
      return (this.$refs.product_volume as typeof InputField).getValue();
    },
    setVolume(volume: number) {
      (this.$refs.product_volume as typeof InputField).setValue(volume);
    },
  },
});
</script>

<style scoped>
</style>
