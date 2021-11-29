<template>
  <div class="relative">
    <div
      class="absolute w-5/12 h-full ml-0  rounded-3xl left-24 bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500"
    ></div>
    <div
      class="absolute w-7/12 ml-12  rounded-3xl left-24 top-12 h-3/4 bg-gradient-to-r from-purple-200 to-blue-400"
    ></div>
    <Swiper class="inset-y-1/2" />
  </div>
</template>

<script lang="ts">
import Swiper from "./Swiper.vue";
export default {
  components: {
    Swiper,
  },
};
</script>