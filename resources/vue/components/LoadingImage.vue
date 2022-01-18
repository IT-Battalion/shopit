<template>
  <img v-show="!isLoading" :src="src" :alt="alt" :class="[this.class]" @load="imageLoaded" @error="imageErrored" @abort="imageAborted" />
  <Skeletor v-if="isLoading" :pill="false" :circle="false" :height="skeletorHeight" :class="[this.class]"/>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  props: {
    class: {
      default: String,
    },
    src: String,
    alt: String,
    height: {
      type: String,
      default: '100%'
    },
  },
  data() {
    return {
      isLoading: true,
      skeletorHeight: this.height,
    }
  },
  emits: ['imageFinished', 'imageLoaded', 'imageErrored', 'imageAborted'],
  methods: {
    imageFinished() {
      this.$emit('imageFinished');
      (this as any).isLoading = false;
    },
    imageLoaded() {
      console.log('imageLoaded');
      this.imageFinished();
    },
    imageErrored() {
      console.log('imageLoaded');
      this.imageFinished();
    },
    imageAborted() {
      console.log('imageLoaded');
      this.imageFinished();
    }
  },
});
</script>
