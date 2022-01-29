<template>
  <Switch v-model="enabled" :class="enabled ? 'bg-indigo-700' : 'bg-gray-300'"
          class="relative inline-flex flex-shrink-0 h-[38px] w-[74px] border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
    <span aria-hidden="true" :class="enabled ? 'translate-x-9' : 'translate-x-0'"
          class="pointer-events-none inline-block h-[34px] w-[34px] rounded-full bg-white shadow-lg transform ring-0 transition ease-in-out duration-200"/>
  </Switch>
</template>

<script>
import {defineComponent} from "@vue/runtime-core";
import {Switch} from "@headlessui/vue";
import {ref} from "vue";

export default defineComponent({
  components: {
    Switch,
  },
  setup() {
    const enabled = ref(false);

    return {
      enabled,
    };
  },
  methods: {
    getEnabled() {
      return this.enabled;
    },
    setEnabled(enabled) {
      this.enabled = enabled;
    },
  }
});
</script>
