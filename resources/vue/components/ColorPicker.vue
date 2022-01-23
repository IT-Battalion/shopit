<template>
  <div class="w-1/4">
    <div class="flex flex-row items-center mb-3">
      <input type="color" name="color" v-model="selectedColor" />
      <ButtonField
        iconSrc="/img/add.svg"
        class="ml-5 bg-elevatedColor"
        @click="colors.push(selectedColor)"
      />
    </div>
    <div class="grid grid-flow-col gap-2 auto-rows-auto">
      <template v-for="color in colors" :key="color">
        <span
          @click="colors.pop()"
          :style="'background-color:' + color"
          class="w-10 h-10 rounded-2xl"
        ></span>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import ButtonField from "./ButtonField.vue";

export default defineComponent({
  components: { ButtonField },
  data() {
    return {
      selectedColor: "#31a8e2",
      colors: ["#31a8e2"],
    };
  },
});
</script>