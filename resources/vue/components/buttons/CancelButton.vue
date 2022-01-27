<template>
  <button
    @click="clearLocalStorage"
    class="flex items-center px-6 py-4 mr-2 font-bold text-gray-400 rounded-full  hover:bg-elevatedColor hover:text-white"
  >
    Abbrechen
  </button>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";

export default defineComponent({
  methods: {
    clearLocalStorage() {
      window.localStorage.removeItem('product.title');
      window.localStorage.removeItem('product.price');
      window.localStorage.removeItem('product.description');
      window.localStorage.removeItem('product.images');
      window.localStorage.removeItem('product.category');
      window.localStorage.removeItem('product.clothing');
      window.localStorage.removeItem('product.dimension');
      window.localStorage.removeItem('product.color');
      window.localStorage.removeItem('product.volume');
      window.localStorage.removeItem('product.clothings');
      window.localStorage.removeItem('product.dimensions');
      window.localStorage.removeItem('product.colors');
      window.localStorage.removeItem('product.volumes');
      this.$router.push({name: 'Admin'});
    }
  }
});
</script>
