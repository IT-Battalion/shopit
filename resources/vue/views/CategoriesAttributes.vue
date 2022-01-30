<template>
  <div>
    <AddProductProcessBar/>
    <div class="flex flex-col items-center justify-center mt-10 gap-y-10">
      <CategoryAttribute ref="category"/>
      <div
        class="flex flex-col items-center justify-center  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input type="checkbox" v-model="checkDimension"/>
          <h2 class="w-full text-2xl font-bold text-center text-white">
            Dimensionen
          </h2>
        </div>
        <DimensionAttribute v-if="checkDimension" class="w-full mx-5" ref="product_dimension"/>
      </div>
      <div
        class="flex flex-col items-center justify-center  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input type="checkbox" v-model="checkClothing"/>
          <h2 class="w-full text-2xl font-bold text-center text-white">
            Kleidungsgrößen
          </h2>
        </div>
        <ClothingAttribute v-if="checkClothing" class="w-full" ref="product_clothing"/>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input type="checkbox" v-model="checkVolume"/>
          <h2 class="w-full text-2xl font-bold text-center text-white">
            Volumen
          </h2>
        </div>
        <VolumeAttribute v-if="checkVolume" class="w-full" ref="product_volume"/>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input type="checkbox" v-model="checkColor"/>
          <h2 class="w-full text-2xl font-bold text-center text-white">
            Farbauswahl
          </h2>
        </div>
        <ColorAttribute v-if="checkColor" class="w-full" ref="product_color"/>
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
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";
import {TemporaryProductCreateStorage} from "../types/api";
import CancelButton from "../components/buttons/CancelButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import DimensionAttribute from "../components/product_create_process/DimensionAttribute.vue";
import ColorAttribute from "../components/product_create_process/ColorAttribute.vue";
import VolumeAttribute from "../components/product_create_process/VolumeAttribute.vue";
import ClothingAttribute from "../components/product_create_process/ClothingAttribute.vue";
import CategoryAttribute from "../components/product_create_process/CategoryAttribute.vue";
import {ProductProcessCreateProcessStorage} from "../types/api-values";

export default defineComponent({
  components: {
    CategoryAttribute,
    ClothingAttribute,
    VolumeAttribute,
    ColorAttribute,
    DimensionAttribute,
    AddProductProcessBar,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: {} as TemporaryProductCreateStorage as ProductProcessCreateProcessStorage,
      checkDimension: false,
      checkClothing: false,
      checkVolume: false,
      checkColor: false,
      selectedCategory: CategoryAttribute,
      colorAttribute: ColorAttribute,
      dimensionAttribute: DimensionAttribute,
      clothingAttribute: ClothingAttribute,
      volumeAttribute: VolumeAttribute,
    };
  },
  async mounted() {
    this.productCreateStorage = ProductProcessCreateProcessStorage.load();
    this.selectedCategory = this.$refs.category as typeof CategoryAttribute;
    this.volumeAttribute = this.$refs.product_volume as typeof VolumeAttribute;
    this.dimensionAttribute = this.$refs.product_dimension as typeof DimensionAttribute;
    this.clothingAttribute = this.$refs.product_clothing as typeof ClothingAttribute;
    this.colorAttribute = this.$refs.product_color as typeof ColorAttribute;
    await this.insertStoredData();
  },
  methods: {
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: "Add Product images"});
    },
    async forward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: "Add Product description"});
    },
    async insertStoredData() {
      this.selectedCategory.setSelected(this.productCreateStorage.category);

      this.checkDimension = this.productCreateStorage.isDimensionAttributeEnabled();
      this.checkClothing = this.productCreateStorage.isClothingAttributeEnabled();
      this.checkColor = this.productCreateStorage.isColorAttributeEnabled();
      this.checkVolume = this.productCreateStorage.isVolumeAttributeEnabled();

      this.dimensionAttribute.setDimensions(this.productCreateStorage.getDimensionAttributeValue());
      this.colorAttribute.setColors(this.productCreateStorage.getColorAttributeValue());
      this.clothingAttribute.setClothing(this.productCreateStorage.getClothingAttributeValue());
      this.volumeAttribute.setVolumes(this.productCreateStorage.getVolumeAttributeValue());
    },
    async saveToLocalStorage() {
      this.productCreateStorage.category = this.selectedCategory.getSelected();

      this.productCreateStorage.setClothingAttributeEnabled(this.checkClothing);
      this.productCreateStorage.setDimensionAttributeEnabled(this.checkDimension);
      this.productCreateStorage.setColorAttributeEnabled(this.checkColor);
      this.productCreateStorage.setVolumeAttributeEnabled(this.checkVolume);

      this.productCreateStorage.setDimensionAttributeValue(this.dimensionAttribute.getDimnesions());
      this.productCreateStorage.setVolumeAttributeValue(this.volumeAttribute.getVolumes());
      this.productCreateStorage.setClothingAttributeValue(this.clothingAttribute.getClothing());
      this.productCreateStorage.setColorAttributeValue(this.colorAttribute.getColors());

      ProductProcessCreateProcessStorage.save(this.productCreateStorage);
    },
  },
});
</script>
