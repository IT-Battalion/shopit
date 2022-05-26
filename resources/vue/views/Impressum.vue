<template>
  <div>
    <h1 class="text-4xl font-bold text-white">Impressum</h1>
    <v-md-preview :text="text" height="100%" class="text-white"/>
  </div>
</template>

<script>
import {defineComponent} from "@vue/runtime-core";
import {getImpressum} from "../request";
import {endLoad, initLoad} from "../loader";

export default defineComponent({
  data() {
    return {
      text: "",
    }
  },
  beforeMount() {
    initLoad();
    getImpressum().then(value => this.text = value).finally(() => endLoad());
  }
});
</script>

<style scoped>

</style>
