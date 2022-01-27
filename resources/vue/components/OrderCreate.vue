<template>
  <h2 class="w-full my-16 text-3xl font-bold text-center text-white">
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
            :disabled="applied"
            :class="
              applied
                ? 'border-emerald-300 text-emerald-400 bg-slate-100 cursor-not-allowed'
                : 'border-indigo-500 text-black bg-white'
            "
            class="w-full px-4 py-2 ml-0 placeholder-green-600 border rounded-lg  focus:outline-none focus:ring-2 focus:ring-indigo-200"
            @submit="addCoupon()"
          />
          <button class="w-8 h-8 ml-3">
            <img
              v-if="!applied"
              src="/img/doneBlack.svg"
              alt="Coupon Code verifizieren"
              class="w-8 h-8"
              @click="addCoupon()"
            />
          </button>
          <button class="w-8 h-8 ml-3">
            <img
              v-if="applied"
              src="/img/blackX.svg"
              alt="Coupon Code verifizieren"
              class="w-4 h-4"
              @click="resetCoupon()"
            />
          </button>
        </div>
      </div>
      <div class="flex flex-row items-center justify-center my-3">
        <input type="checkbox" name="agb" id="agb" v-model="agb" />
        <label for="stayLogedIn" class="my-auto ml-2 text-center text-black">
          Hiermit stimme ich den AGB zu.
        </label>
      </div>
      <div class="flex justify-center mt-6">
        <button
          @click="order()"
          :disabled="!agb"
          :class="
            agb
              ? 'bg-indigo-600 hover:bg-indigo-700'
              : 'cursor-not-allowed bg-slate-400'
          "
          class="flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-transparent rounded-md shadow-sm "
        >
          Bestellen
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ShoppingcartItem from "./ShoppingcartItem.vue";
import {
  Coupon,
  Money,
  Order,
  Product,
  RemoveFromShoppingCartResponse,
  SelectedAttributes,
  ShoppingCart,
} from "../types/api";
import { AxiosResponse } from "axios";
import { convertProxyValue, objectEquals } from "../util";
import { add, isBoolean } from "lodash";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

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
      applied: false,
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
    async addCoupon() {
      let response: AxiosResponse<RemoveFromShoppingCartResponse> =
        await this.$http.post("/user/shopping-cart/coupon", {
          code: this.coupon,
        });
      let data = response.data;
      this.shoppingCart.subtotal = data.subtotal;
      this.shoppingCart.discount = data.discount;
      this.shoppingCart.tax = data.tax;
      this.shoppingCart.total = data.total;
      this.toast.success("Coupon code wurde erfolgreich eingesetzt!");
      this.applied = true;
    },
    async resetCoupon() {
      let response: AxiosResponse<RemoveFromShoppingCartResponse> =
        await this.$http.post("/user/shopping-cart/coupon/reset");
      let data = response.data;
      this.shoppingCart.subtotal = data.subtotal;
      this.shoppingCart.discount = data.discount;
      this.shoppingCart.tax = data.tax;
      this.shoppingCart.total = data.total;
      this.toast.info("Coupon code wurde zurückgesetzt");
      this.applied = false;
    },
    async order() {
      let response: AxiosResponse<Order> = await this.$http.post(
        "/user/orders"
      );
      this.router.replace({
        name: "Order Created",
        params: { id: response.data.id },
      });
    },
  },
  async mounted() {
    await this.loadCart();
  },
  setup() {
    let router = useRouter();
    const toast = useToast();
    return {
      router,
      toast,
    };
  },
});
</script>
