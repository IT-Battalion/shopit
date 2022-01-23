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
    enabled: true,
    perPage: 5,
  }"
      :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }"
    >
      <template #table-row="download">
        <router-link v-if="download.column.field === 'download'"
                     :to="{name: 'Invoice detail', params: {id: download.formattedRow['id']}}"><img
          class='object-scale-down h-7'
          src='/img/info-white.svg'/></router-link>
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import Search from "@/components/Search.vue";
import Table from "@/components/Table.vue";
import "vue-good-table-next/dist/vue-good-table-next.css";
import {Invoice} from "../../types/api";
import {AxiosResponse} from "axios";
import {endLoad, initLoad} from "../../loader";

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
          label: "Status",
          field: "status",
          type: "string",
        },
        {
          label: "Preis",
          field: "price",
          type: "number",
        },
        {
          label: "Erstellt",
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd",
          dateOutputFormat: "MMM do yy",
        },
        {
          label: "Detail",
          field: "detail",
          html: true,
        },
      ],
      rows: [] as Invoice[],
    };
  },
  async beforeMount() {
    await this.loadInvoices();
  },
  methods: {
    async loadInvoices() {
      initLoad();
      let response: AxiosResponse<Invoice[]> = await this.$http.get("/admin/invoices");
      this.rows = response.data;
      endLoad();
    }
  }
});
</script>
