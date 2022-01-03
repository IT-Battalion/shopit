<template>
  <div class="w-full">
    <div
      class="max-w-2xl px-4 py-16 mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8"
      v-for="(products, categoryName) in categories"
      :key="categoryName"
    >
      <div v-if="!isLoading">
        <h2
          :id="categoryName"
          class="text-2xl font-extrabold tracking-tight text-white"
        >
          {{ categoryName }}
        </h2>
      </div>
      <div v-else>
        <h2 class="w-1/4 text-2xl font-extrabold tracking-tight text-white">
          <Skeletor :pill="true" />
        </h2>
      </div>
      <div
        class="grid grid-cols-1 mt-6  gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
      >
        <div
          v-for="product in products"
          :key="product.name"
          class="relative group"
        >
          <ProductCard :product="product" :isLoading="isLoading" />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import ProductCard from "./ProductCard.vue";
import { AxiosResponse } from "axios";
import { Product } from "../types/api";
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  data() {
    return {
      categories: {} as { String: Product[] },
      isLoading: true,
    };
  },
  async created() {
    let response: AxiosResponse<{ String: Product[] }> = await window.axios.get(
      "/api/product"
    );
    this.categories = response.data;
    this.isLoading = false;
  },
  components: {
    ProductCard,
  },
});
</script>