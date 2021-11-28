<template>
  <swiper :navigation="true">
    <swiper-slide class="text-center text-black">Slide 1</swiper-slide>
    <swiper-slide class="text-center text-black">Slide 2</swiper-slide>
    <swiper-slide class="text-center text-black">Slide 3</swiper-slide>
    <swiper-slide class="text-center text-black">Slide 4</swiper-slide>
  </swiper>
</template>

<script lang="ts">
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import "swiper/css/navigation";

// import Swiper core and required modules
import SwiperCore, { Navigation } from "swiper";

// install Swiper modules
SwiperCore.use([Navigation]);

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>