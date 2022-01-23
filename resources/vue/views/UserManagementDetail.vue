<template>
  <h1 class="text-3xl text-white font-bold">User Detail</h1>
  <h1 class="text-3xl text-white font-bold">Bestellungen</h1>
  <vue-good-table
    :columns="userOrderColumns"
    :pagination-options="{
      enabled: true,
      perPage: 5
      }"
    :rows="userOrderRows"
    :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }"
    class="mt-10"
    max-height="400px"
    theme="shopit">
    <template #table-row="data">
    </template>
  </vue-good-table>
  <h1 class="text-3xl text-white font-bold">Benutzer ent/sperren</h1>
  <TextArea/>
  <button
    class="w-24 row-span-2 px-4 py-1 bg-white rounded-3xl hover:bg-gray-300"
    type="button"
  >
    dadas
  </button>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import TextArea from "@/components/TextArea.vue";
import {Order, User} from "../types/api";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";

export default defineComponent({
  components: {
    TextArea,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      userOrderColumns: [
        {
          label: 'ID',
          field: 'id',
          type: 'number',
        },
        {
          label: 'Status',
          field: 'status',
          type: 'string',
        },
        {
          label: 'Bestellt am',
          field: 'created_at',
          type: 'date',
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: 'Bezahlt bei',
          field: 'transaction_confirmed_by_id',
          type: 'number'
        },
        {
          label: 'Bezahlt am',
          field: 'paid_at',
          type: 'date',
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: 'Produkte bestellt von',
          field: 'products_ordered_by_id',
          type: 'number',
        },
        {
          label: 'Produkte bestellt am',
          field: 'products_ordered_at',
          type: 'date',
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: 'Produkte erhalten von',
          field: 'products_received_by_id',
          type: 'number',
        },
        {
          label: 'Produkte erhalen am',
          field: 'products_received_at',
          type: 'date',
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: 'Produkte abgegeben von',
          field: 'handed_over_by_id',
          type: 'number',
        },
        {
          label: 'Produkte abgegeben am',
          field: 'handed_over_at',
          type: 'date',
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: 'Coupon',
          field: 'coupon_code_id',
          type: 'number',
        }
      ],
      userOrderRows: [] as Order[],
      //user: Object as User,
    };
  },
  async beforeMount() {
    await this.loadOrders();
  },
  methods: {
    async loadOrders() {
      initLoad();
      let response: AxiosResponse<Order[]> = await this.$http.get('/admin/user/' + 1 + '/orders');
      this.userOrderRows = response.data;
      endLoad();
    },
    async loadUser() {
      initLoad();
      let response: AxiosResponse<User> = await this.$http.get('/admin/user/' + this.$route.params.id);
      //this.user = response.data;
      endLoad();
    }
  }
});
</script>
