<template>
  <h1 class="text-4xl font-bold text-white">Impressum</h1>
  <div class="mt-3">
    <h2 class="text-2xl font-bold text-white">
      AGB
    </h2>
    <div>
      <v-md-editor height="40rem" @save="saveAGB" v-model="agb"/>
    </div>
    <h2 class="text-2xl font-bold text-white">
      Impressum
    </h2>
    <div>
      <v-md-editor v-model="impressum" height="40rem" @save="saveImpressum"/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {endLoad, initLoad} from "../loader";
import ButtonField from "../components/ButtonField.vue";
import {getAGB, getImpressum, setAGB, setImpressum} from "../request";

export default defineComponent({
  components: {ButtonField},
  data() {
    return {
      agb: "",
      impressum: "",
    }
  },
  beforeMount() {
    initLoad();
    getAGB().then(value => this.agb = value);
    getImpressum().then(value => this.impressum = value).finally(endLoad);
  },
  methods: {
    async saveImpressum(text: string) {
      initLoad();
      await setImpressum(text);
      endLoad();
    },
    async saveAGB(text: string) {
      initLoad();
      await setAGB(text);
      endLoad();
    },
  },
});
</script>
