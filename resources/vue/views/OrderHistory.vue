<template>
  <div class="w-full h-full pl-0 md:pl-24">
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
    >
      <template #table-row="props">
        <router-link v-if="props.column.field === 'detail'"
                     :to="{name: getCurrentOrderStateRoute(statusLables[props.formattedRow['status']]), params: {id: props.formattedRow['id']}}"
                     target="_blank"><img
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
import {OrderStatusLables} from "../types/api-values";

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
          label: "Erstellt",
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Status",
          field: "status",
          type: "string",
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
    getCurrentOrderStateRoute(status: string) {
      switch (status) {
        case 'bezahlt': {
          return 'Order Pay';
        }
        case 'bestellt': {
          return 'Order Ordered';
        }
        case 'erhalten': {
          return 'Order Receive';
        }
        case 'übergeben': {
          return 'Order Handed Over';
        }
        case 'erstellt': {
          return 'Order Created';
        }
      }
    },
  }
});
</script>
