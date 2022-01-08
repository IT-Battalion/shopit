<template>
  <div
    class="
      fixed
      left-0
      flex flex-col
      justify-center
      invisible
      w-56
      pl-4
      m-0
      text-white
      md:visible
      sidebar
      top-32
      bg-backgroundColor
      overflow-auto
    "
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="flex flex-row my-6 ml-6 hover:bg-sidenavSelected rounded-full"
    >
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <a class="my-1 text-left" :href="'#' + category.name">{{
        category.name
      }}</a>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  setup() {
    const categories = [
      { name: "Meine Daten", icon_url: "../img/categoryProfile.svg" },
      { name: "Rechnungen", icon_url: "../img/categoryBills.svg" },
      { name: "Bestellverlauf", icon_url: "../img/categoryHistory.svg" },
      { name: "Produkte", icon_url: "../img/categoryProducts.svg" },
      { name: "Kategorien", icon_url: "../img/categoryCategories.svg" },
      { name: "Bestellungen", icon_url: "../img/categoryOrders.svg" },
      { name: "Userverwaltung", icon_url: "../img/categoryUser.svg" },
      { name: "Coupons", icon_url: "../img/categoryCoupon.svg" },
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