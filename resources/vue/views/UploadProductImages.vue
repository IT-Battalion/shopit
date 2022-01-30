<template>
  <div>
    <AddProductProcessBar/>
    <div class="mx-5 mt-20 md:mx-20">
      <file-pond
        name="uploadImages"
        ref="pond"
        allow-multiple="true"
        label-idle="Hier klicken um Bilder hochzuladen!"
        accepted-file-types="image/jpeg, image/png"
        v-bind:files="myFiles"
        :server="server"
      />
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
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {ProductCreateProcessStorage} from "../types/api";
import {isUndefined} from "lodash";
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";

import vueFilePond, {VueFilePondComponent} from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview) as VueFilePondComponent;

export default defineComponent({
  data() {
    return {
      productCreateStorage: {} as ProductCreateProcessStorage,
      myFiles: [],
      server: {
        url: "/api/admin/productImage",
        headers: {
          'X-CSRF-TOKEN': window.document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      }
    };
  },
  components: {
    BackwardButton,
    AddProductProcessBar,
    ForwardButton,
    CancelButton,
    FilePond,
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
      /*if (!isUndefined(this.productCreateStorage) && !isUndefined(this.productCreateStorage.images)) {
        if (this.productCreateStorage.images.length > 0) {
          (this.$refs.images as typeof UploadImages).Imgs = this.productCreateStorage.images;
        }
      }*/
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product'});
    },
    async forward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product attributes'});
    },
    async saveToLocalStorage() {
      /*this.productCreateStorage.images = (this.$refs.images as typeof UploadImages).Imgs;
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));*/
    },
  },
});
</script>

<style src="filepond/dist/filepond.min.css"/>
<style src="filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"/>
