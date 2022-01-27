<template>
  <div>
    <AddProductProcess/>
    <div class="grid w-full grid-cols-1 grid-rows-2 my-16 place-items-center">
      <InputField labelName="Produktname" ref="product_name"/>
      <InputField labelName="Preis" type="number" ref="product_price"/>
      <div class="flex flex-row my-5">
        <input
          type="checkbox"
          name="highlighted"
          id="highlighted"
          class="my-5"
          ref="highlighted"
        />
        <label for="highlighted" class="my-auto ml-2 text-center text-white">
          Produkt hervorheben.
        </label>
      </div>
    </div>
    <ForwardBackwardButton
      @click="saveToLocalStorage"
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
  methods: {
    saveToLocalStorage() {
      window.localStorage.setItem('product.title', (this.$refs.product_name as typeof InputField).getValue());
      window.localStorage.setItem('product.price', (this.$refs.product_price as typeof InputField).getValue());
      window.localStorage.setItem('product.highlighted', (this.$refs.highlighted as HTMLInputElement).value);
    }
  }
});
</script>
