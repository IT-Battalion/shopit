<template>

</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
  name: "Log",
  props: ['debug'],
  data() {
    console.log(this.debug);
    return {};
  },
});
</script>
