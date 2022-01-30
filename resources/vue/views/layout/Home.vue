<template>
  <div class="flex flex-row">
    <mq-responsive target="md+">
      <Sidenav />
    </mq-responsive>
    <div class="flex flex-col items-center w-full">
      <router-view v-slot="{ Component }">
        <keep-alive include="Products">
          <component :is="Component" />
        </keep-alive>
      </router-view>
    </div>
  </div>
</template>

<script lang="ts">
import Sidenav from "@/components/sidenav/SidenavCategories.vue";
import { defineComponent } from "vue";
export default defineComponent({
  name: "Home",
  components: {
    Sidenav,
  },
});
</script>
