<template>
  <div class="w-full">
    <div
      class="max-w-2xl px-4 pt-32 mx-auto sm:px-6 lg:max-w-7xl lg:px-8"
      v-for="(products, categoryName) in categories"
      :key="categoryName"
      :id="categoryName"
      v-if="!state.isLoading || state.isProgressing"
    >
      <h2 class="text-2xl font-extrabold tracking-tight text-white">
        {{ categoryName }}
      </h2>
      <div
        class="grid grid-cols-1 mt-6  gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
      >
        <div
          v-for="product in products"
          :key="product.name"
          class="relative group"
        >
          <EditProductsCards
            :product="product"
            :isLoading="state.isProgressing"
            @imageLoaded="imageLoaded"
          />
        </div>
      </div>
    </div>
    <template v-if="state.isLoading">
      <div
        class="max-w-2xl px-4 pt-32 mx-auto sm:px-6 lg:max-w-7xl lg:px-8"
        v-for="index in 3"
        :key="index"
      >
        <h2
          class="w-1/4 mb-12 text-2xl font-extrabold tracking-tight text-white"
        >
          <Skeletor :pill="true" />
        </h2>
        <div
          class="grid grid-cols-1 mt-6  gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
        >
          <div v-for="index in 6" :key="index" class="relative group">
            <EditProductsCards :is-skeletor="true" :isLoading="true" />
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import EditProductsCards from "./EditProductsCard.vue";
import { AxiosResponse } from "axios";
import { Product } from "../types/api";
import { defineComponent } from "@vue/runtime-core";
import { endLoad, initLoad, initProgress, state } from "../loader";

export default defineComponent({
  data() {
    return {
      categories: {} as { [key: string]: Product[] },
      state: state,
    };
  },
  async created() {
    initLoad();
    let response: AxiosResponse<{ [key: string]: Product[] }> =
      await this.$http.get("/product");
    this.categories = response.data;

    let imageCount = 0;
    for (const key in this.categories) {
      imageCount += this.categories[key].length;
    }

    initProgress(imageCount);
    endLoad();
  },
  components: {
    EditProductsCards,
  },
  methods: {
    imageLoaded() {
      this.state.progressCurrent++;
    },
  },
});
</script>
