<template>
  <div
    :class="{
        'overflow-auto': true,
        'fixed': true,
        'left-0': true,
        'flex flex-col': true,
        'justify-center': center,
        'w-56': true,
        'pl-4': true,
        'm-0': true,
        'text-white': true,
        'sidebar': true,
        'top-32': true,
        'bg-backgroundColor': true,
      }
    "
    ref="sidenav"
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="my-6 ml-6 rounded-full"
    >
      <router-link class="flex flex-row items-center my-1 text-left" :to="'/#' + category.name">
        <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
        {{category.name}}
      </router-link>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  data() {
    return {
      categories: window.config.categories,
      center: true,
    };
  },
  mounted() {
    this.checkScroll();
    window.addEventListener('resize', () => {
      this.checkScroll();
    })
  },
  methods: {
    checkScroll() {
      const elem = this.$refs.sidenav as HTMLDivElement;
      this.center = elem.scrollHeight <= elem.clientHeight;
    }
  }
});
</script>

<style>
.sidebar {
  height: calc(100% - 8rem);
}
</style>
