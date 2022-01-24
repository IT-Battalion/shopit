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
      <ButtonField iconSrc="/img/doneBlack.svg" class="mt-auto mb-2" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import ButtonField from "../components/ButtonField.vue";

export default defineComponent({
  components: {
    AddProductProcess,
    ForwardBackwardButton,
    QuillEditor,
    ButtonField,
  },
});
</script>
