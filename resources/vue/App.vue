<template>
  <router-view />
</template>

<script lang="ts">
import useUser from "./stores/user";
export default {
  setup() {
    const { user } = useUser();

    return {
      user,
    };
  },
};
</script>
