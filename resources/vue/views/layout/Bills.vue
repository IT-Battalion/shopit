<template>
  <h1>Rechnungen</h1>
  <Search />
  <Table class="mt-10" />
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