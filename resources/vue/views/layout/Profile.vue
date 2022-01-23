<template>
  <div class="flex flex-row">
    <mq-responsive target="md+">
      <SidenavProfile />
    </mq-responsive>
    <div class="w-full md:h-full mt-14">
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import SidenavAdmin from "@/components/SidenavAdmin.vue";
import {defineComponent} from "vue";
import SidenavProfile from "../../components/SidenavProfile.vue";
export default defineComponent({
  name: "Profile Layout",
  components: {
    SidenavProfile,
    SidenavAdmin,
  },
});
</script>
