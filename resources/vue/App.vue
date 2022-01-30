<template>
  <Loader />
  <router-view />
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import useUser from "./stores/user";
import Loader from "./components/Loader.vue";

export default defineComponent({
  components: {
    Loader
  },
  setup() {
    const { user } = useUser();

    return {
      user,
    };
  },
});
</script>
