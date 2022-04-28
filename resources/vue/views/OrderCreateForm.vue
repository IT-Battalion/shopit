<template>
  <h2 class="w-full my-16 text-3xl font-bold text-center text-white">
    Bestellübersicht
  </h2>
  <div class="w-full md:w-1/2">
    <ul role="list">
      <template v-if="!changingProducts">
        <li
          v-for="(entry, index) in products"
          :key="entry.product.id"
          class="flex px-6 py-10 my-12 sm:bg-elevatedDark rounded-3xl"
        >
          <ShoppingcartItem :index="index" :shopping-cart-entry="entry"/>
        </li>
      </template>
      <template v-else>
        <li
          v-for="index in 3"
          :key="index"
          class="flex px-6 py-10 my-12 sm:bg-elevatedDark rounded-3xl"
        >
          <div class="flex-shrink-0 w-24 overflow-hidden rounded-md h-28">
            <Skeletor
              :circle="false"
              :pill="false"
              class="object-cover object-center w-full h-full"
              size="100%"
            />
          </div>

          <div class="flex flex-col flex-1 ml-4">
            <Skeletor :pill="true" class="mt-2 mb-4"/>
            <Skeletor :pill="true" width="80%"/>
          </div>
        </li>
      </template>
    </ul>
    <div class="py-6 mt-5 sm:px-14 sm:bg-elevatedDark rounded-3xl">
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>Zwischensumme (Netto)</p>
        <p v-if="!isLoading">
          {{ subtotal }}
        </p>
        <Skeletor v-else :pill="true" class="w-1/4" height="1rem"/>
      </div>
      <div
        v-if="discount !== '0,-€'"
        class="flex justify-between my-2 text-base text-gray-200 font-base"
      >
        <p>Rabatt (Coupon)</p>
        <p v-if="!isLoading">
          -{{ discount }}
        </p>
        <Skeletor v-else :pill="true" class="w-1/4" height="1rem"/>
      </div>
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>USt</p>
        <p v-if="!isLoading">{{ tax }}</p>
        <Skeletor v-else :pill="true" class="w-1/4" height="1rem"/>
      </div>
      <div class="flex justify-between my-2 text-base font-medium text-white">
        <p>Gesamt</p>
        <p v-if="!isLoading">{{ total }}</p>
        <Skeletor v-else :pill="true" class="w-1/4" height="1rem"/>
      </div>
      <div class="flex flex-col my-12 space-y-2">
        <label class="font-medium text-gray-200 select-none" for="coupon"
        >Coupon Code</label
        >
        <form
          class="flex flex-row items-center"
          @submit.prevent="applied ? resetCoupon() : addCoupon()"
        >
          <input
            id="coupon"
            v-model="localCoupon"
            :class="
              state.isLoading
                ? 'border-gray-300 text-gray-400 bg-elevatedDark cursor-not-allowed'
                : applied
                ? 'border-emerald-300 text-emerald-400 bg-elevatedDark cursor-not-allowed'
                : 'border-indigo-500 text-white bg-elevatedDark border focus:ring-2 focus:ring-elevatedDark'
            "
            :disabled="isLoading"
            :readonly="applied"
            class="w-full px-4 py-2 ml-0 placeholder-green-600 border rounded-lg  focus:outline-none focus:ring-2 focus:ring-indigo-200"
            type="text"
          />
          <button
            v-show="!applied && !state.isLoading"
            class="w-8 h-8 ml-3"
            title="Coupon Code verifizieren"
          >
            <img
              alt="Coupon Code verifizieren"
              class="w-8 h-8"
              src="/img/done.svg"
              type="submit"
            />
          </button>
          <Spinner
            :loading="state.isLoading"
            class="w-6 h-6 m-1 ml-4"
            color="#fff"
          />
          <button
            v-show="applied && !state.isLoading"
            class="w-6 h-6 my-1 ml-5"
            title="Coupon Code entfernen"
          >
            <img
              alt="Coupon Code entfernen"
              class="w-4 h-4"
              src="/img/X.svg"
              type="submit"
            />
          </button>
        </form>
      </div>
      <div class="flex flex-row items-center justify-center my-3">
        <input
          id="agb"
          v-model="agb"
          class="checked:bg-highlighted"
          name="agb"
          type="checkbox"
        />
        <label class="my-auto ml-2 text-center text-gray-200" for="agb">
          Hiermit bestätige ich, dass ich die geltenden
          <router-link :to="{name: 'agb'}">AGB's</router-link>
          gelesen und verstanden habe.
        </label>
      </div>
      <div class="flex justify-center mt-6">
        <button
          :class="
            agb
              ? 'bg-highlighted hover:bg-indigo-700'
              : 'cursor-not-allowed bg-slate-400'
          "
          :disabled="!agb"
          :title="!agb ? 'Sie müssen zuerst den AGB zustimmen' : ''"
          class="flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-transparent rounded-md shadow-sm "
          @click="order()"
        >
          Bestellen
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import ShoppingcartItem from "../components/ShoppingcartItem.vue";
import {ShoppingCartPrices} from "../types/api";
import {AxiosResponse} from "axios";
import {useRouter} from "vue-router";
import {endLoad, initLoad, state} from "../loader";
import {useToast} from "vue-toastification";
import Spinner from "@/components/Spinner.vue";
import {mapGetters, mapMutations} from "vuex";

