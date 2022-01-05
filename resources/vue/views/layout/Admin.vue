<template>
  <div class="flex flex-row">
    <SidenavAdmin />
    <div
      class="
        flex flex-col
        items-center
        justify-center
        w-full
        h-screen
        md:h-full md:w-11/12
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