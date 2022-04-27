<template>
  <div>
    <h2 class="text-2xl font-bold text-white">
      AGB
    </h2>
    <div>
      <v-md-editor :text="agb" height="50%" @save="saveAGB"/>
    </div>
    <ButtonField class="px-6 py-4 mx-2" @click="save('agb')">
      <template v-slot:text>Save</template>
      <template v-slot:icon><img src="/img/doneBlack.svg"/></template>
    </ButtonField>
    <h2 class="text-2xl font-bold text-white">
      Impressum
    </h2>
    <div>
      <v-md-editor :text="impressum" height="50%" @save="saveImpressum"/>
    </div>
    <ButtonField class="px-6 py-4 mx-2" @click="save('impressum')">
      <template v-slot:text>Save</template>
      <template v-slot:icon><img src="/img/doneBlack.svg"/></template>
    </ButtonField>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {QuillEditor} from "@vueup/vue-quill";
import {endLoad, initLoad} from "../loader";

export default defineComponent({
  components: {QuillEditor},
  data() {
    return {
      agb: "",
      impressum: ""
    }
  },
  async mounted() {
    //TODO: load agb & impressum text if exists
  },
  methods: {
    async saveImpressum(text: string) {
      initLoad();
      //TODO: logic
      endLoad();
    },
    async saveAGB(text: string) {
      initLoad();
      //TODO: logic
      endLoad();
    },
  },
});
</script>
