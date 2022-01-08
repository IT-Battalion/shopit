<template>
  <div class="flex flex-row">
    <mq-responsive target="md+">
      <SidenavAdmin />
    </mq-responsive>
    <div
      class="
        flex flex-col
        items-center
        justify-center
        w-full
        h-screen
        md:h-full md:mt-14
      "
    >
      <OrderProcess />
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import SidenavAdmin from "@/components/SidenavAdmin.vue";
import OrderProcess from "@/components/OrderProcess.vue";
export default {
  components: {
    SidenavAdmin,
    OrderProcess,
  },
};
</script>