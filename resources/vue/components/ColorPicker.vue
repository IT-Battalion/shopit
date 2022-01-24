<template>
  <div class="w-1/4 p-5 bg-elevatedDark rounded-3xl">
    <h2 class="w-full mb-5 text-2xl font-semibold text-center text-white">
      Farben auswahl
    </h2>
    <InputField labelName="Farbname" class="w-full mx-auto" />
    <div class="flex flex-row items-center justify-center mb-3">
      <input type="color" name="color" v-model="selectedColor" />
      <ButtonField
        iconSrc="/img/add.svg"
        class="ml-5 bg-elevatedColor"
        @click="colors.push(selectedColor)"
      />
    </div>
    <div class="flex flex-row overflow-x-auto gap-x-2 shrink-0">
      <template v-for="color in colors" :key="color">
        <span
          @click="colors.pop()"
          :style="'background-color:' + color"
          class="w-10 min-w-[2.5rem] h-10 rounded-2xl hover:cursor-pointer"
        ></span>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import ButtonField from "./ButtonField.vue";
import InputField from "./InputField.vue";

export default defineComponent({
  components: { ButtonField, InputField },
  data() {
    return {
      selectedColor: "#31a8e2",
      colors: ["#31a8e2"],
    };
  },
});
</script>