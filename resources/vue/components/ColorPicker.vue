<template>
  <div class="w-1/4 p-5 bg-elevatedDark rounded-3xl">
    <h2 class="w-full mb-5 text-2xl font-semibold text-center text-white">
      Farben auswahl
    </h2>
    <InputField labelName="Farbname" ref="selectedName" class="w-full mx-auto"/>
    <div class="flex flex-row items-center justify-center mb-3">
      <input type="color" name="color" v-model="selectedColor"/>
      <ButtonField
        iconSrc="/img/add.svg"
        class="ml-5 bg-elevatedColor"
        @click="addColor"
      />
    </div>
    <div class="flex flex-row overflow-x-auto gap-x-2 shrink-0">
      <div v-for="c in this.colors" :key="c.color" class="">
        <span
          @click="removeColor(c.color, c.name)"
          :style="'background-color:' + c.color"
          class="w-10 min-w-[2.5rem] h-10 rounded-2xl hover:cursor-pointer block"
        ></span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import ButtonField from "./ButtonField.vue";
import InputField from "./InputField.vue";

export default defineComponent({
  components: {ButtonField, InputField},
  data() {
    return {
      selectedColor: "#000",
      colors: [] as { color: string, name: string }[],
    };
  },
  methods: {
    removeColor(color: string, name: string) {
      this.colors.forEach((value, index, array) => {
        if (value.color === color && value.name === name) {
          array.splice(index, 1);
        }
      });
    },
    addColor() {
      let obj = {color: this.selectedColor, name: (this.$refs.selectedName as typeof InputField).getValue()}
      this.colors.push(obj);
      (this.$refs.selectedName as typeof InputField).setValue("");
      this.selectedColor = "#000";
    },
    setSelectedName(name: string) {
      (this.$refs.selectedName as typeof InputField).setValue(name);
    },
    getSelectedName() {
      return (this.$refs.selectedName as typeof InputField).getValue();
    },
  },
});
</script>
