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
        md:h-full
        mt-14
      "
    >
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import SidenavAdmin from "@/components/SidenavAdmin.vue";
export default {
  components: {
    SidenavAdmin,
  },
};
</script>
