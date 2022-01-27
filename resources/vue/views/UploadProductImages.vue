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

export default defineComponent({
  components: {
    BackwardButton,
    UploadImages,
    AddProductProcess,
    ButtonField,
    ForwardButton,
    CancelButton,
  },
  methods: {
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product'});
    },
    async forward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product attributes'});
    },
    async saveToLocalStorage() {
      let images = (this.$refs.images as typeof UploadImages).Imgs;
      window.localStorage.setItem('product.images', JSON.stringify(images));
    }
  },
});
</script>
