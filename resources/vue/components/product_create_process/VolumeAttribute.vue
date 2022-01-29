<template>
  <div class="flex flex-col items-center justify-center w-1/4 p-5 ml-5 rounded-2xl bg-elevatedDark">
    <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
      Volumen
    </h2>
    <InputField type="number" ref="product_volume" min="1"/>
    <ButtonField icon-src="/img/addBlack.svg" @click="addVolume"/>
  </div>
  <div class="flex flex-col w-1/6">
    <div v-for="(vol, i) in volumes"
         class="flex flex-row justify-between bg-gray-900 text-white p-5 rounded-2xl ml-3 mt-4">
      <span>{{ vol }}L</span>
      <button @click="deleteVolume(i)">
        <img src="/img/bin.svg" alt="delete" class="w-5">
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";

export default defineComponent({
  components: {
    InputField,
    ButtonField,
  },
  data() {
    return {
      volumes: [] as number[],
      volume: {} as typeof InputField,
    };
  },
  mounted() {
    this.volume = (this.$refs.product_volume as typeof InputField);
  },
  methods: {
    async addVolume() {
      this.volumes.push(this.volume.getValue());
    },
    async deleteVolume(index: number) {
      this.volumes.splice(index, 1);
    },
    getVolume() {
      return (this.$refs.product_volume as typeof InputField).getValue();
    },
    setVolume(volume: number) {
      (this.$refs.product_volume as typeof InputField).setValue(volume);
    }
  }
});
</script>

<style scoped>

</style>
