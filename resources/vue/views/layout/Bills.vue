<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Rechnungen</h1>
    <Search />
    <Table />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import Search from "@/components/Search.vue";
import Table from "@/components/Table.vue";

export default defineComponent({
  components: {
    Table,
    Search,
  },
});
</script>