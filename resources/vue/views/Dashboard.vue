<template>
  <div>
    <h2 class="text-2xl font-bold text-white">
      AGB
    </h2>
    <div>
      <QuillEditor ref="agb" theme="snow" toolbar="essential"/>
    </div>
    <ButtonField class="px-6 py-4 mx-2" @click="save('agb')">
      <template v-slot:text>Save</template>
      <template v-slot:icon><img src="/img/doneBlack.svg"/></template>
    </ButtonField>
    <h2 class="text-2xl font-bold text-white">
      Impressum
    </h2>
    <div>
      <QuillEditor ref="impressum" theme="snow" toolbar="essential"/>
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
      agbText: QuillEditor,
      impressumText: QuillEditor,
    }
  },
  async mounted() {
    this.agbText = this.$refs.agb as typeof QuillEditor;
    this.impressumText = this.$refs.impressum as typeof QuillEditor;
  },
  methods: {
    async save(value: string) {
      initLoad();
      endLoad();
    },
  },
});
</script>
