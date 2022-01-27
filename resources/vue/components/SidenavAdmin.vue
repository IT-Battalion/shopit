<template>
  <div
    class="
      fixed
      left-0
      flex flex-col
      justify-center
      w-56
      m-0
      overflow-auto
      text-white
      sidebar
      top-32
      bg-backgroundColor
    "
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
              class="
                inline-flex
                items-center
                justify-center
                w-full
                px-4
                py-2
                text-sm
                font-medium
                text-white
                shadow-sm
                focus:outline-none focus:ring-2 focus:ring-highlighted
              "
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
              class="
                absolute
                right-0
                w-40
                mt-2
                overflow-hidden
                origin-top-right
                shadow-lg
                ring-1 ring-black ring-opacity-5
                focus:outline-none
                bg-elevatedDark
              "
            >
              <router-link :to="{name:'Add Product'}">
                <MenuItem
                  class="
                    flex flex-row
                    items-center
                    justify-start
                    hover:bg-elevatedColor
                  "
                >
                  <span class="block px-4 py-3 text-sm text-white"
                    ><img
                      src="/img/add.svg"
                      class="object-scale-down mr-4 h-7"
                    />Hinzufügen</span
                  >
                </MenuItem>
              </router-link>
              <router-link :to="{name:'Edit Product'}">
                <MenuItem
                  class="
                    flex flex-row
                    items-center
                    justify-start
                    hover:bg-elevatedColor
                  "
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
        name: "Dashboard",
        routerLink: {name: "Admin"},
        icon_url: "/img/categoryDashboard.svg",
      },
      {
        name: "Rechnungen",
        routerLink: {name: "Invoices"},
        icon_url: "/img/categoryBills.svg",
      },
      {
        name: "Produkte",
        routerLink: {name:"ProductManagement"},
        icon_url: "/img/categoryProducts.svg",
      },
      {
        name: "Kategorien",
        routerLink: {name:"CategoryManagement"},
        icon_url: "/img/categoryCategories.svg",
      },
      {
        name: "Bestellungen",
        routerLink: {name:"Admin Orders"},
        icon_url: "/img/categoryOrders.svg",
      },
      {
        name: "Userverwaltung",
        routerLink: {name:"UserManagement"},
        icon_url: "/img/categoryUser.svg",
      },
      {
        name: "Coupons",
        routerLink: {name: "Coupons"},
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
