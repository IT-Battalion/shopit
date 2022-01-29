<template>
  <div>
    <AddProductProcess/>
    <div class="flex flex-col items-center w-full mt-10 gap-y-10">
      <CategoryAttribute/>
      <div class="flex flex-row items-center w-full overflow-x-auto py-7">
        <AttributeSwitchOnOff ref="dimensionSwitcher"/>
        <DimensionAttribute/>
      </div>
      <div class="flex flex-row items-center w-full">
        <AttributeSwitchOnOff ref="clothingSwitcher"/>
        <ClothingAttribute/>
      </div>
      <div class="flex flex-row items-center w-full">
        <AttributeSwitchOnOff ref="volumeSwitcher"/>
        <VolumeAttribute/>
      </div>
      <div class="flex flex-row items-center w-full">
        <AttributeSwitchOnOff ref="colorSwitcher"/>
        <ColorAttribute class="ml-5" ref="product_color"/>
      </div>
    </div>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton/>
      <BackwardButton @click="backward"/>
      <ForwardButton @click="forward"/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import AddProductProcess from "../components/product_create_process/AddProductProcessBar.vue";
import {ProductCreateProcessStorage} from "../types/api";
import CancelButton from "../components/buttons/CancelButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import DimensionAttribute from "../components/product_create_process/DimensionAttribute.vue";
import ColorAttribute from "../components/product_create_process/ColorAttribute.vue";
import VolumeAttribute from "../components/product_create_process/VolumeAttribute.vue";
import ClothingAttribute from "../components/product_create_process/ClothingAttribute.vue";
import AttributeSwitchOnOff from "../components/product_create_process/AttributeSwitchOnOff.vue";
import CategoryAttribute from "../components/product_create_process/CategoryAttribute.vue";
import {isUndefined} from "lodash";

