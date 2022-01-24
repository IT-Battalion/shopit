<template>
  <OrderProcess />
  <router-view />
</template>

<script lang="ts">
import OrderProcess from "@/components/OrderProcess.vue";
import {Order} from "../../types/api";
import OrderCreate from "../../components/OrderCreate.vue";
export default {
  components: {
    OrderCreate,
    OrderProcess,
  },
  data() {
    return {
      order: Object as Order,
    };
  },
};
</script>