export default defineComponent({
  components: {
    ShoppingcartItem,
    Spinner,
  },
  data() {
    return {
      localCoupon: "",
      state,
      agb: false,
      applied: false,
    };
  },
  computed: {
    changingProducts() {
      return this.$store.state.shoppingCartState.changingProducts;
    },
    products() {
      return this.$store.state.shoppingCartState.shoppingCart.products;
    },
    ...mapGetters([
      "isLoading",
    ]),
    subtotal() {
      return this.$store.state.shoppingCartState.shoppingCart.subtotal;
    },
    discount() {
      return this.$store.state.shoppingCartState.shoppingCart.discount;
    },
    tax() {
      return this.$store.state.shoppingCartState.shoppingCart.tax;
    },
    total() {
      return this.$store.state.shoppingCartState.shoppingCart.total;
    },
    coupon() {
      return this.$store.state.shoppingCartState.shoppingCart.coupon;
    },
  },
  async mounted() {
    await this.loadCart();
  },
  methods: {
    async addCoupon() {
      if (this.$store.state.shoppingCartState.changingCoupon) return;

      this.changeCoupon();
      initLoad();

      try {
        let response: AxiosResponse<ShoppingCartPrices> = await this.$http.post(
          "/user/shopping-cart/coupon",
          {
            code: this.localCoupon,
          }
        );
        let data = response.data;

        this.updatePrices(data);
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
      this.couponChanged();
      endLoad();
    },
    async resetCoupon() {
      if (this.$store.state.shoppingCartState.changingCoupon) return;

      this.changeCoupon();
      initLoad();

      try {
        let response: AxiosResponse<ShoppingCartPrices> = await this.$http.post(
          "/user/shopping-cart/coupon/reset"
        );
        let data = response.data;

        this.updatePrices(data);
        this.toast.warning("Der Coupon Code wurde entfernt!");
        this.applied = false;

        this.$globalBus.emit("shopping-cart.update-prices", data);
      } catch (e: any) {
        this.toast.error(e);
      }
      this.$globalBus.emit("shopping-cart.end-load");
      this.couponChanged();
      endLoad();
    },
    async order() {
      initLoad();
      try {
        let response: AxiosResponse<{ order_id: number }> = await this.$http.post(
          "/user/orders"
        );

        this.toast.success("Die Bestellung war erfolgreich");

        let navigation = this.router.replace({
          name: "Order Detail",
          params: {id: response.data.order_id},
        });

        let loadShoppingCart = this.loadCart();

        await Promise.all([navigation, loadShoppingCart]);
      } catch (e) {
        this.toast.error("Die Bestellung konnte nicht erfolgreich durchgeführt werden.");
      }
      endLoad();
    },
    async loadCart() {
      await this.$store.dispatch("loadCart");
      let coupon = this.$store.state.shoppingCartState.shoppingCart?.coupon;
      this.applied = !!coupon?.length;
      this.localCoupon = coupon || "";
    },
    ...mapMutations([
      "updatePrices",
      "changeCoupon",
      "couponChanged",
    ]),
  },
  watch: {
    coupon(value) {
      this.applied = !!value?.length;
      this.localCoupon = value || "";
    }
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
