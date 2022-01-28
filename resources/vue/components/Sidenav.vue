<template>
  <div
    class="
      fixed
      overflow-auto
      left-0
      flex flex-col
      justify-center
      w-56
      m-0
      text-white
      sidebar
      top-32
      bg-backgroundColor
    "
    ref="sidenav"
  >
    <template v-for="category in categories" v-bind:key="category.name">
      <router-link
        class="
          flex flex-row
          items-center
          text-left
          py-3
          ml-3
          my-3
          pl-6
          hover:bg-sidenavSelected hover:text-gray-400
          rounded-xl
        "
        :to="'/#' + category.name"
        as="div"
      >
        <span
          class="object-scale-down h-8 w-8 mr-4 rounded"
          :style="'background-color:#' + category.color"
        ></span>
        {{ category.name }}
      </router-link>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      categories: window.config.categories,
      center: true,
    };
  },
  mounted() {
    this.checkScroll();
    window.addEventListener("resize", this.checkScroll);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.checkScroll);
  },
  methods: {
    checkScroll() {
      const elem = this.$refs.sidenav as HTMLDivElement;
      this.center = elem.scrollHeight <= elem.clientHeight;
    },
  },
});
</script>

<style>
.sidebar {
  height: calc(100% - 8rem);
}
</style>
