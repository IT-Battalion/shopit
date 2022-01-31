<template>
  <div>
    <AddProductProcessBar/>
    <div class="mx-5 mt-20 md:mx-20">
      <pond
        name="uploadImages"
        ref="images"
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
import {TemporaryProductCreateStorage} from "../types/api";
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";

import vueFilePond, {VueFilePondComponent} from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import {ProductProcessCreateProcessStorage} from "../types/api-values";
import {FilePond} from "filepond";

const Pond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview) as VueFilePondComponent;

export default defineComponent({
  data() {
    return {
      productCreateStorage: {} as ProductProcessCreateProcessStorage as TemporaryProductCreateStorage,
      myFiles: [] as string[],
      server: {
        url: "/api/admin/productImage",
        headers: {
          'X-CSRF-TOKEN': window.document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      },
      filePondRef: {} as FilePond, //import {FilePond} from './filepond'
    };
  },
  components: {
    BackwardButton,
    AddProductProcessBar,
    ForwardButton,
    CancelButton,
    Pond,
  },
  async mounted() {
    this.productCreateStorage = ProductProcessCreateProcessStorage.load();
    this.filePondRef = this.$refs.images as FilePond;
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      this.myFiles = this.productCreateStorage.images;
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
      this.productCreateStorage.images = this.myFiles;
      ProductProcessCreateProcessStorage.save(this.productCreateStorage);
    },
  },
});
</script>

<style src="filepond/dist/filepond.min.css"/>
<style src="filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"/>
