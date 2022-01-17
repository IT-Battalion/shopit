<template>
  <div class="w-full">
    <div
      class="max-w-2xl px-4 pt-32 mx-auto sm:px-6 lg:max-w-7xl lg:px-8"
      v-for="(products, categoryName) in categories"
      :key="categoryName"
      :id="categoryName"
      v-show="!isLoading"
    >
      <div v-if="!isLoading || state.isProgressing">
        <h2 class="text-2xl font-extrabold tracking-tight text-white">
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
          <ProductCard :product="product" :isLoading="!isLoading || state.isProgressing" @imageLoaded="imageLoaded" />
        </div>
      </div>
    </div>
    <div v-if="isLoading">
      <Skeletor/>
    </div>
  </div>
</template>

<script lang="ts">
import ProductCard from "./ProductCard.vue";
import { AxiosResponse } from "axios";
import { Product } from "../types/api";
import { defineComponent } from "@vue/runtime-core";
import {complete, initLoad, initProgress, state} from "../loader";

export default defineComponent({
  data() {
    return {
      categories: {} as { [key: string]: Product[] },
      state: state,
    };
  },
  computed: {
    isLoading() {
      return (this as any).state.isLoading || (this as any).state.isProgressing;
    }
  },
  async created() {
    initLoad();
    let response: AxiosResponse<{ [key: string]: Product[] }> = await this.$http.get(
      "/product"
    );
    this.categories = response.data;

    let imageCount = 0;
    for (const key in this.categories) {
      imageCount += this.categories[key].length;
    }

    console.log(imageCount);

    initProgress(imageCount);
  },
  components: {
    ProductCard,
  },
  methods: {
    imageLoaded() {
      this.state.progressCurrent++;
    }
  }
});
</script>
