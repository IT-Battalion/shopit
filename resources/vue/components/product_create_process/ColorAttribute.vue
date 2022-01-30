<template>
  <div class="w-full p-5 bg-elevatedDark rounded-3xl">
    <InputField
      labelName="Farbname"
      ref="selectedName"
      class="w-full mx-auto"
      :errorMessage="inputError"
    />
    <div class="flex flex-row items-center justify-center mb-3">
      <input type="color" name="color" v-model="selectedColor" />
      <ButtonField
        class="ml-5 bg-elevatedColor"
        @click="addColor"
      >
        <template v-slot:icon><img src="/img/add.svg" /></template>
      </ButtonField>
    </div>
    <div class="flex flex-row max-w-full overflow-x-auto gap-x-2 shrink-0">
      <div v-for="[name, color] in colors.entries()" :key="name">
        <span
          @click="removeColor(name, color)"
          :style="'background-color:' + color"
          class="
            w-10
            min-w-[2.5rem]
            h-10
            rounded-2xl
            hover:cursor-pointer
            block
          "
        ></span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import { useToast } from "vue-toastification";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";

export default defineComponent({
  components: { ButtonField, InputField },
  data() {
    return {
      selectedColor: "#000",
      colors: new Map<string, string>(),
      colorSet: new Set<string>(),
      inputError: "",
      currentName: {} as typeof InputField,
    };
  },
  mounted() {
    this.currentName = this.$refs.selectedName as typeof InputField;
  },
  methods: {
    removeColor(name: string, color: string) {
      this.colorSet.delete(color);
      this.colors.delete(name);
    },
    addColor() {
      this.inputError = "";
      let colorName = (this.$refs.selectedName as typeof InputField).getValue();

      if (colorName == "") {
        this.inputError = "Dieses Feld darf nicht leer sein!";
        return;
      }

      if (this.colors.has(colorName) || this.colorSet.has(this.selectedColor)) {
        this.toast.error("Farbname und Farbe müssen einzigartig sein!");
        return;
      }

      this.colors.set(colorName, this.selectedColor);
      this.colorSet.add(this.selectedColor);

      this.currentName.setValue("");
      this.selectedColor = "#000";
    },
    setSelectedName(name: string) {
      this.currentName.setValue(name);
    },
    getSelectedName() {
      return this.currentName.getValue();
    },
  },
  setup() {
    const toast = useToast();
    return {
      toast,
    };
  },
});
</script>
