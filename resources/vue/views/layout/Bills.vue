<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Rechnungen</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      max-height="400px"
      theme="shopit"
      :pagination-options="{
    enabled: true
  }"
      :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import Search from "@/components/Search.vue";
import Table from "@/components/Table.vue";
import "vue-good-table-next/dist/vue-good-table-next.css";

export default defineComponent({
  name: "Bills",
  components: {
    Table,
    Search,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      columns: [
        {
          label: "ID",
          field: "id",
          type: "number",
        },
        {
          label: "Preis",
          field: "price",
          type: "number",
        },
        {
          label: "Datum",
          field: "createdAt",
          type: "date",
          dateInputFormat: "yyyy-MM-dd",
          dateOutputFormat: "MMM do yy",
        },
        {
          label: "Detail",
          field: "detail",
        },
      ],
      rows: [
        {
          id: 1,
          price: "30.30",
          createdAt: "2011-10-31",
          detail: "i",
        },
        {
          id: 2,
          price: "30.30",
          createdAt: "2011-10-31",
          detail: "i",
        },
        {
          id: 3,
          price: "30.30",
          createdAt: "2011-10-30",
          detail: "i",
        },
        {
          id: 4,
          price: "30.30",
          createdAt: "2011-10-11",
          detail: "i",
        },
        {
          id: 5,
          price: "30.30",
          createdAt: "2011-10-21",
          detail: "i",
        },
        {
          id: 6,
          price: "30.30",
          createdAt: "2011-10-31",
          detail: "i",
        },
      ],
    };
  },
});
</script>
