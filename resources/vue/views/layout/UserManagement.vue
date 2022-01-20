<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Userverwaltung</h1>
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
          label: "Name",
          field: "name",
        },
        {
          label: "Vorname",
          field: "firstname",
        },
        {
          label: "Nachname",
          field: "lastname",
        },
        {
          label: "Email",
          field: "email",
        },
        {
          label: "Detail",
          field: "detail",
        },
      ],
      rows: [
        {
          id: 1,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
        {
          id: 2,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
        {
          id: 3,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
        {
          id: 4,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
        {
          id: 5,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
        {
          id: 6,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "i",
        },
      ],
    };
  },
});
</script>