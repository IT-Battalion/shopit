<template>
  <div class="grid justify-center h-full">
    <div
      class="flex flex-col justify-center w-full mx-auto my-auto overflow-auto text-white  justify-items-center bg-backgroundColor"
    >
      <h1 class="mb-10 text-4xl font-bold text-center text-white">
        Kategorien
      </h1>
      <div
        v-for="category in categories"
        v-bind:key="category.icon_url"
        v-bind:name="category.name"
        class="my-6 ml-6 rounded-full"
      >
        <div class="grid items-center grid-cols-4 grid-rows-1 my-1 text-left">
          <img :src="category.icon_url" class="object-scale-down h-8" />
          <p class="text-center">{{ category.name }}</p>
          <button class="mx-5">Bin</button>
          <button class="mx-5">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      categories: window.config.categories,
    };
  },
});
</script>