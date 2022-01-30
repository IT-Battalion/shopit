<template>
  <div class="w-full h-full pl-0">
    <h1 class="text-4xl font-bold text-white">Bestellverlauf</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      max-height="400px"
      theme="shopit"
      :pagination-options="{
    enabled: true,
    perPage: 5
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
                     :to="getLink(props.formattedRow['status'], props.formattedRow['id'])" target="_blank"><img
          class='object-scale-down h-7 w-full'
          src='/img/info-white.svg'/></router-link>
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
import {Order} from "../types/api";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {OrderStatus, OrderStatusLables} from "../types/api-values";
import {useRoute} from "vue-router";

export default defineComponent({
  components: {
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    const route = useRoute();
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
          label: "Erstellt",
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
      let response: AxiosResponse<Order[]> = await this.$http.get('/user/orders');
      this.rows = response.data;
      endLoad();
    },
    getLink(status: OrderStatus, id: number) {
      return {name: "Order Detail", params: {id}};
    }
  }
});
</script>
