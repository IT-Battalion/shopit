<template>
  <div>
    <AddProductProcess/>
    <div class="grid w-full grid-cols-1 grid-rows-2 my-16 place-items-center">
      <InputField labelName="Produktname"/>
      <InputField labelName="Preis" type="number"/>
      <div class="flex flex-row my-5">
        <input
          type="checkbox"
          name="highlighted"
          id="highlighted"
          class="my-5"
        />
        <label for="highlighted" class="my-auto ml-2 text-center text-white">
          Produkt hervorheben.
        </label>
      </div>
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Add Product images' }"
      :last="{ name: 'Admin' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
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
