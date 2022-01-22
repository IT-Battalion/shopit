<template>
  <div class="w-full h-full pl-0 md:pl-24">
    <h1 class="text-4xl font-bold text-white">Userverwaltung</h1>
    <vue-good-table
      class="mt-10"
      :columns="columns"
      :rows="rows"
      theme="shopit"
      max-height="400px"
      :pagination-options="{
      enabled: true,
      perPage: 5 //TODO add to other tables aswell
      }"
      :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import "vue-good-table-next/dist/vue-good-table-next.css";
import {endLoad, initLoad} from "../../loader";
import {AxiosResponse} from "axios";
import {UserManagementUser} from "../../types/api"

export default defineComponent({
  components: {
    "vue-good-table": require("vue-good-table-next").VueGoodTable,
  },
  data() {
    return {
      users: [] as any as UserManagementUser[],
      columns: [
        {
          label: "ID",
          field: "id",
          type: "number",
        },
        {
          label: "Name",
          field: "username",
        },
        {
          label: "Vorname",
          field: "firstname",
        },
        {
          label: "Nachname",
          field: "lastname",
        },
        {
          label: "Email",
          field: "email",
        },
        {
          label: "Detail",
          field: "detail",
          html: true,
        },
      ],
      rows: this.users,
    };
  },
  async beforeMount() {
    await this.loadUsers();
  },
  methods: {
    async loadUsers() {
      initLoad();
      let response: AxiosResponse<UserManagementUser[]> = await this.$http.get('/admin/users');
      this.users = response.data;
      this.users.forEach(function (user) {
        user.detail = "<button><img src='/img/info-white.svg' class='h-7'/></button>";
      });
      endLoad();//
    }
  }
});
</script>
