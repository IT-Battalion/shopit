<template>
  <div class="w-full h-full pl-0">
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
      :sort-options="{
        initialSortBy: {field: 'created_at', type: 'desc'},
        enabled: true,
      }"
    >
      <template #table-row="props">
        <router-link v-if="props.column.field === 'detail'"
                     :to="{name: 'Invoice detail', params: {id: props.formattedRow['id']}}"><img
          class='object-scale-down h-7 w-full'
          src='/img/info-white.svg'/></router-link>
        <router-link v-if="props.column.field === 'download'"
                     :to="{name: 'Invoice detail', params: {id: props.formattedRow['id']}}"><img
          class='object-scale-down h-7 w-full'
          src='/img/download.svg'/></router-link>
        <span v-if="props.column.field === 'status'">
          {{ statusLables[props.formattedRow[props.column.field]] }}
        </span>
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import "vue-good-table-next/dist/vue-good-table-next.css";
import {Invoice} from "../types/api";
import {AxiosResponse} from "axios";
import {endLoad, initLoad} from "../loader";
import {OrderStatusLabels} from "../types/api-values";

export default defineComponent({
  name: "Bills",
  components: {
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      statusLables: OrderStatusLabels,
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
          field: "total",
          type: "number",
        },
        {
          label: "Erstellt",
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Detail",
          field: "detail",
          html: true,
        },
        {
          label: "Download",
          field: 'download',
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
      let response: AxiosResponse<Invoice[]> = await this.$http.get(
        "/admin/invoice"
      );
      this.rows = response.data;
      endLoad();
    },
  },
});
</script>
