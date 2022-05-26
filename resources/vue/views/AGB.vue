<template>
  <h1 class="text-4xl font-bold text-white"> AGB </h1>
  <v-md-preview :text="text" class="text-white"/>
</template>

<script>
import {defineComponent} from "@vue/runtime-core";
import {getAGB} from "../request";
import {endLoad, initLoad} from "../loader";

export default defineComponent({
  data() {
    return {
      text: "",
    }
  },
  beforeMount() {
    initLoad();
    getAGB().then(value => this.text = value).finally(() => endLoad());
  }
});
</script>

<style scoped>

</style>
