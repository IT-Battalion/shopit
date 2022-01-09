<template>
  <HighlightedProduct class="md:w-3/4 w-full h-96" />
  <ProductList />
</template>

<script lang="ts">
import HighlightedProduct from "../components/HighlightedProduct.vue";
import ProductList from "../components/ProductList.vue";
export default {
  components: {
    HighlightedProduct,
    ProductList,
  },
};
</script>
