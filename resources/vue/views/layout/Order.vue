<template>
  <OrderProcess />
  <router-view />
</template>

<script lang="ts">
import OrderProcess from "@/components/OrderProcess.vue";
export default {
  components: {
    OrderProcess,
  },
};
</script>