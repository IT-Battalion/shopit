<template>
  <Menu as="div" class="relative inline-block w-full text-left">
    <div class="w-full my-3 ml-3">
      <MenuButton
        class="inline-flex items-center justify-center px-6 py-3 text-white  hover:text-sidenavSelected rounded-xl"
      >
        <img :src="iconSrc" class="object-scale-down h-8 mr-4" />
        <span class="text-base">Produkte</span>
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
        class="absolute right-0 w-40 mt-2 overflow-hidden origin-top-right rounded-md shadow-lg  ring-1 ring-black ring-opacity-5 focus:outline-none bg-elevatedDark"
      >
        <router-link :to="{ name: 'Add Product' }">
          <MenuItem
            class="flex flex-row items-center justify-start  hover:bg-elevatedColor"
          >
            <span class="block px-4 py-3 text-sm text-white"
              ><img
                src="/img/add.svg"
                class="object-scale-down mr-4 h-7"
              />Hinzufügen</span
            >
          </MenuItem>
        </router-link>
        <router-link :to="{ name: 'Edit Product' }">
          <MenuItem
            class="flex flex-row items-center justify-start  hover:bg-elevatedColor"
          >
            <span class="block px-4 py-3 text-sm text-white"
              ><img
                src="/img/editBlockAttributes.svg"
                class="object-scale-down mr-4 h-7"
              />Bearbeiten</span
            >
          </MenuItem>
        </router-link>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Sidenav from "./Sidenav.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";

export default defineComponent({
  components: {
    Sidenav,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
  },
  data() {
    return {
      iconSrc: "/img/categoryProducts.svg",
    };
  },
});
</script>