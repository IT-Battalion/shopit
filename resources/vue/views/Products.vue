<template>
  <div class="w-screen h-screen bg-backgroundColor">
    <Navbar />
    <div class="flex flex-row">
      <Sidenav class="w-1/12" />
      <div
        class="flex flex-col items-center justify-center w-full h-screen -mt-48  md:h-full md:w-11/12 md:mt-0"
      >
        <LatestProduct class="w-full md:w-1/2 h-96" />
        <Button>Bitte !!</Button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Sidenav from "../components/Sidenav.vue";
import Navbar from "../components/Navbar.vue";
import userStore from "../stores/user";
import LatestProduct from "../components/LatestProduct.vue";
import user from "../stores/user";
export default {
  components: {
    Sidenav,
    Navbar,
    LatestProduct,
  },
  setup() {
    return { userStore };
  },
};
</script>
