<template>
  <div>
    <AddProductProcess />
    <div class="w-full my-28">
      <QuillEditor theme="snow" toolbar="minimal" class="bg-white" />
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Admin' }"
      :last="{ name: 'Add Product attributes' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default defineComponent({
  components: {
    AddProductProcess,
    ForwardBackwardButton,
    QuillEditor,
  },
});
</script>
