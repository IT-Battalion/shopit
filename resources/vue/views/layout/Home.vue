<template>
  <div class="flex flex-row">
    <Sidenav />
    <div
      class="flex flex-col items-center justify-center w-full h-screen  md:h-full md:w-11/12 mt-14"
    >
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import Sidenav from "@/components/Sidenav.vue";
import LatestProduct from "@/components/LatestProduct.vue";
export default {
  components: {
    Sidenav,
    LatestProduct,
  },
};
</script>