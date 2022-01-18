<template>
  <div
    class="fixed left-0 flex flex-col justify-center w-56 pl-4 m-0 overflow-auto text-white  sidebar top-32 bg-backgroundColor"
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="flex flex-row my-6 ml-6 rounded-full hover:bg-sidenavSelected"
    >
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <router-link :to="`/admin/${category.routerLink}`" class="my-auto">
        <a class="my-1 text-left">{{ category.name }}</a>
      </router-link>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  setup() {
    const categories = [
      {
        name: "Profil",
        routerLink: "",
        icon_url: "/img/categoryProfile.svg",
      },
      {
        name: "Rechnungen",
        routerLink: "rechnungen",
        icon_url: "/img/categoryBills.svg",
      },
      {
        name: "Bestellverlauf",
        routerLink: "bestellverlauf",
        icon_url: "/img/categoryHistory.svg",
      },
      {
        name: "Produkte",
        routerLink: "produkte",
        icon_url: "/img/categoryProducts.svg",
      },
      {
        name: "Kategorien",
        routerLink: "kategorien",
        icon_url: "/img/categoryCategories.svg",
      },
      {
        name: "Bestellungen",
        routerLink: "bestellungen",
        icon_url: "/img/categoryOrders.svg",
      },
      {
        name: "Userverwaltung",
        routerLink: "userverwaltung",
        icon_url: "/img/categoryUser.svg",
      },
      {
        name: "Coupons",
        routerLink: "coupons",
        icon_url: "/img/categoryCoupon.svg",
      },
    ];
    return { categories };
  },
};
</script>

<style>
.sidebar {
  height: calc(100% - 8rem);
}
</style>
