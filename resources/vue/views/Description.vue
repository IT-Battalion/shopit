<template>
  <div>
    <AddProductProcess/>
    <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
      Produktbeschreibung
    </h2>
    <div class="m-10 bg-white">
      <QuillEditor theme="snow" toolbar="minimal" ref="desc"/>
    </div>
    <div class="flex flex-row gap-x-2">
      <div class="flex justify-end mt-10 sm:mr-20">
        <CancelButton/>
        <BackwardButton @click="backward"/>
      </div>
      <ButtonField iconSrc="/img/doneBlack.svg" class="mt-auto mb-2" @click="createProduct"/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import {QuillEditor} from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import ButtonField from "../components/ButtonField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {
  CreateProductClothingAttributesLinkRequest,
  CreateProductClothingAttributesRequest,
  CreateProductImageRequest,
  CreateProductRequest,
  Product,
  ProductAttribute,
  ProductImage
} from "../types/api";
import {AxiosResponse} from "axios";
import {endLoad, initLoad} from "../loader";
import {isNull} from "lodash";

export default defineComponent({
  components: {
    AddProductProcess,
    QuillEditor,
    ButtonField,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  async mounted() {
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      (this.$refs.desc as typeof QuillEditor).setHTML(window.localStorage.getItem('product.description'));
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product attributes'});
    },
    async saveToLocalStorage() {
      let description = (this.$refs.desc as typeof QuillEditor).getHTML();
      window.localStorage.setItem('product.description', description);
    },
    async createProduct() {
      initLoad();
      let product = await this.$http.post<CreateProductRequest, AxiosResponse<Product>>(
        '',
        {}
      );
      await this.createProductImages(product.data.id);
      await this.createProductClothingAttributes(product.data.id);
      await this.clearLocalStorage();
      endLoad();
    },
    async clearLocalStorage() {
      window.localStorage.removeItem('product.title');
      window.localStorage.removeItem('product.price');
      window.localStorage.removeItem('product.description');
      window.localStorage.removeItem('product.images');
      window.localStorage.removeItem('product.category');
      window.localStorage.removeItem('product.clothing');
      window.localStorage.removeItem('product.dimension');
      window.localStorage.removeItem('product.color');
      window.localStorage.removeItem('product.volume');
      window.localStorage.removeItem('product.clothings');
      window.localStorage.removeItem('product.dimensions');
      window.localStorage.removeItem('product.colors');
      window.localStorage.removeItem('product.volumes');
    },
    async createProductImages(productID: number) {
      let images = window.localStorage.getItem('product.images');
      if (!isNull(images)) {
        for (const img in JSON.parse(images)) {
          let product_image = await this.$http.post<CreateProductImageRequest, AxiosResponse<ProductImage>>(
            '',
            {
              productID,
            }
          );
        }
      }
    },
    async createProductClothingAttributes(productID: number) {
      let attributes = window.localStorage.getItem('product.clothingAttributes')
      if (!isNull(attributes)) {
        for (const att in JSON.parse(attributes)) {
          let product_attribute = await this.$http.post<CreateProductClothingAttributesRequest, AxiosResponse<ProductAttribute>>(
            '',
            {
              productID,
              att,
            }
          );
          await this.linkProductClothingAttributes(productID, product_attribute.data.id);
        }
      }
    },
    async linkProductClothingAttributes(productID: number, productAttributeID: number) {
      let product_attribute_link = await this.$http.post<CreateProductClothingAttributesLinkRequest, AxiosResponse<any>>(
        '',
        {
          productID,
          productAttributeID,
        }
      );
    }
  },
});
</script>
