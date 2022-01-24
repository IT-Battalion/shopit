<template>
  <h1 class="text-3xl font-bold text-white">User Detail</h1>
  <h1 class="text-3xl font-bold text-white">Bestellungen</h1>
  <vue-good-table
    :columns="userOrderColumns"
    :pagination-options="{
      enabled: true,
      perPage: 5,
    }"
    :rows="userOrderRows"
    :search-options="{
      enabled: true,
      trigger: 'enter',
      placeholder: 'Search this table',
    }"
    class="mt-10"
    max-height="400px"
    theme="shopit"
  >
    <template #table-row="props">
      <span v-if="props.column.field === 'status'">
        {{ statusLables[props.formattedRow[props.column.field]] }}
      </span>
    </template>
  </vue-good-table>
  <h1 class="my-10 text-3xl font-bold text-white">Benutzer ent/sperren</h1>
  <div class="w-1/2 bg-white">
    <QuillEditor theme="snow" toolbar="minimal" />
  </div>
  <ButtonField
    name="ent/sperren"
    :acceptName="true"
    iconSrc="/img/lockBlack.svg"
    class="mt-10"
  />
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import { Order, User } from "../types/api";
import { endLoad, initLoad } from "../loader";
import { AxiosResponse } from "axios";
import { OrderStatusLables } from "../types/api-values";
import ButtonField from "../components/ButtonField.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default defineComponent({
  components: {
    ButtonField,
    QuillEditor,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      statusLables: OrderStatusLables,
      userOrderColumns: [
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
          label: "Bestellt am",
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Bezahlt bei",
          field: "transaction_confirmed_by_id",
          type: "number",
        },
        {
          label: "Bezahlt am",
          field: "paid_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd kk:mm:ss",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Produkte bestellt von",
          field: "products_ordered_by_id",
          type: "number",
        },
        {
          label: "Produkte bestellt am",
          field: "products_ordered_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd kk:mm:ss",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Produkte erhalten von",
          field: "products_received_by_id",
          type: "number",
        },
        {
          label: "Produkte erhalen am",
          field: "products_received_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd kk:mm:ss",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Produkte abgegeben von",
          field: "handed_over_by_id",
          type: "number",
        },
        {
          label: "Produkte abgegeben am",
          field: "handed_over_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd kk:mm:ss",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Coupon",
          field: "coupon_code_id",
          type: "number",
        },
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
      let response: AxiosResponse<Order[]> = await this.$http.get(
        "/admin/user/" + this.$route.params.id + "/orders"
      );
      this.userOrderRows = response.data;
      endLoad();
    },
    async loadUser() {
      initLoad();
      let response: AxiosResponse<User> = await this.$http.get(
        "/admin/user/" + this.$route.params.id
      );
      //this.user = response.data;
      endLoad();
    },
  },
});
</script>
