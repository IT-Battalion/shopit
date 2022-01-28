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
      :sort-options="{
        initialSortBy: {field: 'created_at', type: 'desc'},
        enabled: true,
      }"
    >
      <template #table-row="props">
        <router-link :to="getLink(props.formattedRow['status'], props.formattedRow['id'])"
                     v-if="props.column.field === 'detail'" target="_blank"><img src='/img/info-white.svg'
                                                                                 class='object-scale-down h-7 w-full'/>
        </router-link>
        <span v-if="props.column.field === 'status'">
          {{ statusLables[props.formattedRow[props.column.field]] }}
        </span>
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
import {OrderStatus, OrderStatusLables} from "../types/api-values";


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
          field: "total",
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
          type: "number",
        },
        {
          label: "Detail",
          field: "detail",
          html: true,
        },
      ],
      rows: [] as Order[],
      statusLables: OrderStatusLables,
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
    },
    getLink(status: OrderStatus, id: number) {
      switch (status) {
        case OrderStatus.CREATED:
          return {name: "Admin Order Created", params: {id}};
        case OrderStatus.PAID:
          return {name: "Admin Order Pay", params: {id}};
        case OrderStatus.ORDERED:
          return {name: "Admin Order Ordered", params: {id}};
        case OrderStatus.RECEIVED:
          return {name: "Admin Order Received", params: {id}};
        case OrderStatus.HANDED_OVER:
          return {name: "Admin Order Handed Over", params: {id}};
      }
    }
  }
});
</script>
