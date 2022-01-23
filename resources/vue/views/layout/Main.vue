<template>
  <mq-responsive target="md+">
    <Navbar />
  </mq-responsive>
  <div class="md:mt-32 md:ml-56 mt-10 mx-10 min-h-screen">
    <main class="w-full">
      <router-view />
    </main>
    <Footer />
  </div>
  <mq-responsive target="sm-">
    <MobileNavbar />
  </mq-responsive>
</template>

<script lang="ts">
import Navbar from "@/components/Navbar.vue";
import MobileNavbar from "@/components/MobileNavbar.vue";
import Footer from "@/components/Footer.vue";
export default {
  components: {
    Navbar,
    MobileNavbar,
    Footer,
  },
};
</script>

<style>
main {
  width: calc(100% - 14rem);
}
</style>
