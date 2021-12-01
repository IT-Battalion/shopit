<template>
  <div class="w-full">
    <div
      class="max-w-2xl px-4 py-16 mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8"
    >
      <h2 class="text-2xl font-extrabold tracking-tight text-white">
        Kategoriename
      </h2>

      <div
        class="grid grid-cols-1 mt-6  gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
      >
        <div
          v-for="product in products"
          :key="product.id"
          class="relative group"
        >
          <ProductCard :product="product" />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import ProductCard from "./ProductCard.vue";
import { AxiosResponse } from "axios";
import { Product } from "../types/api";

export default {
  data() {
    return {
      products: [],
      isLoading: true,
    };
  },
  async created() {
    let response: AxiosResponse<[Product]> = await window.axios.get(
      "/api/product"
    );

    console.log(response);
  },
  components: {
    ProductCard,
  },
};
</script>