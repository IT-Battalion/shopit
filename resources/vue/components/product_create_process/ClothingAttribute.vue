<template>
  <div class="w-1/4 p-5 ml-5 rounded-2xl bg-elevatedDark">
    <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
      Kleidungsgrößen
    </h2>
    <Multiselect
      mode="tags"
      :close-on-select="false"
      :searchable="true"
      :create-option="true"
      :options="optionsClothing"
    />
  </div>
</template>

<script>
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
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
