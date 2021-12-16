<template>
  <div class="relative">
    <div
      class="absolute w-5/12 h-full ml-0  rounded-3xl left-24 bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500"
    ></div>
    <div
      class="absolute w-2/3  rounded-r-3xl left-48 top-12 h-3/4 bg-gradient-to-r from-purple-200 to-blue-400"
    >
      <swiper :navigation="true" class="w-full h-full">
        <swiper-slide
          class="text-center text-black"
          v-for="highlightedProduct in highlightedProducts"
          :key="highlightedProduct.name"
        >
          <div
            class="grid items-center w-full h-full grid-cols-2 grid-rows-4  gap-x-6 justify-items-center"
            v-if="!isLoading"
          >
            <div class="w-full h-full row-span-full">
              <img
                :src="highlightedProduct.imgSrc"
                :alt="highlightedProduct.name"
              />
            </div>
            <h3 class="self-end w-5/6 text-sm text-white">
              {{ highlightedProduct.name }}
            </h3>
            <p class="self-end w-2/3 text-sm font-medium text-gray-900">
              {{ highlightedProduct.price }}
            </p>
            <p class="w-2/3 text-sm font-medium text-gray-900">
              {{ highlightedProduct.price }}
            </p>
            <button
              class="w-24 px-4 py-1 bg-white rounded-3xl hover:bg-gray-300"
              type="button"
            >
              <svg
                fill="#000"
                version="1.1"
                viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg"
                class="object-scale-down h-8 mx-auto"
              >
                <g>
                  <path
                    d="m48.359 42.656c-0.09375-0.89062-0.15625-1.7969-0.15625-2.7188s0.046875-1.8438 0.15625-2.75h-25.078l-2.125-8.0625c-0.3125-1.2031-1.4062-2.0312-2.6406-2.0312h-9.5312c-1.5156 0-2.7344 1.2188-2.7344 2.7344s1.2188 2.7344 2.7344 2.7344h7.4219l2.125 8.0625s0 0.015625 0.015625 0.015625l6.6406 25.609c0.3125 1.2031 1.4062 2.0312 2.6562 2.0312h0.32812c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h6.5c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h0.32812c1.25 0 2.3438-0.82812 2.6562-2.0312l0.28125-1.1094c-2.6562-0.375-5.1719-1.1875-7.4844-2.3281-7.7031-3.75-13.219-11.281-14.156-20.156zm-9.0156 28.812c0 1.7344-1.4062 3.1562-3.1562 3.1562-1.7344 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4219-3.1719 3.1562-3.1719 1.75 0 3.1562 1.4219 3.1562 3.1719zm22.516 0c0 1.7344-1.4219 3.1562-3.1562 3.1562-1.75 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4062-3.1719 3.1562-3.1719 1.7344 0 3.1562 1.4219 3.1562 3.1719z"
                  />
                  <path
                    d="m73.703 19.906c-11.047 0-20.031 9-20.031 20.047s8.9844 20.031 20.031 20.031c11.062 0 20.031-8.9844 20.031-20.031 0-11.062-8.9688-20.047-20.031-20.047zm5.9531 22.766h-3.2188v3.2188c0 1.5-1.2188 2.7344-2.7344 2.7344-1.5 0-2.7344-1.2344-2.7344-2.7344v-3.2188h-3.2031c-1.5156 0-2.7344-1.2344-2.7344-2.7344 0-1.5156 1.2188-2.7344 2.7344-2.7344h3.2031v-3.2188c0-1.5156 1.2344-2.7344 2.7344-2.7344 1.5156 0 2.7344 1.2188 2.7344 2.7344v3.2188h3.2188c1.5156 0 2.7344 1.2188 2.7344 2.7344-0.015625 1.5-1.2188 2.7344-2.7344 2.7344z"
                  />
                </g>
              </svg>
            </button>
          </div>

          <div
            v-else
            class="grid items-center w-full h-full grid-cols-2 grid-rows-4  gap-x-6"
          >
            <div class="w-full h-full row-span-full">
              <Skeletor
                :pill="false"
                as="div"
                class="vue-skeletor-image"
                height="100%"
              />
            </div>
            <h3 class="self-end w-5/6 text-sm text-white">
              <Skeletor :pill="true" />
            </h3>
            <p class="self-end w-2/3 text-sm font-medium text-gray-900">
              <Skeletor />
            </p>
            <p class="w-2/3 text-sm font-medium text-gray-900">
              <Skeletor />
            </p>
            <button
              class="w-24 px-4 py-1 bg-white rounded-3xl hover:bg-gray-300"
              type="button"
            >
              <svg
                fill="#000"
                version="1.1"
                viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg"
                class="object-scale-down h-8 mx-auto"
              >
                <g>
                  <path
                    d="m48.359 42.656c-0.09375-0.89062-0.15625-1.7969-0.15625-2.7188s0.046875-1.8438 0.15625-2.75h-25.078l-2.125-8.0625c-0.3125-1.2031-1.4062-2.0312-2.6406-2.0312h-9.5312c-1.5156 0-2.7344 1.2188-2.7344 2.7344s1.2188 2.7344 2.7344 2.7344h7.4219l2.125 8.0625s0 0.015625 0.015625 0.015625l6.6406 25.609c0.3125 1.2031 1.4062 2.0312 2.6562 2.0312h0.32812c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h6.5c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h0.32812c1.25 0 2.3438-0.82812 2.6562-2.0312l0.28125-1.1094c-2.6562-0.375-5.1719-1.1875-7.4844-2.3281-7.7031-3.75-13.219-11.281-14.156-20.156zm-9.0156 28.812c0 1.7344-1.4062 3.1562-3.1562 3.1562-1.7344 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4219-3.1719 3.1562-3.1719 1.75 0 3.1562 1.4219 3.1562 3.1719zm22.516 0c0 1.7344-1.4219 3.1562-3.1562 3.1562-1.75 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4062-3.1719 3.1562-3.1719 1.7344 0 3.1562 1.4219 3.1562 3.1719z"
                  />
                  <path
                    d="m73.703 19.906c-11.047 0-20.031 9-20.031 20.047s8.9844 20.031 20.031 20.031c11.062 0 20.031-8.9844 20.031-20.031 0-11.062-8.9688-20.047-20.031-20.047zm5.9531 22.766h-3.2188v3.2188c0 1.5-1.2188 2.7344-2.7344 2.7344-1.5 0-2.7344-1.2344-2.7344-2.7344v-3.2188h-3.2031c-1.5156 0-2.7344-1.2344-2.7344-2.7344 0-1.5156 1.2188-2.7344 2.7344-2.7344h3.2031v-3.2188c0-1.5156 1.2344-2.7344 2.7344-2.7344 1.5156 0 2.7344 1.2188 2.7344 2.7344v3.2188h3.2188c1.5156 0 2.7344 1.2188 2.7344 2.7344-0.015625 1.5-1.2188 2.7344-2.7344 2.7344z"
                  />
                </g>
              </svg>
            </button>
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
import { HighlightedProductData } from "../types/api";

// import Swiper core and required modules
import SwiperCore, { Navigation } from "swiper";
import { defineComponent } from "@vue/runtime-core";

// install Swiper modules
SwiperCore.use([Navigation]);

export default defineComponent({
  components: {
    Swiper,
    SwiperSlide,
  },
  data() {
    return {
      isLoading: true,
      highlightedProducts: [] as any as HighlightedProductData[],
    };
  },
  async created() {
    let response: AxiosResponse<HighlightedProductData[]> =
      await window.axios.get("/api/highlighted");

    this.highlightedProducts = response.data;
    this.isLoading = false;
  },
  methods: {},
});
</script>

<style>
.vue-skeletor-image {
  border-radius: 0;
}
</style>