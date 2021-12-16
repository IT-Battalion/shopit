<template>
  <router-view />
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import useUser from "./stores/user";
export default defineComponent({
  setup() {
    const { user } = useUser();

    return {
      user,
    };
  },
});
</script>
