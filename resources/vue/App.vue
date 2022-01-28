<template>
  <Loader />
  <router-view />
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import useUser from "./stores/user";
import Loader from "./components/Loader.vue";
import {loadCart} from "./stores/shoppingCart";

export default defineComponent({
  components: {
    Loader
  },
  setup() {
    const { user } = useUser();
    loadCart();

    return {
      user,
    };
  },
});
</script>
