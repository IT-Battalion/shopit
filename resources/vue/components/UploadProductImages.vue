<template>
  <div>
    <AddProductProcess />
    <div class="mx-5 mt-20 md:mx-20">
      <UploadImages @change="handleImages" />
    </div>
    <CancelForwardButton
      next="/admin/produkte/hinzufuegen/preisUndTitel"
      cancel="/admin/"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import UploadImages from "vue-upload-drop-images";
import AddProductProcess from "./AddProductProcess.vue";
import CancelForwardButton from "./CancelForwardButton.vue";

export default defineComponent({
  components: {
    UploadImages,
    AddProductProcess,
    CancelForwardButton,
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