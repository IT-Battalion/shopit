<template>
  <div class="w-full p-5 ml-5 rounded-2xl bg-elevatedDark">
    <Multiselect
      mode="tags"
      v-model="localClothingSizes"
      :close-on-select="false"
      :searchable="true"
      :create-option="true"
      :options="optionsClothing"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {AttributeType, ClothingSize, clothingSizeLabels} from "../../types/api-values";
import Multiselect from "@vueform/multiselect";
import {PropType} from "vue";
import {ClothingAttribute} from "../../types/api";

export default defineComponent({
  name: 'ClothingAttributeForm',
  components: {
    Multiselect,
  },
  props: {
    clothingSizes: {
      type: Array as PropType<ClothingAttribute[]>,
      required: true,
    }
  },
  enum: ['update:clothing-sizes'],
  data() {
    return {
      optionsClothing: clothingSizeLabels,
      localClothingSizes: [] as (typeof clothingSizeLabels[number])[],
    };
  },
  watch: {
    localClothingSizes(val: (typeof clothingSizeLabels[number])[]) {
      let tmp: ClothingAttribute[] = [];
      for (let clothingSize of val) {
        tmp.push({
          id: 0,
          type: AttributeType.CLOTHING,
          size: ClothingSize[clothingSize],
        } as ClothingAttribute);
      }
      this.$emit('update:clothingSizes', tmp);
    },
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
