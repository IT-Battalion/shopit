<template>
  <Sidenav>
    <template
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
    >
      <router-link
        :to="category.routerLink"
        class="flex flex-row py-3 pl-6 my-3 ml-3  w-max hover:text-sidenavSelected rounded-xl"
        v-if="category.name != 'Produkte'"
        as="div"
      >
        <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
        <span class="my-1 text-left">{{ category.name }}</span>
      </router-link>
      <ProductDropDown v-else />
    </template>
  </Sidenav>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import ProductDropDown from "./ProductDropDown.vue";
import Sidenav from "./Sidenav.vue";

export default defineComponent({
  name: 'SidenavAdmin',
  components: {
    ProductDropDown,
    Sidenav,
  },
  setup() {
    const categories = [
      {
        name: "Dashboard",
        routerLink: { name: "Admin" },
        icon_url: "/img/categoryDashboard.svg",
      },
      {
        name: "Rechnungen",
        routerLink: { name: "Invoices" },
        icon_url: "/img/categoryBills.svg",
      },
      {
        name: "Produkte",
        routerLink: { name: "ProductManagement" },
        icon_url: "/img/categoryProducts.svg",
      },
      {
        name: "Kategorien",
        routerLink: { name: "CategoryManagement" },
        icon_url: "/img/categoryCategories.svg",
      },
      {
        name: "Bestellungen",
        routerLink: { name: "Admin Orders" },
        icon_url: "/img/categoryOrders.svg",
      },
      {
        name: "Userverwaltung",
        routerLink: { name: "UserManagement" },
        icon_url: "/img/categoryUser.svg",
      },
      {
        name: "Coupons",
        routerLink: { name: "Coupons" },
        icon_url: "/img/categoryCoupon.svg",
      },
    ];
    return { categories };
  },
});
</script>

<style>
.sidebar {
  height: calc(100% - 8rem);
}
</style>
