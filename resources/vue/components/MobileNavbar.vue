<template>
  <div
    class="
      overflow-hidden
      flex
      items-center
      justify-center
      fixed
      bottom-0
      z-10
      w-screen
      h-auto
      mx-auto
    "
  >
    <div class="w-full mx-auto">
      <div class="px-5 bg-sidenavSelected shadow-lg rounded-t-2xl">
        <div class="flex">
          <router-link :to="{ name: 'Products' }" class="flex-1 group">
            <div>
              <a
                href="#"
                class="
                  flex
                  items-end
                  justify-center
                  text-center
                  mx-auto
                  px-3
                  pt-2
                  w-full
                  text-gray-400
                  group-hover:text-indigo-500
                "
              >
                <span class="block px-1 pt-1 pb-1">
                  <HomeIcon class="h-8 w-8 pt-1 mb-1 block mx-auto"></HomeIcon>
                  <span class="block text-xs pb-2">Home</span>
                  <span
                    class="block w-5 mx-auto h-1 group-hover:bg-indigo-500"
                  ></span>
                </span>
              </a>
            </div>
          </router-link>
          <Categories ref="categories" class="flex-1 group">
            <div @click="setOpenCategories(true)">
              <a
                href="#"
                class="
                  flex
                  items-end
                  justify-center
                  text-center
                  mx-auto
                  px-3
                  pt-2
                  w-full
                  text-gray-400
                  group-hover:text-indigo-500
                "
              >
                <span class="block px-1 pt-1 pb-1">
                  <CollectionIcon
                    class="h-8 w-8 pt-1 mb-1 block mx-auto"
                  ></CollectionIcon>
                  <span class="block text-xs pb-2">Kategorien</span>
                  <span
                    class="
                      block
                      w-5
                      mx-auto
                      h-1
                      group-hover:bg-indigo-500
                      rounded-full
                    "
                  ></span>
                </span>
              </a>
            </div>
          </Categories>
          <Shoppingcart ref="shoppingCart" class="flex-1 group">
            <div
              class="
                flex
                items-end
                justify-center
                text-center
                mx-auto
                px-3
                pt-2
                w-full
                text-gray-400
                group-hover:text-indigo-500
                cursor-pointer
              "
              @click="setOpen(true)"
            >
              <span class="block px-1 pt-1 pb-1">
                <ShoppingCartIcon
                  class="h-8 w-8 pt-1 mb-1 block mx-auto"
                ></ShoppingCartIcon>
                <span class="block text-xs pb-2">Korb</span>
                <span
                  class="
                    block
                    w-5
                    mx-auto
                    h-1
                    group-hover:bg-indigo-500
                    rounded-full
                  "
                ></span>
              </span>
            </div>
          </Shoppingcart>
          <router-link :to="{name: 'Profile'}" class="flex-1 group">
            <div>
              <a
                href="#"
                class="
                  flex
                  items-end
                  justify-center
                  text-center
                  mx-auto
                  px-3
                  pt-2
                  w-full
                  text-gray-400
                  group-hover:text-indigo-500
                "
              >
                <span class="block px-1 pt-1 pb-1">
                  <UserIcon class="h-8 w-8 pt-1 mb-1 block mx-auto"></UserIcon>
                  <span class="block text-xs pb-2">Profil</span>
                  <span
                    class="
                      block
                      w-5
                      mx-auto
                      h-1
                      group-hover:bg-indigo-500
                      rounded-full
                    "
                  ></span>
                </span>
              </a>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { defineComponent } from "@vue/runtime-core";
import useUser from "../stores/user";
import Shoppingcart from "./Shoppingcart.vue";
import Categories from "./Categories.vue";
import {
  HomeIcon,
  UserIcon,
  ShoppingCartIcon,
  CollectionIcon,
} from "@heroicons/vue/solid";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Shoppingcart,
    HomeIcon,
    UserIcon,
    ShoppingCartIcon,
    CollectionIcon,
    Categories,
  },
  setup() {
    const { user, logout } = useUser();
    return { user, logout };
  },
  methods: {
    setOpen(isOpen: boolean) {
      (this.$refs.shoppingCart as typeof Shoppingcart).setOpen(isOpen);
    },
    setOpenCategories(isOpen: boolean) {
      (this.$refs.categories as typeof Categories).setOpen(isOpen);
    },
  },
});
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap");
body {
  font-family: "Poppins", sans-serif;
}
.hover\:w-full:hover {
  width: 100%;
}
.group:hover .group-hover\:w-full {
  width: 100%;
}
.group:hover .group-hover\:inline-block {
  display: inline-block;
}
.group:hover .group-hover\:flex-grow {
  flex-grow: 1;
}
</style>
