<template>
  <div class="progress-bar fixed h-1 top-0 left-0 right-0 z-[100] shadow-lg shadow-cyan-500/50 bg-cyan-100" :style="'top: ' + top + '; right: ' + right"></div>
</template>

<script lang="ts">
import {computed, defineComponent} from "vue";
import {state} from "../loader";

export default defineComponent({
  data() {
    return {
      top: computed(() => state.isLoading || state.isProgressing ? '0' : '-0.25rem'),
      right: computed(() => (1 - state.progressPercent) * 99 + '%'),
    }
  },
});
</script>

<style>
  .progress-bar {
    animation: pulse 1s linear 0s infinite alternate;
    transition: top linear 300ms, right linear 300ms;
  }

  @keyframes pulse {
    from {
      background-color: rgb(207 250 254);
    }
    to {
      background-color: #4d3fcd;
    }
  }
</style>
