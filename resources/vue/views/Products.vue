<template>
  <div class="w-screen h-screen bg-backgroundColor">
    <Navbar />
    <div class="flex flex-row">
      <Sidenav class="w-1/12" />
      <div
        class="flex flex-col items-center justify-center w-full h-screen  md:h-full md:w-11/12 md:mt-0"
      >
        <LatestProduct class="w-full md:w-1/2 h-96" />
        <ProductList class="invisible bg-backgroundColor md:visible" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Sidenav from "../components/Sidenav.vue";
import Navbar from "../components/Navbar.vue";
import userStore from "../stores/user";
import LatestProduct from "../components/LatestProduct.vue";
import user from "../stores/user";
import ProductList from "../components/ProductList.vue";
export default {
  components: {
    Sidenav,
    Navbar,
    LatestProduct,
    ProductList,
  },
  setup() {
    return { userStore };
  },
};
</script>
