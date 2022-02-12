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
        <img alt="logo-img" class="w-16 mr-4" src="/img/logo.svg"/>
        <span>ShopIT</span>
      </router-link>
      <div>
        <ul class="flex text-white">
          <li class="flex flex-row items-center justify-center px-2 py-1 ml-5">
            <Menu as="div" class="relative inline-block text-left">
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
                  focus:outline-none focus:ring-2 focus:ring-highlighted
                "
              >
                <img
                  :src="profilePicture"
                  class="object-scale-down h-12 mr-4 bg-gray-800 rounded-full"
                />
                {{ name }}
                <img
                  alt=""
                  class="object-scale-down ml-4 h-7"
                  src="/img/dropdown.svg"
                />
              </MenuButton>

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
                    bg-elevatedDark
                    overflow-hidden
                  "
                >
                  <router-link :to="{ name: 'Profile' }">
                    <MenuItem
                      class="
                        flex flex-row
                        items-center
                        justify-start
                        hover:bg-elevatedColor
                      "
                    >
                      <span class="text-white block px-5 py-4 text-sm"
                      ><img
                        class="object-scale-down mr-4 h-7"
                        src="/img/profile.svg"
                      />Profil</span
                      >
                    </MenuItem>
                  </router-link>
                  <router-link
                    v-if="this.isAdmin"
                    :to="{ name: 'Admin' }"
                  >
                    <MenuItem
                      class="
                        flex flex-row
                        items-center
                        justify-start
                        hover:bg-elevatedColor
                      "
                    >
                      <span class="text-white block px-5 py-4 text-sm"
                      ><img
                        class="object-scale-down mr-4 h-7"
                        src="/img/wheel-chair.svg"
                      />Admin Panel</span
                      >
                    </MenuItem>
                  </router-link>
                  <MenuItem
                    class="
                      flex flex-row
                      items-center
                      justify-start
                      hover:bg-elevatedColor
                    "
                  >
                    <span
                      class="text-white block px-5 py-4 text-sm cursor-pointer"
                      @click="logout"
                    ><img
                      class="object-scale-down mr-3 ml-1 h-7"
                      src="/img/logout.svg"
                    />Abmelden</span
                    >
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </li>
          <li class="flex flex-row items-center justify-center px-2 py-1 ml-5">
            <img
              alt=""
              class="object-scale-down h-8 mr-4 cursor-pointer"
              src="/img/shoppingCart.svg"
              @click="setShoppingCart(true)"
            />
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {defineComponent} from "@vue/runtime-core";
import {mapActions, mapGetters} from "vuex";

export default defineComponent({
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
  },
  computed: {
    profilePicture() {
      return `https://avatars.dicebear.com/api/micah/${
        this.$store.state.userState.user?.username
      }.svg`;
    },
    isAdmin() {
      return this.$store.state.userState.user?.isAdmin;
    },
    ...mapGetters([
      "name",
    ]),
  },
  methods: {
    setShoppingCart(isOpen: boolean) {
      this.$globalBus.emit("shopping-cart.set-open", isOpen);
    },
    ...mapActions([
      "logout",
    ]),
  },
});
</script>
