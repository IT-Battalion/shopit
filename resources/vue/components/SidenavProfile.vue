<template>
  <div
    class="fixed left-0 flex flex-col justify-center w-56 m-0 overflow-auto text-white  sidebar top-32 bg-backgroundColor"
  >
    <div
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
      class="flex flex-row my-5 py-1 pl-6 hover:bg-sidenavSelected"
    >
      <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
      <template v-if="category.name != 'Produkte'">
        <router-link :to="category.routerLink" class="my-auto">
          <a class="my-1 text-left">{{ category.name }}</a>
        </router-link>
      </template>
      <template v-else>
        <Menu as="div" class="relative inline-block text-left">
          <div>
            <MenuButton
              class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white shadow-sm  focus:outline-none focus:ring-2 focus:ring-highlighted"
            >
              Produkte
            </MenuButton>
          </div>

          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
          >
            <MenuItems
              class="absolute right-0 w-40 mt-2 overflow-hidden origin-top-right shadow-lg  ring-1 ring-black ring-opacity-5 focus:outline-none bg-elevatedDark"
            >
              <router-link to="/admin/produkte/hinzufuegen">
                <MenuItem
                  class="flex flex-row items-center justify-start  hover:bg-elevatedColor"
                >
                  <span class="block px-4 py-3 text-sm text-white"
                    ><img
                      src="/img/profile.svg"
                      class="object-scale-down mr-4 h-7"
                    />Hinzufügen</span
                  >
                </MenuItem>
              </router-link>
              <router-link to="/admin/produkte/bearbeiten">
                <MenuItem
                  class="flex flex-row items-center justify-start  hover:bg-elevatedColor"
                >
                  <span class="block px-4 py-3 text-sm text-white"
                    ><img
                      src="/img/profile.svg"
                      class="object-scale-down mr-4 h-7"
                    />Bearbeiten</span
                  >
                </MenuItem>
              </router-link>
            </MenuItems>
          </transition>
        </Menu>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {defineComponent} from "@vue/runtime-core";

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
        routerLink: {name:"Profile"},
        icon_url: "/img/categoryProfile.svg",
      },
      {
        name: "Bestellungen",
        routerLink: {name:"OrderHistory"},
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
