<template>
  <div>
    <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
      Produktbeschreibung
    </h2>
    <div>
      <v-md-editor v-model="localDescription" height="25rem"/>
      <p class="text-base text-red-400 mt-3">{{error}}</p>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {QuillEditor} from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default defineComponent({
  components: {
    QuillEditor,
  },
  props: {
    description: {
      type: String,
      required: true,
    },
  },
  emits: ['update:description'],
  data() {
    return {
      localDescription: this.description,
      error: '',
    };
  },
  methods: {
    async validate() {
      this.error = '';
      let localDescription = this.description.trim();
      this.$emit('update:description', localDescription);
      if (localDescription.length > 10) {
        return Promise.resolve();
      } else {
        this.error = 'Die Produktbeschreibung muss mindestens 10 Zeichen lang sein.';
        console.log(this.error);
        return Promise.reject();
      }
    },
  },
  watch: {
    description(val) {
      this.localDescription = val;
    },
    localDescription(val) {
      this.$emit('update:description', val);
    },
  },
});
</script>
