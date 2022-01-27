<template>
  <div>
    <AddProductProcess />
    <div class="mx-5 mt-20 md:mx-20">
      <UploadImages @change="handleImages" />
      <ButtonField
        name="Hochladen"
        iconSrc="/img/uploadBlack.svg"
        class="my-10 mx-auto"
      />
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Add Product attributes' }"
      :last="{ name: 'Add Product' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
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
    handleImages(files: any) {
      console.log(files);
      /*
                  [
                    {
                        "name": "Screenshot from 2021-02-23 12-36-33.png",
                        "size": 319775,
                        "type": "image/png",
                        "lastModified": 1614080193596
                        ...
                    },
                    ...
                    ]
                 */
    },
  },
});
</script>
