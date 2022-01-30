<template>
  <Sidenav>
    <template v-for="category in categories" v-bind:key="category.name">
      <router-link
        class="flex flex-row items-center py-3 pl-6 my-3 ml-3 text-left  hover:text-sidenavSelected rounded-xl"
        :to="'/#' + category.name"
      >
        <span
          class="object-scale-down w-8 h-8 mr-4 rounded"
          :style="'background-color:#' + category.color"
        ></span>
        {{ category.name }}
      </router-link>
    </template>
  </Sidenav>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Sidenav from "./Sidenav.vue";

export default defineComponent({
  components: {
    Sidenav,
  },
  data() {
    return {
      categories: window.config.categories,
    };
  },
});
</script>
