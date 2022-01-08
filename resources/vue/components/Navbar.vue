<template>
  <nav>
    <div
      class="
        fixed
        top-0
        z-10
        flex
        items-center
        justify-between
        w-screen
        h-32
        px-12
        py-4
        mx-auto
        bg-backgroundColor
      "
    >
      <router-link
        :to="{ name: 'Products' }"
        class="inline-flex items-center text-2xl font-semibold text-white"
      >
        <img src="img/logo.svg" class="w-16 mr-4" alt="logo-img" />
        <span>ShopIT</span>
      </router-link>
      <div>
        <ul class="flex text-white">
          <li class="flex flex-row items-center justify-center px-2 py-1 ml-5">
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
                    rounded-md
                    shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-highlighted
                  "
                >
                  <img
                    :src="profilePicture"
                    class="object-scale-down h-12 mr-4 bg-gray-800 rounded-full"
                  />
                  {{ user.name.value }}
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
                  class="
                    absolute
                    right-0
                    w-40
                    mt-2
                    origin-top-right
                    rounded-md
                    shadow-lg
                    ring-1 ring-black ring-opacity-5
                    focus:outline-none
                  "
                >
                  <div class="py-1 bg-gray-900">
                    <router-link to="/admin">
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
                          ><img
                            src="img/profile.svg"
                            class="object-scale-down mr-7 h-7"
                          />Profilseite</a
                        >
                      </MenuItem>
                    </router-link>
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
                        @click="logout()"
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
            <Shoppingcart ref="shoppingCart">
              <img
                src="img/shoppingCart.svg"
                alt=""
                class="object-scale-down h-8 mr-4 cursor-pointer"
                @click="setOpen(true)"
              />
            </Shoppingcart>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { defineComponent } from "@vue/runtime-core";
import useUser from "../stores/user";
import Shoppingcart from "./Shoppingcart.vue";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Shoppingcart,
  },
  setup() {
    const { user, logout } = useUser();
    const profilePicture =
      "https://avatars.dicebear.com/api/micah/:" + user.username.value + ".svg";

    return { user, logout, profilePicture };
  },
  methods: {
    setOpen(isOpen: boolean) {
      (this.$refs as any).shoppingCart.setOpen(isOpen);
    },
  },
});
</script>
