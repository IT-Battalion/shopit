<template>
  <h2 class="w-full my-16 text-3xl font-bold text-center text-white">
    Bestellübersicht
  </h2>
  <div class="w-full p-10 bg-elevatedDark rounded-3xl md:w-1/2">
    <ul role="list" class="-my-6 divide-y divide-elevatedColor" ref="entryList">
      <template v-if="!state.isLoading || this.changingCoupon">
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
    <div class="px-4 py-6 mt-5 border-t border-elevatedColor sm:px-6">
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>Zwischensumme (Netto)</p>
        <p v-if="!state.isLoading">{{ shoppingCart.subtotal }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div
        class="flex justify-between my-2 text-base text-gray-200 font-base"
        v-if="shoppingCart.discount !== '0,-€'"
      >
        <p>Rabatt (Coupon)</p>
        <p v-if="!state.isLoading">-{{ shoppingCart.discount }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>USt</p>
        <p v-if="!state.isLoading">{{ shoppingCart.tax }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base font-medium text-white">
        <p>Gesamt</p>
        <p v-if="!state.isLoading">{{ shoppingCart.total }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex flex-col my-12 space-y-2">
        <label for="coupon" class="font-medium text-gray-200 select-none"
          >Coupon Code</label>
        <form class="flex flex-row items-center" @submit.prevent="applied ? resetCoupon() : addCoupon()">
          <input
            id="coupon"
            type="text"
            v-model="this.shoppingCart.coupon"
            :readonly="applied"
            :disabled="state.isLoading"
            :class="
              state.isLoading
                ? 'border-gray-300 text-gray-400 bg-slate-100 cursor-not-allowed'
              : applied
                ? 'border-emerald-300 text-emerald-400 bg-gray-700 cursor-not-allowed'
                : 'border-indigo-500 text-white bg-gray-900'
            "
            class="
              w-full
              px-4
              py-2
              ml-0
              placeholder-green-600
              border
              rounded-lg
              focus:outline-none focus:ring-2 focus:ring-indigo-200
            "
          />
          <button class="w-8 h-8 ml-3" v-show="!applied && !state.isLoading" title="Coupon Code verifizieren">
            <img
              src="/img/doneBlack.svg"
              alt="Coupon Code verifizieren"
              class="w-8 h-8"
              type="submit"
            />
          </button>
          <Spinner class="ml-4 w-6 h-6 m-1" :loading="state.isLoading" />
          <button class="ml-5 w-6 h-6 my-1" v-show="applied && !state.isLoading" title="Coupon Code entfernen">
            <img
              src="/img/blackX.svg"
              alt="Coupon Code entfernen"
              class="w-4 h-4"
              type="submit"
            />
          </button>
        </form>
      </div>
      <div class="flex flex-row items-center justify-center my-3">
        <input type="checkbox" name="agb" id="agb" class="checked:bg-highlighted" v-model="agb" />
        <label for="agb" class="my-auto ml-2 text-center text-gray-200">
          Hiermit stimme ich den AGB zu.
        </label>
      </div>
      <div class="flex justify-center mt-6">
        <button
          @click="order()"
          :disabled="!agb"
          :class="
            agb
              ? 'bg-highlighted hover:bg-indigo-700'
              : 'cursor-not-allowed bg-slate-400'
          "
          class="
            flex
            items-center
            justify-center
            px-6
            py-3
            text-base
            font-medium
            text-white
            border border-transparent
            rounded-md
            shadow-sm
          "
          :title="!agb ? 'Sie müssen zuerst den AGB zustimmen' : ''"
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
  Money,
  Order,
  ShoppingCartPrices,
  ShoppingCart,
} from "../types/api";
import { AxiosResponse } from "axios";
import { useRouter } from "vue-router";
import {endLoad, initLoad, state} from "../loader";
import { useToast } from "vue-toastification";
import Spinner from "@/components/Spinner.vue";

export default defineComponent({
  components: {
    ShoppingcartItem,
    Spinner,
  },
  data() {
    return {
      shoppingCart: {} as ShoppingCart,
      state,
      agb: false,
      applied: false,
      changingCoupon: false,
    };
  },
  async beforeMount() {
    this.$globalBus.on('shopping-cart.remove', this.removeFromCart);
    this.$globalBus.on('shopping-cart.load', this.showLoading);
    this.$globalBus.on('shopping-cart.end-load', this.endLoad);
    this.$globalBus.on('shopping-cart.update-prices', this.updatePrices);
  },
  async mounted() {
    await this.loadCart();
  },
  async unmounted() {
    this.$globalBus.off('shopping-cart.remove', this.removeFromCart);
    this.$globalBus.off('shopping-cart.load', this.showLoading);
    this.$globalBus.off('shopping-cart.end-load', this.endLoad);
    this.$globalBus.on('shopping-cart.update-prices', this.updatePrices);
  },
  methods: {
    async loadCart() {
      initLoad();
      let response: AxiosResponse<ShoppingCart> = await this.$http.get(
        "/user/shopping-cart"
      );
      this.shoppingCart = response.data;
      this.applied = this.shoppingCart.coupon.length !== 0;
      endLoad();
    },
    async addCoupon() {
      if (this.changingCoupon)
        return;

      this.changingCoupon = true;
      initLoad();
      this.$globalBus.emit('shopping-cart.load', false);

      try {
        let response: AxiosResponse<ShoppingCartPrices> =
          await this.$http.post("/user/shopping-cart/coupon", {
            code: this.shoppingCart.coupon,
          });
        let data = response.data;

        this.shoppingCart.subtotal = data.subtotal;
        this.shoppingCart.discount = data.discount;
        this.shoppingCart.tax = data.tax;
        this.shoppingCart.total = data.total;
        this.toast.success("Der Coupon Code wurde erfolgreich hinzugefügt!");

        this.$globalBus.emit("shopping-cart.update-prices", data);
        this.applied = true;
      } catch (e) {
        let handled = false;

        if ('response' in e) {
          if (e.response.status === 404) {
            this.toast.error("Der angegebene Coupon Code konnte nicht gefunden werden!");
            handled = true;
          }
        }

        if (!handled) {
          this.toast.error(e.errorMessage);
        }
      }
      this.$globalBus.emit('shopping-cart.end-load');
      endLoad();
      this.changingCoupon = false;
    },
    async resetCoupon() {
      if (this.changingCoupon)
        return;

      this.changingCoupon = true;
      initLoad();
      this.$globalBus.emit('shopping-cart.load', false);

      try {
        let response: AxiosResponse<ShoppingCartPrices> =
          await this.$http.post("/user/shopping-cart/coupon/reset");
        let data = response.data;

        this.shoppingCart.subtotal = data.subtotal;
        this.shoppingCart.discount = data.discount;
        this.shoppingCart.tax = data.tax;
        this.shoppingCart.total = data.total;

        this.toast.warning("Der Coupon Code wurde entfernt!");
        this.applied = false;

        this.$globalBus.emit("shopping-cart.update-prices", data);
      } catch (e) {
        this.toast.error(e);
      }
      this.$globalBus.emit('shopping-cart.end-load');
      endLoad();
      this.changingCoupon = false;
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
    showLoading() {
      initLoad();
    },
    async removeFromCart(index: number) {
      this.shoppingCart.products.splice(index, 1);

      endLoad();
    },
    endLoad(_?: boolean) {
      endLoad();
    },
    updatePrices(event: {
      subtotal: Money,
      discount: Money,
      tax: Money,
      total: Money}) {
      const {subtotal, discount, tax, total} = event;

      this.shoppingCart.subtotal = subtotal;
      this.shoppingCart.discount = discount;
      this.shoppingCart.tax = tax;
      this.shoppingCart.total = total;
    },
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
