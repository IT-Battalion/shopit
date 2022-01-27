<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Coupons</h1>
    <InputField
      ref="code"
      labelName="Rabattcode"
      :errorMessage="codeError"
      required
    />
    <InputField
      ref="discount"
      labelName="Rabatt"
      placeholder="%"
      required
      type="number"
      :step="5"
      :errorMessage="discountError"
    />
    <InputField
      ref="enabled_until"
      iconName="calender"
      labelName="Erhältlich bis"
      required
      type="date"
      class="min-w-max"
      :errorMessage="dateError"
    />
    <ButtonField
      iconSrc="/img/addBlack.svg"
      :loading="loading"
      @click="createCoupon() && isEmpty()"
    />
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
      <template #table-row="data">
        <img
          v-if="
            data.column.field === 'enabled' &&
            data.formattedRow['enabled'] === false
          "
          class="object-scale-down w-full h-7"
          src="/img/red-x.svg"
        />
        <img
          v-if="
            data.column.field === 'enabled' &&
            data.formattedRow['enabled'] === true
          "
          class="object-scale-down w-full h-7"
          src="/img/green-checkmark.svg"
        />
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "@/components/InputField.vue";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { AxiosResponse } from "axios";
import { Coupon, CreateCouponRequest } from "../types/api";
import { endLoad, initLoad } from "../loader";
import ButtonField from "../components/ButtonField.vue";
import { useToast } from "vue-toastification";

export default defineComponent({
  components: {
    InputField,
    ButtonField,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      codeError: "",
      discountError: "",
      dateError: "",
      loading: false,
      rows: [] as Coupon[],
      columns: [
        {
          label: "ID",
          field: "id",
          type: "number",
        },
        {
          label: "Code",
          field: "code",
          type: "string",
        },
        {
          label: "Rabatt",
          field: "discount",
          type: "percentage",
        },
        {
          label: "Status",
          field: "enabled",
          type: "boolean",
        },
        {
          label: "Erstellt",
          field: "created_at",
          type: "date",
          dateInputFormat: "yyyy-MM-dd'T'kk:mm:ss.SSSSSS'Z'",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
        {
          label: "Ablauf",
          field: "enabled_until",
          type: "date",
          dateInputFormat: "yyyy-MM-dd kk:mm:ss",
          dateOutputFormat: "dd.MM.yyyy kk:mm",
        },
      ],
    };
  },
  async beforeMount() {
    await this.loadCoupons();
  },
  methods: {
    async loadCoupons() {
      initLoad();
      let response: AxiosResponse<Coupon[]> = await this.$http.get(
        "/admin/coupons"
      );
      this.rows = response.data;
      endLoad();
    },
    async createCoupon() {
      try {
        this.loading = true;
        initLoad();
        let code = (this.$refs.code as typeof InputField).getValue();
        let discount = (this.$refs.discount as typeof InputField).getValue();
        let enabled_until =
          (this.$refs.enabled_until as typeof InputField).getValue() + "T00:00";
        console.log(enabled_until);
        let newCoupon = await this.$http
          .post<CreateCouponRequest, AxiosResponse<Coupon>>("/admin/coupons", {
            code,
            discount,
            enabled_until,
          })
          .catch((e) => {
            console.log(e);
            throw e;
          });
        console.log(newCoupon);
        this.rows.push(newCoupon.data);
        this.toast.success("Coupon code wurde erfolgreich erstellt!");
        this.loading = false;
      } catch (e) {
        this.toast.error(
          "Beim Erstellen des Coupons ist ein Fehler aufgetreten."
        );
      } finally {
        endLoad();
      }
    },
    isEmpty() {
      let code = (this.$refs.code as typeof InputField).getValue();
      let discount = (this.$refs.discount as typeof InputField).getValue();
      let enabled_until =
        (this.$refs.enabled_until as typeof InputField).getValue() + "T00:00";
      console.log(enabled_until);
      if (code == "") {
        this.codeError = "Couponcodefeld darf nicht leer sein!";
      } else {
        this.codeError = "";
      }
      if (discount == "") {
        this.discountError = "Rabattfeld darf nicht leer sein!";
      } else {
        this.discountError = "";
      }
      if (enabled_until) {
        this.dateError = "Datumfeld darf nicht leer sein!";
      } else {
        this.dateError = "";
      }
    },
  },
  setup() {
    const toast = useToast();
    return { toast };
  },
});
</script>
