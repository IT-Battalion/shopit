<template>
  <div>
    <AddProductProcess/>
    <div class="mx-5 mt-20 md:mx-20">
      <UploadImages ref="images"/>
      <!--      <ButtonField-->
      <!--        name="Hochladen"-->
      <!--        iconSrc="/img/uploadBlack.svg"-->
      <!--        class="my-10 mx-auto"-->
      <!--      />-->
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
import UploadImages from "vue-upload-drop-images";
import AddProductProcess from "../components/AddProductProcess.vue";
import ButtonField from "../components/ButtonField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {ProductCreateProcessStorage} from "../types/api";
import {isUndefined} from "lodash";

export default defineComponent({
  components: {
    BackwardButton,
    UploadImages,
    AddProductProcess,
    ButtonField,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: Object as ProductCreateProcessStorage,
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
      if (!isUndefined(this.productCreateStorage) && !isUndefined(this.productCreateStorage.images)) {
        if (this.productCreateStorage.images.length > 0) {
          (this.$refs.images as typeof UploadImages).Imgs = this.productCreateStorage.images;
        }
      }
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
      this.productCreateStorage.images = (this.$refs.images as typeof UploadImages).Imgs;
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));
    }
  },
});
</script>
