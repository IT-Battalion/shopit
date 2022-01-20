<template>
  <div :class="[this.class]">
    <div v-if="attributes['0']">

    </div>
    <div v-if="attributes['1']">

    </div>
    <div v-if="attributes['2']">

    </div>
    <div v-if="attributes['3']">

    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import {SelectedAttributes} from "../types/api";

export default defineComponent({
  props: {
    selectedAttributes: {
      type: Object as PropType<SelectedAttributes>,
      required: true,
    },
    class: {
      type: String,
    }
  },
  data() {
    return {
      attributes: this.selectedAttributes,
    };
  },
});
</script>
