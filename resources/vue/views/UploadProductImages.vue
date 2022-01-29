<template>
  <div>
    <AddProductProcessBar/>
    <div class="mx-5 mt-20 md:mx-20">
      <file-pond
        name="test"
        ref="pond"
        label-idle="Drop files here..."
        v-bind:allow-multiple="true"
        accepted-file-types="image/jpeg, image/png"
        server="/api"
        v-bind:files="myFiles"
        v-on:init="handleFilePondInit"
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
import ButtonField from "../components/ButtonField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {ProductCreateProcessStorage} from "../types/api";
import {isUndefined} from "lodash";

// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately
// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import {FilePond} from "filepond";
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";

export default defineComponent({
  components: {
    BackwardButton,
    FilePond,
    AddProductProcessBar,
    ButtonField,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: {} as ProductCreateProcessStorage,
      myFiles: ["cat.jpeg"],
    };
  },
  setup() {
    // Create component
    const FilePond = vueFilePond(
      FilePondPluginFileValidateType,
      FilePondPluginImagePreview
    );

    return {
      FilePond
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
    handleFilePondInit: function () {
      console.log("FilePond has initialized");

      // FilePond instance methods are available on `this.$refs.pond`
    },
  },
});
</script>
