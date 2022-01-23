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
      perPage: 5
      }"
      :search-options="{
        enabled: true,
        trigger: 'enter',
        placeholder: 'Search this table',
      }">
      <template #table-row="detail">
        <router-link :to="{name: 'User detail', params: {id: detail.formattedRow['id']}}"
                     v-if="detail.column.field === 'detail'" target="_blank"><img src='/img/info-white.svg'
                                                                                  class='object-scale-down h-7 w-full'/>
        </router-link>
      </template>
    </vue-good-table>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import "vue-good-table-next/dist/vue-good-table-next.css";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {UserManagementUser} from "../types/api";

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
      rows: [] as UserManagementUser[],
      //rows: [{"id":1,"username":"smuhr.test","email":"smuhr.test@tgm.ac.at","firstname":"Sandra","lastname":"Muhr","name":"Sandra Muhr","employeeType":"lehrer","class":"4DHIT","lang":"de-AT","is_admin":true,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:44.000000Z","updated_at":"2022-01-22T17:13:44.000000Z","shopping_cart_coupon_id":null},{"id":2,"username":"mbraun.test","email":"mbraun.test@student.tgm.ac.at","firstname":"Moritz","lastname":"Braun","name":"Moritz Braun","employeeType":"schueler","class":"3DHIT","lang":"de-AT","is_admin":true,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:44.000000Z","updated_at":"2022-01-22T17:13:44.000000Z","shopping_cart_coupon_id":null},{"id":3,"username":"hharrer.test","email":"hharrer.test@student.tgm.ac.at","firstname":"Harald","lastname":"Harrer","name":"Harald Harrer","employeeType":"schueler","class":"5DHIT","lang":"de-AT","is_admin":true,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:44.000000Z","updated_at":"2022-01-22T17:13:44.000000Z","shopping_cart_coupon_id":null},{"id":4,"username":"pnussbaumer.test","email":"pnussbaumer.test@student.tgm.ac.at","firstname":"Pia","lastname":"Nussbaumer","name":"Pia Nussbaumer","employeeType":"schueler","class":"4CHIT","lang":"de-AT","is_admin":true,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:44.000000Z","updated_at":"2022-01-22T17:13:44.000000Z","shopping_cart_coupon_id":null},{"id":5,"username":"eswoboda.test","email":"eswoboda.test@tgm.ac.at","firstname":"Elena","lastname":"Swoboda","name":"Elena Swoboda","employeeType":"lehrer","class":"5CHIT","lang":"de-AT","is_admin":true,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:44.000000Z","updated_at":"2022-01-22T17:13:44.000000Z","shopping_cart_coupon_id":null},{"id":6,"username":"em\u00fchlbacher.test","email":"em\u00fchlbacher.test@tgm.ac.at","firstname":"Emma","lastname":"M\u00fchlbacher","name":"Emma M\u00fchlbacher","employeeType":"lehrer","class":"2AHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":7,"username":"bmaier.test","email":"bmaier.test@tgm.ac.at","firstname":"Bernhard","lastname":"Maier","name":"Bernhard Maier","employeeType":"lehrer","class":"5DHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":8,"username":"sstern.test","email":"sstern.test@tgm.ac.at","firstname":"Sonja","lastname":"Stern","name":"Sonja Stern","employeeType":"lehrer","class":"1CHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":9,"username":"tschiller.test","email":"tschiller.test@student.tgm.ac.at","firstname":"Tobias","lastname":"Schiller","name":"Tobias Schiller","employeeType":"schueler","class":"1CHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":10,"username":"croth.test","email":"croth.test@tgm.ac.at","firstname":"Claudia","lastname":"Roth","name":"Claudia Roth","employeeType":"lehrer","class":"3DHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":11,"username":"hhofer.test","email":"hhofer.test@student.tgm.ac.at","firstname":"Hanna","lastname":"Hofer","name":"Hanna Hofer","employeeType":"schueler","class":"5BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":12,"username":"strimmel.test","email":"strimmel.test@tgm.ac.at","firstname":"Stefanie","lastname":"Trimmel","name":"Stefanie Trimmel","employeeType":"lehrer","class":"5DHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":13,"username":"tleitgeb.test","email":"tleitgeb.test@student.tgm.ac.at","firstname":"Tobias","lastname":"Leitgeb","name":"Tobias Leitgeb","employeeType":"schueler","class":"1BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":14,"username":"nfritsch.test","email":"nfritsch.test@student.tgm.ac.at","firstname":"Nina","lastname":"Fritsch","name":"Nina Fritsch","employeeType":"schueler","class":"3DHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":15,"username":"lschreiber.test","email":"lschreiber.test@tgm.ac.at","firstname":"Lukas","lastname":"Schreiber","name":"Lukas Schreiber","employeeType":"lehrer","class":"5BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":16,"username":"lputz.test","email":"lputz.test@tgm.ac.at","firstname":"Leon","lastname":"Putz","name":"Leon Putz","employeeType":"lehrer","class":"4CHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":17,"username":"cmaurer.test","email":"cmaurer.test@tgm.ac.at","firstname":"Christopher","lastname":"Maurer","name":"Christopher Maurer","employeeType":"lehrer","class":"2BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":18,"username":"veigner.test","email":"veigner.test@tgm.ac.at","firstname":"Verena","lastname":"Eigner","name":"Verena Eigner","employeeType":"lehrer","class":"5CHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":19,"username":"smessner.test","email":"smessner.test@tgm.ac.at","firstname":"Selina","lastname":"Messner","name":"Selina Messner","employeeType":"lehrer","class":"1DHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":20,"username":"tlamprecht.test","email":"tlamprecht.test@student.tgm.ac.at","firstname":"Theo","lastname":"Lamprecht","name":"Theo Lamprecht","employeeType":"schueler","class":"2AHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":21,"username":"nplank.test","email":"nplank.test@student.tgm.ac.at","firstname":"Noah","lastname":"Plank","name":"Noah Plank","employeeType":"schueler","class":"1CHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":22,"username":"rf\u00fcrst.test","email":"rf\u00fcrst.test@student.tgm.ac.at","firstname":"Ralph","lastname":"F\u00fcrst","name":"Ralph F\u00fcrst","employeeType":"schueler","class":"5BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":23,"username":"jrauch.test","email":"jrauch.test@tgm.ac.at","firstname":"Johanna","lastname":"Rauch","name":"Johanna Rauch","employeeType":"lehrer","class":"1BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":24,"username":"hstrasser.test","email":"hstrasser.test@tgm.ac.at","firstname":"Hannah","lastname":"Strasser","name":"Hannah Strasser","employeeType":"lehrer","class":"2AHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null},{"id":25,"username":"peigner.test","email":"peigner.test@tgm.ac.at","firstname":"Paul","lastname":"Eigner","name":"Paul Eigner","employeeType":"lehrer","class":"5BHIT","lang":"de-AT","is_admin":false,"enabled":true,"reason_for_disabling":null,"disabled_at":null,"disabled_by_id":null,"deleted_at":null,"created_at":"2022-01-22T17:13:45.000000Z","updated_at":"2022-01-22T17:13:45.000000Z","shopping_cart_coupon_id":null}],
    };
  },
  async beforeMount() {
    await this.loadUsers();
  },
  methods: {
    async loadUsers() {
      initLoad();
      let response: AxiosResponse<UserManagementUser[]> = await this.$http.get('/admin/users');
      this.rows = response.data;
      endLoad();
    },
  }
});
</script>
