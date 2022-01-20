<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Bestellverlauf</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      max-height="400px"
      :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import "vue-good-table-next/dist/vue-good-table-next.css";

export default defineComponent({
  components: {
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
          label: "Status",
          field: "status",
          type: "boolean",
        },
        {
          label: "Detail",
          field: "detail",
        },
      ],
      rows: [
        {
          id: 1,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
        {
          id: 2,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
        {
          id: 3,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
        {
          id: 4,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
        {
          id: 5,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
        {
          id: 6,
          price: "30.00",
          createdAt: "2011-10-31",
          status: "false",
          detail: "i",
        },
      ],
    };
  },
});
</script>