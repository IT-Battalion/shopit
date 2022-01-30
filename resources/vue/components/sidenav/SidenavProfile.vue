<template>
  <Sidenav>
    <router-link
        :to="category.routerLink"
        class="my-auto flex flex-row py-1 pl-6 my-5 hover:text-sidenavSelected rounded-xl"
        v-for="category in categories"
        v-bind:key="category.icon_url">
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <span class="my-1 text-left" v-if="category.name != 'Produkte'">{{ category.name }}</span>
    </router-link>
  </Sidenav>
</template>

<script lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { defineComponent } from "@vue/runtime-core";
import Sidenav from "./Sidenav.vue";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Sidenav,
  },
  setup() {
    const categories = [
      {
        name: "Profil",
        routerLink: { name: "Profile" },
        icon_url: "/img/categoryProfile.svg",
      },
      {
        name: "Bestellungen",
        routerLink: { name: "OrderHistory" },
        icon_url: "/img/categoryBills.svg",
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
