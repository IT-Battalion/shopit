<template>
  <div>
    <ProductProcessBar/>
    <div class="flex flex-col items-center justify-center mt-10 gap-y-10">
      <CategoryAttribute ref="category"/>
      <div
        class="flex flex-col items-center justify-center  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input id="checkDimensionen" v-model="checkDimension" type="checkbox"/>
          <label class="w-full text-2xl font-bold text-center text-white" for="checkDimensionen">
            Dimensionen
          </label>
        </div>
        <DimensionAttribute v-if="checkDimension" ref="product_dimension" class="w-full mx-5"/>
      </div>
      <div
        class="flex flex-col items-center justify-center  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input id="checkClothing" v-model="checkClothing" type="checkbox"/>
          <label class="w-full text-2xl font-bold text-center text-white" for="checkClothing">
            Kleidungsgrößen
          </label>
        </div>
        <ClothingAttribute v-if="checkClothing" ref="product_clothing" class="w-full"/>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input id="checkVolume" v-model="checkVolume" type="checkbox"/>
          <label class="w-full text-2xl font-bold text-center text-white" for="checkVolume">
            Volumen
          </label>
        </div>
        <VolumeAttribute v-if="checkVolume" ref="product_volume" class="w-full"/>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-4  p-7 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center gap-4">
          <input id="checkColor" v-model="checkColor" type="checkbox"/>
          <label class="w-full text-2xl font-bold text-center text-white" for="checkColor">
            Farbauswahl
          </label>
        </div>
        <ColorAttribute v-if="checkColor" ref="product_color" class="w-full"/>
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
import ProductProcessBar from "../components/product_create_process/ProductProcessBar.vue";
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
    ProductProcessBar,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: {} as ProductProcessCreateProcessStorage as TemporaryProductCreateStorage,
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
      this.selectedCategory.setSelected(this.productCreateStorage.category ?? this.selectedCategory.getSelected());

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