export default defineComponent({
  components: {
    CategoryAttribute,
    AttributeSwitchOnOff,
    ClothingAttribute,
    VolumeAttribute,
    ColorAttribute,
    DimensionAttribute,
    AddProductProcess,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: {} as ProductCreateProcessStorage,
      dimensionBlocks: [] as { width: string, height: string, depth: string }[],
    };
  },
  async mounted() {
    let data = window.localStorage.getItem('product');
    if (!isUndefined(data) && data != null && data != 'undefined') {
      this.productCreateStorage = JSON.parse(data);
    }
    await this.insertStoredData();
  },
  methods: {
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product images'});
    },
    async forward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product description'});
    },
    async insertStoredData() {
      /*if (!isUndefined(this.productCreateStorage)) {
        let category = this.productCreateStorage.category;
        if (!isUndefined(category)) {
          this.selectedCategory = category;
        }
        if (!isUndefined(this.productCreateStorage.attributes)) {
          if (!isUndefined(this.productCreateStorage.attributes.dimension)) {
            (this.$refs.dimensionSwitcher as typeof AttributeSwitchOnOff).setEnabled(this.productCreateStorage.attributes.dimension.enabled ?? false);
            let dim = this.productCreateStorage.attributes.dimension.value;
            if (!isUndefined(dim)) {
              (this.$refs.product_dimension_width as typeof InputField).setValue(dim.width ?? "");
              (this.$refs.product_dimension_height as typeof InputField).setValue(dim.height ?? "");
              (this.$refs.product_dimension_depth as typeof InputField).setValue(dim.depth ?? "");
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.volume)) {
            (this.$refs.volumeSwitcher as typeof AttributeSwitchOnOff).setEnabled(this.productCreateStorage.attributes.volume.enabled ?? false);
            if (!isUndefined(this.productCreateStorage.attributes.volume.value)) {
              (this.$refs.product_volume as typeof InputField).setValue(this.productCreateStorage.attributes.volume.value.volume ?? "");
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.color)) {
            (this.$refs.colorSwitcher as typeof AttributeSwitchOnOff).setEnabled(this.productCreateStorage.attributes.color.enabled ?? false);
            if (!isUndefined(this.productCreateStorage.attributes.color.value)) {
              if (!isUndefined(this.productCreateStorage.attributes.color.value.color)) {
                (this.$refs.product_color as typeof ColorPicker).setSelectedName(this.productCreateStorage.attributes.color.value.color.selectedName ?? "");
                (this.$refs.product_color as typeof ColorPicker).selectedColor = this.productCreateStorage.attributes.color.value.color.selectedColor ?? "";
                (this.$refs.product_color as typeof ColorPicker).colors = this.productCreateStorage.attributes.color.value.color.colors;
              }
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.clothing)) {
            (this.$refs.clothingSwitcher as typeof AttributeSwitchOnOff).setEnabled(this.productCreateStorage.attributes.clothing.enabled ?? false);
            let val = this.productCreateStorage.attributes.clothing.value;
            if (!isUndefined(val)) {
              if (!isUndefined(val.size)) {
                this.value = val.size;
              }
            }
          }
        }
      }*/
    },
    async saveToLocalStorage() {
      /*
      this.productCreateStorage.category = this.selectedCategory; //id,name
      if (isUndefined(this.productCreateStorage.attributes)) this.productCreateStorage.attributes = {};
      if (isUndefined(this.productCreateStorage.attributes.clothing)) this.productCreateStorage.attributes.clothing = {};
      if (isUndefined(this.productCreateStorage.attributes.clothing.value)) this.productCreateStorage.attributes.clothing.value = {};
      if (isUndefined(this.productCreateStorage.attributes.color)) this.productCreateStorage.attributes.color = {};
      if (isUndefined(this.productCreateStorage.attributes.color.value)) this.productCreateStorage.attributes.color.value = {};
      if (isUndefined(this.productCreateStorage.attributes.color.value.color)) this.productCreateStorage.attributes.color.value.color = {};
      if (isUndefined(this.productCreateStorage.attributes.volume)) this.productCreateStorage.attributes.volume = {};
      if (isUndefined(this.productCreateStorage.attributes.volume.value)) this.productCreateStorage.attributes.volume.value = {};
      if (isUndefined(this.productCreateStorage.attributes.dimension)) this.productCreateStorage.attributes.dimension = {};
      if (isUndefined(this.productCreateStorage.attributes.dimension.value)) this.productCreateStorage.attributes.dimension.value = {};
      this.productCreateStorage.attributes.clothing.enabled = (this.$refs.clothingSwitcher as typeof AttributeSwitchOnOff).getEnabled() ?? false;
      this.productCreateStorage.attributes.clothing.value.size = this.value;
      this.productCreateStorage.attributes.volume.enabled = (this.$refs.volumeSwitcher as typeof AttributeSwitchOnOff).getEnabled() ?? false;
      this.productCreateStorage.attributes.volume.value.volume = (this.$refs.product_volume as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.color.enabled = (this.$refs.colorSwitcher as typeof AttributeSwitchOnOff).getEnabled() ?? false;
      this.productCreateStorage.attributes.color.value.color.colors = (this.$refs.product_color as typeof ColorPicker).colors;
      this.productCreateStorage.attributes.color.value.color.selectedColor = (this.$refs.product_color as typeof ColorPicker).selectedColor;
      this.productCreateStorage.attributes.color.value.color.selectedName = (this.$refs.product_color as typeof ColorPicker).getSelectedName();
      this.productCreateStorage.attributes.dimension.enabled = (this.$refs.dimensionSwitcher as typeof AttributeSwitchOnOff).getEnabled() ?? false;
      this.productCreateStorage.attributes.dimension.value.width = (this.$refs.product_dimension_width as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.dimension.value.height = (this.$refs.product_dimension_height as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.dimension.value.depth = (this.$refs.product_dimension_depth as typeof InputField).getValue() ?? "";
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));
      */
    },
  },
});
</script>
