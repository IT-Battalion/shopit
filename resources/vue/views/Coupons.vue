<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Coupons</h1>
    <InputField labelName="Rabattcode" />
    <InputField labelName="Rabatt" type="number" placeholder="0.33 => 33%" />
    <InputField labelName="Erhältlich bis" iconName="calender" type="date" />
    <ButtonField iconSrc="/img/addBlack.svg" />
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
          class="object-scale-down h-7 w-full"
          src="/img/red-x.svg"
        />
        <img
          v-if="
            data.column.field === 'enabled' &&
            data.formattedRow['enabled'] === true
          "
          class="object-scale-down h-7 w-full"
          src="/img/green-checkmark.svg"
        />
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "@/components/InputField.vue";
import InputFieldIcon from "@/components/InputFieldIcon.vue";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { AxiosResponse } from "axios";
import { Coupon } from "../types/api";
import { endLoad, initLoad } from "../loader";
import ButtonField from "../components/ButtonField.vue";

export default defineComponent({
  components: {
    InputField,
    ButtonField,
    InputFieldIcon,
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
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
  },
});
</script>
