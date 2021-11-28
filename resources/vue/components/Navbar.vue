<template>
  <nav>
    <div
      class="flex items-center justify-between invisible w-screen px-12 py-4 mx-auto  mb-14 md:visible bg-backgroundColor bg-opacity-90"
    >
      <div class="inline-flex items-center text-2xl font-semibold text-white">
        <img src="img/logo.svg" class="w-16 mr-4" alt="logo-img" />
        <span>ShopIT</span>
      </div>
      <div>
        <ul class="flex text-white">
          <li class="flex flex-row items-center justify-center px-2 py-1 ml-5">
            <img
              src="https://avatars.dicebear.com/api/micah/:Max Musterman.svg"
              class="object-scale-down h-12 mr-4 bg-gray-800 rounded-full"
            /><Menu as="div" class="relative inline-block text-left">
              <div>
                <MenuButton
                  class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white rounded-md shadow-sm  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                >
                  Max Musterman
                  <img
                    src="img/dropdown.svg"
                    alt=""
                    class="object-scale-down ml-4 h-7"
                  />
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
                  class="absolute right-0 w-40 mt-2 origin-top-right rounded-md shadow-lg  ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <div class="py-1">
                    <MenuItem
                      v-slot="{ active }"
                      class="flex flex-row items-center justify-center"
                    >
                      <a
                        href="#"
                        :class="[
                          active ? ' text-gray-400' : 'text-white',
                          'block px-4 py-2 text-sm',
                        ]"
                        @click="userStore.logout()"
                        ><img
                          src="img/logout.svg"
                          class="object-scale-down mr-4 h-7"
                        />Abmelden</a
                      >
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
          </li>
          <li class="flex flex-row items-center justify-center px-2 py-1 ml-5">
            <img
              src="img/shoppingCart.svg"
              alt=""
              class="object-scale-down h-8 mr-4"
            />
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import userStore from "../stores/user";

export default {
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
  },
  setup() {
    return { userStore };
  },
};
</script>