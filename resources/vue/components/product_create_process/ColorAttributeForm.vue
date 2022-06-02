<template>
  <div class="w-full p-5 bg-elevatedDark rounded-3xl">
    <form @submit.prevent="addColor">
      <InputField
        labelName="Farbname"
        class="w-full mx-auto"
        v-model:value="colorName"
        :errorMessage="nameError"
      />
      <InputField
        labelName="Farbe"
        class="w-full mx-auto"
        type="color"
        v-model:value="color"
        :errorMessage="colorError"
      />
      <div class="flex flex-row items-center justify-center mb-3">
        <ButtonField
          class="ml-5 bg-elevatedColor"
          type="submit"
        >
          <template v-slot:icon><img src="/img/add.svg"/></template>
        </ButtonField>
      </div>
    </form>
    <p class="text-red-400 text-base font-semibold mb-3" v-if="error !== ''">{{ error }}</p>
    <div class="flex flex-row max-w-full overflow-x-auto gap-x-2 shrink-0">
      <div v-for="(color, index) in colors" :key="color.color">
        <Log :debug="color"/>
        <span
          @click="removeColor(index)"
          :style="'background-color:' + color.color"
          class="
            w-10
            min-w-[2.5rem]
            h-10
            rounded-2xl
            hover:cursor-pointer
            block
          "
        >
          {{ color.name }}
          <img src="/img/bin.svg" alt="löschen" class="w-5 h-5 ml-1 inline" /><!-- TODO: make bin dark and fix sizing -->
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {useToast} from "vue-toastification";
import InputField from "../InputField.vue";
import ButtonField from "../ButtonField.vue";
import {Color, ColorAttribute} from "../../types/api";
import {PropType} from "vue";
import {AttributeType} from "../../types/api-values";
import Log from "../Log.vue";

export default defineComponent({
  name: 'ColorAttributeForm',
  components: {Log, ButtonField, InputField},
  props: {
    colors: {
      type: Array as PropType<ColorAttribute[]>,
      required: true,
    }
  },
  emits: ['update:colors'],
  data() {
    return {
      localColors: [] as ColorAttribute[],
      colorName: "",
      color: "#ffffff" as Color,
      highlight: -1,
      nameError: "",
      colorError: "",
      error: '',
    };
  },
  methods: {
    removeColor(index: number) {
      this.localColors.splice(index);
      this.$emit('update:colors', this.localColors);
    },
    addColor() {
      this.nameError = "";
      this.colorError = "";
      this.colorName = this.colorName.trim();
      this.color = this.color.trim();

      if (this.colorName === '') {
        this.nameError = "Dieses Feld darf nicht leer sein!";
      }

      if (this.color === '') {
        this.colorError = "Dieses Feld darf nicht leer sein!";
      }

      if (this.nameError.length || this.nameError.length) {
        return;
      }

      let colorAttribute = {
        id: 0,
        type: AttributeType.COLOR,
        name: this.colorName,
        color: this.color,
      } as ColorAttribute;

      for (let index in this.localColors) {
        let color = this.localColors[index];
        if (this.color === color.color) {
          this.error = 'Diese Farbe ist bereits hinzugefügt.';
          this.highlight = Number.parseInt(index);
          return;
        }
      }
      this.localColors.push(colorAttribute);

      this.colorName = "";
      this.color = "#ffffff";
      this.$emit('update:colors', this.localColors);
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
