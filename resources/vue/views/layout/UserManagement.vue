<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Userverwaltung</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      theme="shopit"
      max-height="400px"
      :pagination-options="{
      enabled: true,
      perPage: 5 //TODO add to other tables aswell
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
          html: true,
        },
      ],
      rows: [
        {
          id: 1,
          name: "userTest",
          firstname: "Max",
          lastname: "Mustermann",
          email: "test@example.at",
          detail: "<button><img src='/img/info-white.svg' class='object-scale-down h-7'/></button>",
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
