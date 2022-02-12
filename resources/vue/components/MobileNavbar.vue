<template>
  <div class="fixed bottom-0 z-10 w-screen h-auto mx-auto overflow-hidden">
    <div class="w-full mx-auto">
      <div class="shadow-lg sm:px-5 bg-elevatedDark rounded-t-2xl">
        <div class="grid grid-rows-1 grid-cols-4 place-items-center">
          <router-link :to="{ name: 'Products' }">
            <div>
              <a
                class="
                  flex
                  items-end
                  justify-center
                  w-full
                  px-3
                  pt-2
                  mx-auto
                  text-center text-gray-400
                  group-hover:text-indigo-500
                "
                href="#"
              >
                <span class="block px-1 pt-1 pb-1">
                  <img
                    class="block w-8 h-8 pt-1 mx-auto mb-1"
                    src="/img/homeGray.svg"
                  />
                  <span class="block pb-2 text-xs">Home</span>
                  <span
                    class="block w-5 h-1 mx-auto group-hover:bg-indigo-500"
                  ></span>
                </span>
              </a>
            </div>
          </router-link>
          <Categories ref="categories">
            <div @click="setOpenCategories(true)">
              <a
                class="
                  flex
                  items-end
                  justify-center
                  w-full
                  px-3
                  pt-2
                  mx-auto
                  text-center text-gray-400
                  group-hover:text-indigo-500
                "
                href="#"
              >
                <span class="block px-1 pt-1 pb-1">
                  <img
                    class="block w-7 h-7 pt-1 mx-auto mb-1 mt-1"
                    src="/img/categoryGray.svg"
                  />
                  <span class="block pb-2 text-xs">Kategorien</span>
                  <span
                    class="
                      block
                      w-5
                      h-1
                      mx-auto
                      rounded-full
                      group-hover:bg-indigo-500
                    "
                  ></span>
                </span>
              </a>
            </div>
          </Categories>
          <div
            class="
              flex
              items-end
              justify-center
              w-full
              px-3
              pt-2
              mx-auto
              text-center text-gray-400
              cursor-pointer
              group-hover:text-indigo-500
            "
            @click="setShoppingCart(true)"
          >
            <span class="block px-1 pt-1 pb-1">
              <img
                class="block w-8 h-8 pt-1 mx-auto mb-1"
                src="/img/shoppingCartGray.svg"
              />
              <span class="block pb-2 text-xs">Korb</span>
              <span
                class="
                  block
                  w-5
                  h-1
                  mx-auto
                  rounded-full
                  group-hover:bg-indigo-500
                "
              ></span>
            </span>
          </div>
          <router-link :to="{ name: 'Profile' }">
            <div>
              <a
                class="
                  flex
                  items-end
                  justify-center
                  w-full
                  px-3
                  pt-2
                  mx-auto
                  text-center text-gray-400
                  group-hover:text-indigo-500
                "
                href="#"
              >
                <span class="block px-1 pt-1 pb-1">
                  <img
                    class="block w-8 h-8 pt-1 mx-auto mb-1"
                    src="/img/profileGray.svg"
                  />
                  <span class="block pb-2 text-xs">Profil</span>
                  <span
                    class="
                      block
                      w-5
                      h-1
                      mx-auto
                      rounded-full
                      group-hover:bg-indigo-500
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
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {defineComponent} from "@vue/runtime-core";
import Shoppingcart from "./Shoppingcart.vue";
import Categories from "./Categories.vue";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Shoppingcart,
    Categories,
  },
  methods: {
    setShoppingCart(isOpen: boolean) {
      this.$globalBus.emit("shopping-cart.set-open", isOpen);
    },
    setOpenCategories(isOpen: boolean) {
      (this.$refs.categories as typeof Categories).setShoppingCart(isOpen);
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
