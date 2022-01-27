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
    <ForwardBackwardButton
      :next="{ name: 'Add Product attributes' }"
      :last="{ name: 'Add Product' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import UploadImages from "vue-upload-drop-images";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import ButtonField from "../components/ButtonField.vue";

export default defineComponent({
  components: {
    UploadImages,
    AddProductProcess,
    ForwardBackwardButton,
    ButtonField,
  },
  methods: {
    saveToLocalStorage() {
      let images = (this.$refs.images as typeof UploadImages).Imgs;
      window.localStorage.setItem('product.images', JSON.stringify(images));
    }
  },
});
</script>
