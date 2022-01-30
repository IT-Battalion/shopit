<template>
  <div class="w-full p-5 ml-5 rounded-2xl bg-elevatedDark">
    <Multiselect
      mode="tags"
      v-model="clothings"
      :close-on-select="false"
      :searchable="true"
      :create-option="true"
      :options="optionsClothing"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {clothingSizeLabels} from "../../types/api-values";
import Multiselect from "@vueform/multiselect";

export default defineComponent({
  components: {
    Multiselect,
  },
  data() {
    return {
      optionsClothing: clothingSizeLabels,
      clothings: [] as string[],
    };
  },
  methods: {
    getClothing(): string[] {
      return this.clothings;
    },
    setClothing(value: string[]) {
      this.clothings = value;
    }
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
