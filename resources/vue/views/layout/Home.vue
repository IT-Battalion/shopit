<template>
  <div class="flex flex-row">
    <mq-responsive target="md+">
      <Sidenav />
    </mq-responsive>
    <div class="flex flex-col items-center w-full">
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import Sidenav from "@/components/Sidenav.vue";
export default {
  components: {
    Sidenav,
  },
};
</script>