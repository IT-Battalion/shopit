<template>
  <div class="bg-backgroundColor">
    <mq-responsive target="md+">
      <Navbar />
    </mq-responsive>
    <div class="md:mt-32 md:ml-56 mt-16 mx-16">
      <main class="w-full">
        <router-view />
      </main>
    </div>
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
