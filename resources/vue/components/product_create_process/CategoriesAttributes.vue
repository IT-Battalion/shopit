<template>
  <div>
    <div class="flex flex-col mt-10 gap-y-10">
      <CategoryAttribute :category="category" @update:category="val=>$emit('update:category',val)" />
      <div
        class="flex flex-col p-7 bg-elevatedDark rounded-2xl"
      >
        <p class="w-full text-2xl font-bold text-center text-white">
          Dimensionen
        </p>
        <DimensionAttributeForm v-model:dimensions="attributes.dimensions" />
      </div>
      <div
        class="flex flex-col items-center justify-center  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <label class="w-full text-2xl font-bold text-center text-white" for="checkClothing">
            Kleidungsgrößen
          </label>
        </div>
        <ClothingAttributeForm v-model:clothing-sizes="attributes.clothing" class="w-full"/>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <label class="w-full text-2xl font-bold text-center text-white" for="checkVolume">
            Volumen
          </label>
        </div>
        <VolumeAttributeForm v-model:volumes="attributes.volumes" />
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <label class="w-full text-2xl font-bold text-center text-white" for="checkColor">
            Farbauswahl
          </label>
        </div>
        <ColorAttributeForm v-model:colors="attributes.colors" class="w-full"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import DimensionAttributeForm from "./DimensionAttributeForm.vue";
import ColorAttributeForm from "./ColorAttributeForm.vue";
import VolumeAttributeForm from "./VolumeAttributeForm.vue";
import ClothingAttributeForm from "./ClothingAttributeForm.vue";
import CategoryAttribute from "./CategoryAttribute.vue";
import {PropType} from "vue";
import {ClothingAttribute, ColorAttribute, DimensionAttribute, ProductCategory, VolumeAttribute} from "../../types/api";

export default defineComponent({
  components: {
    CategoryAttribute,
    ClothingAttributeForm,
    VolumeAttributeForm,
    ColorAttributeForm,
    DimensionAttributeForm,
  },
  props: {
    category: Object as PropType<ProductCategory>,
    attributes: Object as PropType<{
      dimensions: DimensionAttribute[],
      volumes: VolumeAttribute[],
      clothing: ClothingAttribute[],
      colors: ColorAttribute[],
    }>,
  },
  emit: ['update:category', 'update:attributes'],
  methods: {
    async validate() {
      return Promise.resolve();
    },
  },
});
</script>
