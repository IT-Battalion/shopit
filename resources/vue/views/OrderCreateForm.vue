<template>
  <h2 class="w-full my-16 text-3xl font-bold text-center text-white">
    Bestellübersicht
  </h2>
  <div class="w-full md:w-1/2">
    <ul role="list" class="-my-6">
      <template v-if="!shoppingCartData.changingProducts">
        <li
          v-for="(entry, index) in shoppingCartData.shoppingCart.products"
          :key="entry.product.id"
          class="flex px-8 py-10 my-12 sm:bg-elevatedDark rounded-3xl"
        >
          <ShoppingcartItem :shopping-cart-entry="entry" :index="index" />
        </li>
      </template>
      <template v-else>
        <li v-for="index in 3" :key="index" class="flex px-8 py-10 my-12 sm:bg-elevatedDark rounded-3xl">
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
    <div class="px-14 px-10 py-6 mt-5 sm:bg-elevatedDark rounded-3xl">
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>Zwischensumme (Netto)</p>
        <p v-if="!state.isLoading">
          {{ shoppingCartData.shoppingCart.subtotal }}
        </p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div
        class="flex justify-between my-2 text-base text-gray-200 font-base"
        v-if="shoppingCartData.shoppingCart.discount !== '0,-€'"
      >
        <p>Rabatt (Coupon)</p>
        <p v-if="!state.isLoading">
          -{{ shoppingCartData.shoppingCart.discount }}
        </p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>USt</p>
        <p v-if="!state.isLoading">{{ shoppingCartData.shoppingCart.tax }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base font-medium text-white">
        <p>Gesamt</p>
        <p v-if="!state.isLoading">{{ shoppingCartData.shoppingCart.total }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex flex-col my-12 space-y-2">
        <label for="coupon" class="font-medium text-gray-200 select-none"
          >Coupon Code</label
        >
        <form
          class="flex flex-row items-center"
          @submit.prevent="applied ? resetCoupon() : addCoupon()"
        >
          <input
            id="coupon"
            type="text"
            v-model="shoppingCartData.shoppingCart.coupon"
            :readonly="applied"
            :disabled="shoppingCartData.isLoading"
            :class="
              state.isLoading
                ? 'border-gray-300 text-gray-400 bg-elevatedDark cursor-not-allowed'
                : applied
                ? 'border-emerald-300 text-emerald-400 bg-elevatedDark cursor-not-allowed'
                : 'border-indigo-500 text-white bg-elevatedDark border focus:ring-2 focus:ring-elevatedDark'
            "
            class="w-full px-4 py-2 ml-0 placeholder-green-600 border rounded-lg  focus:outline-none focus:ring-2 focus:ring-indigo-200"
          />
          <button
            class="w-8 h-8 ml-3"
            v-show="!applied && !state.isLoading"
            title="Coupon Code verifizieren"
          >
            <img
              src="/img/done.svg"
              alt="Coupon Code verifizieren"
              class="w-8 h-8"
              type="submit"
            />
          </button>
          <Spinner
            class="w-6 h-6 m-1 ml-4"
            color="#fff"
            :loading="state.isLoading"
          />
          <button
            class="w-6 h-6 my-1 ml-5"
            v-show="applied && !state.isLoading"
            title="Coupon Code entfernen"
          >
            <img
              src="/img/X.svg"
              alt="Coupon Code entfernen"
              class="w-4 h-4"
              type="submit"
            />
          </button>
        </form>
      </div>
      <div class="flex flex-row items-center justify-center my-3">
        <input
          type="checkbox"
          name="agb"
          id="agb"
          class="checked:bg-highlighted"
          v-model="agb"
        />
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
          class="flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-transparent rounded-md shadow-sm "
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
import ShoppingcartItem from "../components/ShoppingcartItem.vue";
import { Order, ShoppingCartPrices } from "../types/api";
import { AxiosResponse } from "axios";
import { useRouter } from "vue-router";
import { endLoad, initLoad, state } from "../loader";
import { useToast } from "vue-toastification";
import Spinner from "@/components/Spinner.vue";
import {
  loadCart,
  shoppingCartData,
  updatePrices,
} from "../stores/shoppingCart";

export default defineComponent({
  components: {
    ShoppingcartItem,
    Spinner,
  },
  data() {
    return {
      shoppingCartData,
      state,
      agb: false,
      applied: false,
    };
  },
  async mounted() {
    await this.loadCart();
  },
  methods: {
    async loadCart() {
      initLoad();
      await loadCart();
      this.applied = this.shoppingCartData.shoppingCart.coupon.length !== 0;
      endLoad();
    },
    async addCoupon() {
      if (this.shoppingCartData.changingCoupon) return;

      this.shoppingCartData.changingCoupon = true;
      initLoad();

      try {
        let response: AxiosResponse<ShoppingCartPrices> = await this.$http.post(
          "/user/shopping-cart/coupon",
          {
            code: this.shoppingCartData.shoppingCart.coupon,
          }
        );
        let data = response.data;

        updatePrices(data.subtotal, data.discount, data.tax, data.total);
        this.toast.success("Der Coupon Code wurde erfolgreich hinzugefügt!");

        this.applied = true;
      } catch (e: any) {
        let handled = false;

        if ("response" in e) {
          if (e.response.status === 404) {
            this.toast.error(
              "Der angegebene Coupon Code konnte nicht gefunden werden!"
            );
            handled = true;
          }
        }

        if (!handled) {
          this.toast.error(e.errorMessage);
        }
      }
      this.shoppingCartData.changingCoupon = false;
      endLoad();
    },
    async resetCoupon() {
      if (this.shoppingCartData.changingCoupon) return;

      this.shoppingCartData.changingCoupon = true;
      initLoad();

      try {
        let response: AxiosResponse<ShoppingCartPrices> = await this.$http.post(
          "/user/shopping-cart/coupon/reset"
        );
        let data = response.data;

        updatePrices(data.subtotal, data.discount, data.tax, data.total);
        this.toast.warning("Der Coupon Code wurde entfernt!");
        this.applied = false;

        this.$globalBus.emit("shopping-cart.update-prices", data);
      } catch (e: any) {
        this.toast.error(e);
      }
      this.$globalBus.emit("shopping-cart.end-load");
      endLoad();
      this.shoppingCartData.changingCoupon = false;
    },
    async order() {
      let response: AxiosResponse<Order> = await this.$http.post(
        "/user/orders"
      );
      await this.router.replace({
        name: "Order Detail",
        params: { id: response.data.id },
      });
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
