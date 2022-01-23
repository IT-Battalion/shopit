<template>
  <div>
    <AddProductProcess />
    <div class="w-full grid grid-rows-2 grid-cols-1 place-items-center my-16">
      <InputField labelName="Produktname" />
      <InputField labelName="Preis" type="number" />
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Add Product images' }"
      :last="{ name: 'Admin' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import InputField from "../components/InputField.vue";

export default defineComponent({
  components: {
    AddProductProcess,
    ForwardBackwardButton,
    InputField,
  },
});
</script>
