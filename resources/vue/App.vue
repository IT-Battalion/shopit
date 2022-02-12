<template>
  <Loader/>
  <router-view/>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import Loader from "./components/Loader.vue";

export default defineComponent({
  components: {
    Loader
  },
});
</script>
