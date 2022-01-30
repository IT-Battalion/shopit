<template>
  <div
    class="fixed left-0 flex flex-col justify-center w-56 m-0 overflow-auto text-white  sidebar top-32 bg-backgroundColor"
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="flex flex-row py-1 pl-6 my-5 hover:text-sidenavSelected rounded-xl"
    >
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <template v-if="category.name != 'Produkte'">
        <router-link :to="category.routerLink" class="my-auto">
          <span class="my-1 text-left">{{ category.name }}</span>
        </router-link>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
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
