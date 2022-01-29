<template>
  <div
    class="
      fixed
      left-0
      flex flex-col
      justify-center
      w-56
      m-0
      text-white
      sidebar
      top-32
      bg-backgroundColor
    "
  >
    <template
      v-for="category in categories"
      v-bind:key="category.icon_url"
      v-bind:name="category.name"
    >
      <router-link
        :to="category.routerLink"
        class="
          flex flex-row
          py-3
          ml-3
          my-3
          pl-6
          hover:bg-sidenavSelected hover:text-gray-400
          rounded-xl
        "
        v-if="category.name != 'Produkte'"
        as="div"
      >
        <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
        <span class="my-1 text-left">{{ category.name }}</span>
      </router-link>
      <Menu as="div" class="relative inline-block text-left w-full" v-else>
        <div class="w-full ml-3 my-3">
          <MenuButton
            class="
              inline-flex
              items-center
              justify-center
              text-white
              py-3
              px-6
              hover:bg-sidenavSelected hover:text-gray-400
              rounded-xl
            "
          >
            <img :src="category.icon_url" class="object-scale-down h-8 mr-4" />
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
            class="
              absolute
              right-0
              w-40
              mt-2
              overflow-hidden
              origin-top-right
              rounded-md
              shadow-lg
              ring-1 ring-black ring-opacity-5
              focus:outline-none
              bg-elevatedDark
            "
          >
            <router-link :to="{ name: 'Add Product' }">
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
            <router-link :to="{ name: 'Edit Product' }">
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
