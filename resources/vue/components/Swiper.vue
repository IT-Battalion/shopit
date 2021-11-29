<template>
  <swiper :navigation="true" v-if="loading">
    <swiper-slide class="text-center text-black">Slide 1</swiper-slide>
    <swiper-slide class="text-center text-black">Slide 2</swiper-slide>
  </swiper>
  <Skeletor v-else />
</template>

<script lang="ts">
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import "swiper/css/navigation";
import { Skeletor } from "vue-skeletor";
import { AxiosResponse } from "axios";
import { HighlightedProductData } from "../types/api";

// import Swiper core and required modules
import SwiperCore, { Navigation } from "swiper";

// install Swiper modules
SwiperCore.use([Navigation]);

export default {
  components: {
    Swiper,
    SwiperSlide,
    Skeletor,
  },
  data() {
    return {
      loading: true,
      highlightedProduct: [],
    };
  },
  async created() {
    let response: AxiosResponse<HighlightedProductData> =
      await window.axios.get("/api/highlighted");

    console.log(response);
  },
  methods: {},
};
</script>