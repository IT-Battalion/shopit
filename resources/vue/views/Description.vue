<template>
  <div>
    <AddProductProcess />
    <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
      Produktbeschreibung
    </h2>
    <div class="m-10 bg-white">
      <QuillEditor theme="snow" toolbar="minimal" />
    </div>
    <div class="flex flex-row gap-x-2">
      <ForwardBackwardButton
        :nextTrue="false"
        :last="{ name: 'Add Product attributes' }"
        :cancel="{ name: 'Admin' }"
      />
      <ButtonField iconSrc="/img/doneBlack.svg" class="mt-auto mb-2" @click=""/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import {QuillEditor} from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import ButtonField from "../components/ButtonField.vue";
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
    ForwardBackwardButton,
    QuillEditor,
    ButtonField,
  },
  methods: {
    async createProduct() {
      initLoad();
      let product = await this.$http.post<CreateProductRequest, AxiosResponse<Product>>(
        '',
        {}
      );
      await this.createProductImages(product.data.id);
      await this.createProductClothingAttributes(product.data.id);
      window.localStorage.removeItem('product.*');
      endLoad();
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
