<template>
  <div class="relative">
    <div
      class="
        absolute
        w-3/4
        h-full
        ml-0
        md:w-5/12
        rounded-3xl
        md:left-24
        bg-gradient-to-r
        from-yellow-400
        via-red-500
        to-pink-500
      "
    ></div>
    <div
      class="
        absolute
        sm:w-2/3
        w-[calc(100%-1.25rem)]
        rounded-3xl
        overflow-hidden
        md:left-48
        left-5
        top-12
        h-3/4
        bg-gradient-to-r
        from-purple-200
        to-blue-400
      "
    >
      <swiper :navigation="true" class="w-full h-full" v-if="!isLoading">
        <swiper-slide
          class="text-center text-black"
          v-for="highlightedProduct in highlightedProducts"
          :key="highlightedProduct.name"
        >
          <div
            class="
              grid
              items-center
              w-full
              h-full
              grid-cols-2 grid-rows-4
              gap-x-6
              justify-items-center
            "
          >
            <div class="w-full h-full row-span-full">
              <LoadingImage
                :src="'/product-image/' + highlightedProduct.thumbnail.id"
                :alt="highlightedProduct.name"
                class="object-cover w-full h-full"
                height="100%"
              />
            </div>
            <h3 class="self-end w-5/6 text-xl font-semibold text-white">
              {{ highlightedProduct.name }}
            </h3>
            <p class="self-end w-2/3 text-sm font-medium text-white">
              {{ highlightedProduct.price }}
            </p>
            <router-link
              :to="{
                name: 'Product',
                params: { name: highlightedProduct?.name },
              }"
              class="self-end"
            >
              <ButtonField class="h-10">
                <template v-slot:icon><img src="img/info.svg" /></template>
              </ButtonField>
            </router-link>
          </div>
        </swiper-slide>
      </swiper>
      <swiper class="w-full h-full" v-else>
        <swiper-slide>
          <div
            class="
              grid
              items-center
              w-full
              h-full
              grid-cols-2 grid-rows-4
              justify-items-center
              gap-x-6
            "
          >
            <div class="w-full h-full row-span-full">
              <Skeletor :pill="false" :circle="false" as="div" height="100%" />
            </div>
            <h3 class="self-end w-1/4 text-sm text-white">
              <Skeletor :pill="true" />
            </h3>
            <p class="self-end w-1/4 text-sm font-medium text-gray-900">
              <Skeletor />
            </p>
            <p class="w-1/4 text-2xl font-medium text-gray-900">
              <Skeletor />
            </p>
          </div>
        </swiper-slide>
      </swiper>
    </div>
  </div>
</template>

<script lang="ts">
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import "swiper/css/navigation";
import { AxiosResponse } from "axios";
import { Product } from "../types/api";

// import Swiper core and required modules
import SwiperCore, { Navigation } from "swiper";
import { defineComponent } from "@vue/runtime-core";
import LoadingImage from "./LoadingImage.vue";

import ButtonField from "./ButtonField.vue";

// install Swiper modules
SwiperCore.use([Navigation]);

export default defineComponent({
  components: {
    Swiper,
    SwiperSlide,
    LoadingImage,
    ButtonField,
  },
  data() {
    return {
      isLoading: true,
      highlightedProducts: [] as any as Product[],
    };
  },
  async beforeMount() {
    let response: AxiosResponse<Product[]> = await this.$http.get(
      "/highlighted"
    );

    this.highlightedProducts = response.data;
    this.isLoading = false;
  },
  methods: {},
});
</script>
