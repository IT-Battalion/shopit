<template>
  <form action="GET">
    <label class="mb-3 mr-3 text-base text-gray-300">{{ labelName }}</label>
    <input
      class="px-3 py-2 text-white border rounded shadow appearance-none  bg-elevatedColor text-grey-darker"
    />
  </form>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    labelName: String,
  },
});
</script>