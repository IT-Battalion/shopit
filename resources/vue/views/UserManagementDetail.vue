<template>
  <div>
    <Profile :loading="state.isLoading" :user="user" />
    <h2 class="mt-24 mb-6 text-3xl font-bold text-white">Bestellungen</h2>
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
      max-height="400px"
      theme="shopit"
    >
      <template #table-row="props">
        <span v-if="props.column.field === 'status'">
          {{ statusLables[props.formattedRow[props.column.field]] }}
        </span>
      </template>
    </vue-good-table>
    <div>
      <h2 class="mt-24 mb-6 text-3xl font-bold text-white">
        Benutzer {{ getActionVerb() }}
      </h2>
      <div class="flex flex-row gap-4">
        <div class="flex flex-col w-1/2 gap-2">
          <label for="reason" class="text-sm text-gray-400">Grund</label>
          <textarea
            class="text-white bg-elevatedDark rounded-2xl"
            id="reason"
            v-model="ban.reason"
            :disabled="!user.enabled"
          ></textarea>
        </div>
        <ButtonField
          name="Sperren"
          :acceptName="true"
          :icon-spinner="state.isLoading"
          @click="user.enabled ? banUser() : unbanUser()"
        >
          <template v-slot:text
            ><span>{{ getActionVerb() }}</span></template
          >
          <template v-slot:icon><img src="/img/lockBlack.svg" /></template>
        </ButtonField>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import { Ban, BanUserRequest, Order, User } from "../types/api";
import { endLoad, initLoad, state } from "../loader";
import { AxiosResponse } from "axios";
import { OrderStatusLables } from "../types/api-values";
import Profile from "../components/Profile.vue";
import ButtonField from "../components/ButtonField.vue";
import { useToast } from "vue-toastification";

export default defineComponent({
  components: {
    Profile,
    ButtonField,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  setup() {
    return {
      toast: useToast(),
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
          field: "transaction_confirmed_by.username",
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
          field: "products_ordered_by.username",
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
          field: "products_received_by.username",
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
          field: "handed_over_by.username",
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
          field: "coupon.code",
          type: "number",
        },
      ],
      state,
    };
  },
  data() {
    return {
      userOrderRows: [] as Order[],
      user: {} as User,
      ban: {} as Ban,
    };
  },
  async beforeMount() {
    await Promise.all([this.loadOrders(), this.loadUser(), this.loadBan()]);
  },
  methods: {
    async loadOrders() {
      initLoad();
      let response: AxiosResponse<Order[]> = await this.$http.get(
        `/admin/orders/user/${this.$route.params.id}`
      );
      this.userOrderRows = response.data;
      endLoad();
    },
    async loadUser() {
      initLoad();
      let response: AxiosResponse<User> = await this.$http.get(
        `/admin/users/${this.$route.params.id}`
      );
      this.user = response.data;
      endLoad();
    },
    async loadBan() {
      initLoad();
      let response: AxiosResponse<Ban> = await this.$http.get(
        `/admin/ban/user/${this.$route.params.id}/info`
      );
      this.ban = response.data;
      endLoad();
    },
    async banUser() {
      initLoad();
      try {
        let reason = this.ban.reason;
        let ban = await this.$http.post<BanUserRequest, AxiosResponse<Ban>>(
          `/admin/ban/user/${this.$route.params.id}/ban`,
          {
            reason,
          }
        );
        this.toast.success("Benutzer wurde erfolgreich gesperrt.");
        this.ban = ban.data;
        this.user.enabled = false;
      } catch (e) {
        this.toast.error("Fehler beim sperren des Benutzers.");
      }
      endLoad();
    },
    async unbanUser() {
      initLoad();
      try {
        let ban = await this.$http.post<any, AxiosResponse<Ban>>(
          `/admin/ban/user/${this.$route.params.id}/unban`
        );
        this.toast.success("Benutzer wurde erfolgreich entsperrt.");
        this.ban = ban.data;
        this.user.enabled = true;
      } catch (e) {
        this.toast.error("Fehler beim entsperren des Benutzers.");
      }
      endLoad();
    },
    getActionVerb() {
      return this.user.enabled || state.isLoading ? "Sperren" : "Entsperren";
    },
  },
});
</script>
