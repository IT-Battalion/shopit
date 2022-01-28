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
      window.localStorage.removeItem('product');
      this.$router.push({name: 'Admin'});
    }
  }
});
</script>
