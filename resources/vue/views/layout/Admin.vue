<template>
  <div class="flex flex-row md:mx-24">
    <mq-responsive target="md+">
      <SidenavAdmin />
    </mq-responsive>
    <div class="w-full md:h-full mt-14">
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import SidenavAdmin from "@/components/sidenav/SidenavAdmin.vue";
import {defineComponent} from "vue";
export default defineComponent({
  name: "Admin Layout",
  components: {
    SidenavAdmin,
  },
});
</script>
