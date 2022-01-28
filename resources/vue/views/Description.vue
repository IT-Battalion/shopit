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
  CreateProductColorAttributesLinkRequest,
  CreateProductColorAttributesRequest,
  CreateProductDimensionAttributesLinkRequest,
  CreateProductDimensionAttributesRequest,
  CreateProductImageRequest,
  CreateProductRequest,
  CreateProductVolumeAttributesLinkRequest,
  CreateProductVolumeAttributesRequest,
  Product,
  ProductAttribute,
  ProductCreateProcessStorage,
  ProductImage,
  UpdateProductThumbnailRequest
} from "../types/api";
import {AxiosResponse} from "axios";
import {endLoad, initLoad} from "../loader";
import {isUndefined} from "lodash";
import {useToast} from "vue-toastification";

export default defineComponent({
  components: {
    AddProductProcess,
    QuillEditor,
    ButtonField,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: Object as ProductCreateProcessStorage,
      toast: useToast(),
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
    async insertStoredData() {
      if (!isUndefined(this.productCreateStorage)) {
        (this.$refs.desc as typeof QuillEditor).setHTML(this.productCreateStorage.description ?? "");
      }
    },
    async saveToLocalStorage() {
      this.productCreateStorage.description = (this.$refs.desc as typeof QuillEditor).getHTML();
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product attributes'});
    },
    validateObject() {
      if (isUndefined(this.productCreateStorage.category)
        || isUndefined(this.productCreateStorage.price)
        || isUndefined(this.productCreateStorage.title)
        || isUndefined(this.productCreateStorage.description)
        || isUndefined(this.productCreateStorage.highlighted)
        || isUndefined(this.productCreateStorage.images)
        || isUndefined(this.productCreateStorage.attributes)
        || isUndefined(this.productCreateStorage.attributes.color)
        || isUndefined(this.productCreateStorage.attributes.clothing)
        || isUndefined(this.productCreateStorage.attributes.dimension)
        || isUndefined(this.productCreateStorage.attributes.volume)
        || isUndefined(this.productCreateStorage.attributes.color.enabled)
        || isUndefined(this.productCreateStorage.attributes.clothing.enabled)
        || isUndefined(this.productCreateStorage.attributes.dimension.enabled)
        || isUndefined(this.productCreateStorage.attributes.volume.enabled)) {
        this.toast.error("Fehler beim validieren der Rohdaten.")
        return false;
      }
      if (this.productCreateStorage.attributes.color.enabled) {
        if (isUndefined(this.productCreateStorage.attributes.color.value)
          || isUndefined(this.productCreateStorage.attributes.color.value.color)
          || isUndefined(this.productCreateStorage.attributes.color.value.color.colors)
          || this.productCreateStorage.attributes.color.value.color.colors.length < 1) {
          this.toast.error("Fehler beim validieren der Farb eingabe.")
          return false;
        }
      }
      if (this.productCreateStorage.attributes.clothing.enabled) {
        if (isUndefined(this.productCreateStorage.attributes.clothing.value)
          || isUndefined(this.productCreateStorage.attributes.clothing.value.size)
          || this.productCreateStorage.attributes.clothing.value.size.length < 1) {
          this.toast.error("Fehler beim validieren der Kleidergrößen eingabe.")
          return false;
        }
      }
      if (this.productCreateStorage.attributes.dimension.enabled) {
        if (isUndefined(this.productCreateStorage.attributes.dimension.value)
          || isUndefined(this.productCreateStorage.attributes.dimension.value.depth)
          || isUndefined(this.productCreateStorage.attributes.dimension.value.width)
          || isUndefined(this.productCreateStorage.attributes.dimension.value.height)) {
          this.toast.error("Fehler beim validieren der Dimensions eingabe.")
          return false;
        }
      }
      if (this.productCreateStorage.attributes.volume.enabled) {
        if (isUndefined(this.productCreateStorage.attributes.volume.value)
          || isUndefined(this.productCreateStorage.attributes.volume.value.volume)) {
          this.toast.error("Fehler beim validieren der Volumen eingabe.")
          return false;
        }
      }
      return true;
    },
    async createProduct() {
      initLoad();
      if (this.validateObject()) {
        let name = this.productCreateStorage.title;
        let price = this.productCreateStorage.price;
        let description = this.productCreateStorage.description;
        let category = this.productCreateStorage.category?.id;
        let product = await this.$http.post<CreateProductRequest, AxiosResponse<Product>>(
          '',
          {
            name,
            price,
            description,
            category,
          }
        );
        let product_id = product.data.id;
        let img = await this.createProductImages(product_id);
        product = await this.$http.put<UpdateProductThumbnailRequest, AxiosResponse<Product>>(
          '',
          {
            product_id,
            img
          }
        );
        await this.createProductClothingAttributes(product_id);
        await this.createProductColorAttributes(product_id);
        await this.createProductVolumeAttributes(product_id);
        await this.createProductDimensionAttributes(product_id);
        await this.clearLocalStorage();
        this.toast.success('Produkt wurde erfolgreich erstellt.');
        setTimeout(() => {
          window.open(this.$router.resolve({name: 'Product', params: {name: product.data.name}}).href, '_blank');
        }, 2000);
      }
      endLoad();
    },
    async clearLocalStorage() {
      window.localStorage.removeItem('product');
    },
    async createProductImages(productID: number) {
      let images = this.productCreateStorage.images;
      let productImages = [];
      for (const img in images) {
        let product_image = await this.$http.post<CreateProductImageRequest, AxiosResponse<ProductImage>>(
          '',
          {
            productID,
            img,
          }
        );
        productImages.push(product_image);
      }
      return productImages[0];
    },
    async createProductClothingAttributes(productID: number) {
      let attributes = this.productCreateStorage.attributes?.clothing?.value?.size;
      for (const att in attributes) {
        let product_attribute = await this.$http.post<CreateProductClothingAttributesRequest, AxiosResponse<ProductAttribute>>(
          '',
          {
            att,
          }
        );
        await this.linkProductClothingAttributes(productID, product_attribute.data.id);
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
    },
    async createProductVolumeAttributes(productID: number) {
      let att = this.productCreateStorage.attributes?.volume?.value?.volume;
      let product_attribute = await this.$http.post<CreateProductVolumeAttributesRequest, AxiosResponse<ProductAttribute>>(
        '',
        {
          att,
        }
      );
      await this.linkProductVolumeAttributes(productID, product_attribute.data.id);
    },
    async linkProductVolumeAttributes(productID: number, productAttributeID: number) {
      let product_attribute_link = await this.$http.post<CreateProductVolumeAttributesLinkRequest, AxiosResponse<any>>(
        '',
        {
          productID,
          productAttributeID,
        }
      );
    },
    async createProductColorAttributes(productID: number) {
      let attributes = this.productCreateStorage.attributes?.color?.value?.color?.colors ?? [];
      for (const att of attributes) {
        let name = att.name;
        let color = att.color;
        let product_attribute = await this.$http.post<CreateProductColorAttributesRequest, AxiosResponse<ProductAttribute>>(
          '',
          {
            name,
            color,
          }
        );
        await this.linkProductColorAttributes(productID, product_attribute.data.id);
      }
    },
    async linkProductColorAttributes(productID: number, productAttributeID: number) {
      let product_attribute_link = await this.$http.post<CreateProductColorAttributesLinkRequest, AxiosResponse<any>>(
        '',
        {
          productID,
          productAttributeID,
        }
      );
    },
    async createProductDimensionAttributes(productID: number) {
      let width = this.productCreateStorage.attributes?.dimension?.value?.width;
      let height = this.productCreateStorage.attributes?.dimension?.value?.height;
      let depth = this.productCreateStorage.attributes?.dimension?.value?.depth;
      let product_attribute = await this.$http.post<CreateProductDimensionAttributesRequest, AxiosResponse<ProductAttribute>>(
        '',
        {
          width,
          height,
          depth
        }
      );
      await this.linkProductDimensionAttributes(productID, product_attribute.data.id);
    },
    async linkProductDimensionAttributes(productID: number, productAttributeID: number) {
      let product_attribute_link = await this.$http.post<CreateProductDimensionAttributesLinkRequest, AxiosResponse<any>>(
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
