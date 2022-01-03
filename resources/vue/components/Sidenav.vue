<template>
  <div
    class="fixed left-0 flex flex-col justify-center invisible w-56 pl-4 m-0 text-white  md:visible sidebar top-32 bg-backgroundColor"
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="flex flex-row my-6 ml-6"
    >
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <a class="my-1 text-left" :href="'#' + category.name">{{
        category.name
      }}</a>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  data() {
    return {
      categories: window.config.categories,
    };
  },
};
</script>

<style>
.sidebar {
  height: calc(100% - 8rem);
}
</style>
