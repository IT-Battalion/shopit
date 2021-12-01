<template>
  <HighlightedProduct class="w-full md:w-2/3 h-96" />
  <ProductList class="invisible bg-backgroundColor md:visible" />
</template>

<script lang="ts">
import Sidenav from "../components/Sidenav.vue";
import Navbar from "../components/Navbar.vue";
import userStore from "../stores/user";
import HighlightedProduct from "../components/HighlightedProduct.vue";
import user from "../stores/user";
import ProductList from "../components/ProductList.vue";
export default {
  components: {
    Sidenav,
    Navbar,
    HighlightedProduct,
    ProductList,
  },
  setup() {
    return { userStore };
  },
};
</script>
