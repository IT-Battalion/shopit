<template>
  <div class="bg-backgroundColor">
    <Navbar />
    <main class="mt-32 ml-56">
      <router-view />
    </main>
  </div>
</template>

<script lang="ts">
import Navbar from "@/components/Navbar.vue";
export default {
  components: {
    Navbar,
  },
};
</script>

<style>
main {
  width: calc(100% - 14rem);
}
</style>
