<template>
  <mq-responsive target="md+">
    <Navbar />
  </mq-responsive>
  <div class="md:mt-32 md:ml-56 mt-10 mx-10">
    <main class="w-full">
      <router-view />
    </main>
  </div>
  <mq-responsive target="sm-">
    <MobileNavbar />
  </mq-responsive>
</template>

<script lang="ts">
import Navbar from "@/components/Navbar.vue";
import MobileNavbar from "@/components/MobileNavbar.vue";
export default {
  components: {
    Navbar,
    MobileNavbar,
  },
};
</script>

<style>
main {
  width: calc(100% - 14rem);
}
</style>
