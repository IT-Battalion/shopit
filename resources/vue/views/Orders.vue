<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Bestellungen</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      theme="shopit"
      max-height="400px"
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
      <template #table-row="detail">
        <router-link :to="{name: 'Order detail', params: {id: detail.formattedRow['id']}}"
                     v-if="detail.column.field === 'detail'"><img src='/img/info-white.svg'
                                                                  class='object-scale-down h-7 w-full'/></router-link>
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {AxiosResponse} from "axios";
import "vue-good-table-next/dist/vue-good-table-next.css";
import {endLoad, initLoad} from "../loader";
import {Order} from "../types/api";


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
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Status",
          field: "status",
          type: "boolean",
        },
        {
          label: "Detail",
          field: "detail",
          html: true,
        },
      ],
      rows: [] as Order[],
    };
  },
  async beforeMount() {
    await this.loadOrders();
  },
  methods: {
    async loadOrders() {
      initLoad();
      let response: AxiosResponse<Order[]> = await this.$http.get('/admin/orders');
      this.rows = response.data;
      endLoad();
    }
  }
});
</script>
