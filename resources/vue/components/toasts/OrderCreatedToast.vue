<template>
  <div>
    Es wurde eine
    <a :href="link" class="underline hover:no-underline" target="_blank">neue Bestellung</a>
    aufgegeben.
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: "OrderCreatedToast",
  props: {
    link: {
      type: String,
      required: true,
    },
  },
});
</script>
