<template>
  <LatestProduct class="w-full md:w-1/2 h-96" />
  <ProductList class="invisible bg-backgroundColor md:visible" />
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
