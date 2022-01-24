<template>
  <h2 class="w-full my-16 text-2xl font-bold text-center text-white">
    Bestellübersicht
  </h2>
  <div class="w-full p-10 bg-white rounded-3xl md:w-1/2">
    <ul role="list" class="-my-6 divide-y divide-gray-200" ref="entryList">
      <template v-if="!isLoading">
        <li
          v-for="(entry, index) in shoppingCart.products"
          :key="entry.product.id"
          class="flex py-6"
        >
          <ShoppingcartItem :shopping-cart-entry="entry" :index="index" />
        </li>
      </template>
      <template v-else>
        <li v-for="index in 3" :key="index" class="flex py-6">
          <div class="flex-shrink-0 w-24 overflow-hidden rounded-md h-28">
            <Skeletor
              class="object-cover object-center w-full h-full"
              :pill="false"
              :circle="false"
              size="100%"
            />
          </div>

          <div class="flex flex-col flex-1 ml-4">
            <Skeletor :pill="true" class="mt-2 mb-4" />
            <Skeletor :pill="true" width="80%" />
          </div>
        </li>
      </template>
    </ul>
    <div class="px-4 py-6 mt-5 border-t border-gray-200 sm:px-6">
      <div class="flex justify-between my-2 text-base text-gray-900 font-base">
        <p>Zwischensumme (Netto)</p>
        <p v-if="!isLoading">{{ shoppingCart.subtotal }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div
        class="flex justify-between my-2 text-base text-gray-900 font-base"
        v-if="shoppingCart.discount !== '0,-€'"
      >
        <p>Rabatt (Coupon)</p>
        <p v-if="!isLoading">-{{ shoppingCart.discount }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base text-gray-900 font-base">
        <p>USt</p>
        <p v-if="!isLoading">{{ shoppingCart.tax }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div
        class="flex justify-between my-2 text-base font-medium text-gray-900"
      >
        <p>Gesamt</p>
        <p v-if="!isLoading">{{ shoppingCart.total }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex flex-col my-3 space-y-2">
        <label for="success" class="font-medium text-gray-700 select-none"
          >Coupon Code</label
        >
        <div class="flex flex-row items-center">
          <input
            id="coupon"
            type="text"
            v-model="coupon"
            class="w-full px-4 py-2 ml-0 text-black placeholder-green-600 border border-indigo-500 rounded-lg  focus:outline-none focus:ring-2 focus:ring-indigo-200"
          />
          <button class="w-8 h-8">
            <img
              src="/img/doneBlack.svg"
              alt="Coupon Code verifizieren"
              class="w-8 h-8 ml-3"
            />
          </button>
        </div>
      </div>
      <div class="flex flex-row items-center justify-center my-3">
        <input type="checkbox" name="agb" id="agb" v-model="agb" />
        <label for="stayLogedIn" class="my-auto ml-2 text-center text-black">
          Hiermiet stimme ich den AGB zu.
        </label>
      </div>
      <div class="mt-6">
        <router-link
          :to="{ name: 'Create Order' }"
          class="flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm  hover:bg-indigo-700"
        >
          Bestellen
        </router-link>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
// TODO: Jan Bestellen Formular erstellen
import { defineComponent } from "vue";
import ShoppingcartItem from "./ShoppingcartItem.vue";
import { Money, Product, SelectedAttributes, ShoppingCart } from "../types/api";
import { AxiosResponse } from "axios";
import { convertProxyValue, objectEquals } from "../util";
import { isBoolean } from "lodash";

export default defineComponent({
  components: {
    ShoppingcartItem,
  },
  data() {
    return {
      isLoading: true,
      shoppingCart: {} as ShoppingCart,
      coupon: "",
      agb: false,
    };
  },
  methods: {
    async loadCart() {
      this.isLoading = true;
      let response: AxiosResponse<ShoppingCart> = await this.$http.get(
        "/user/shopping-cart"
      );
      this.shoppingCart = response.data;
      this.isLoading = false;
    },
  },
  async mounted() {
    await this.loadCart();
  },
});
</script>
