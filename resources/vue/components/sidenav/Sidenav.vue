<template>
  <div
    :class="[
      'fixed overflow-y-auto overflow-x-hidden left-0 flex flex-col w-56 m-0 text-white sidebar top-32 bg-backgroundColor',
      center ? 'justify-center' : '',
    ]"
    ref="sidenav"
  >
    <slot></slot>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
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
