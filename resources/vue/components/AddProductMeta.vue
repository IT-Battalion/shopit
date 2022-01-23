<template>
  <div>
    <AddProductProcess />
    <div class="mx-5 mt-20 md:mx-20"></div>
    <CancelForwardButton
      next="categoriesAttributes"
      last="Admin"
      cancel="Admin"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import CancelForwardButton from "../components/CancelForwardButton.vue";

export default defineComponent({
  components: {
    AddProductProcess,
    CancelForwardButton,
  },
});
</script>
