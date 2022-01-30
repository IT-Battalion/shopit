<template>
  <div>
    <slot></slot>
    <TransitionRoot as="template" :show="isOpen">
      <Dialog
        as="div"
        class="fixed inset-0 z-30 overflow-hidden"
        @close="isOpen = false"
      >
        <div class="absolute inset-0 overflow-hidden">
          <TransitionChild
            as="template"
            enter="ease-in-out duration-500"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="ease-in-out duration-500"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <DialogOverlay
              class="absolute inset-0 transition-opacity bg-black bg-opacity-80"
            />
          </TransitionChild>

          <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-500 sm:duration-700"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-500 sm:duration-700"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <div class="w-screen max-w-md">
                <div class="flex flex-col h-full bg-backgroundColor shadow-xl">
                  <div class="flex-1 px-4 py-6 overflow-y-auto sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-white">
                        Einkaufswagen
                      </DialogTitle>
                      <div class="flex items-center ml-3 h-7">
                        <button
                          type="button"
                          class="p-2 -m-2 text-gray-200 hover:text-gray-400"
                          @click="isOpen = false"
                        >
                          <span class="sr-only">Close panel</span>
                          <XIcon class="w-6 h-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>

                    <div class="mt-8 flow-root">
                      <ul role="list" class="-my-6" ref="entryList">
                        <template v-if="!shoppingCartData.changingProducts">
                          <li
                            v-for="(entry, index) in shoppingCartData.shoppingCart.products"
                            :key="entry.product.id"
                            class="flex py-10"
                          >
                            <ShoppingcartItem
                              :shopping-cart-entry="entry"
                              :index="index"
                              @linkClick="this.isOpen = false"
                            />
                          </li>
                        </template>
                        <template v-else>
                          <li v-for="index in 3" :key="index" class="flex py-6">
                            <div
                              class="
                                flex-shrink-0
                                w-24
                                h-28
                                overflow-hidden
                                rounded-md
                              "
                            >
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
                    </div>
                  </div>

                  <div class="px-4 py-6 border-t border-elevatedDark sm:px-6">
                    <div
                      class="
                        flex
                        justify-between
                        my-2
                        text-base text-gray-200
                        font-base
                      "
                    >
                      <p>Zwischensumme (Netto)</p>
                      <p v-if="!shoppingCartData.isLoading">{{ shoppingCartData.shoppingCart.subtotal }}</p>
                      <Skeletor
                        :pill="true"
                        class="w-1/4"
                        height="1rem"
                        v-else
                      />
                    </div>
                    <div
                      class="
                        flex
                        justify-between
                        my-2
                        text-base text-gray-200
                        font-base
                      "
                      v-if="shoppingCartData.shoppingCart.discount !== '0,-€'"
                    >
                      <p>Rabatt (Coupon)</p>
                      <p v-if="!shoppingCartData.isLoading">-{{ shoppingCartData.shoppingCart.discount }}</p>
                      <Skeletor
                        :pill="true"
                        class="w-1/4"
                        height="1rem"
                        v-else
                      />
                    </div>
                    <div
                      class="
                        flex
                        justify-between
                        my-2
                        text-base text-gray-200
                        font-base
                      "
                    >
                      <p>USt</p>
                      <p v-if="!shoppingCartData.isLoading">{{ shoppingCartData.shoppingCart.tax }}</p>
                      <Skeletor
                        :pill="true"
                        class="w-1/4"
                        height="1rem"
                        v-else
                      />
                    </div>
                    <div
                      class="
                        flex
                        justify-between
                        my-2
                        text-base
                        font-medium
                        text-white
                      "
                    >
                      <p>Gesamt</p>
                      <p v-if="!shoppingCartData.isLoading">{{ shoppingCartData.shoppingCart.total }}</p>
                      <Skeletor
                        :pill="true"
                        class="w-1/4"
                        height="1rem"
                        v-else
                      />
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                      Coupon Codes werden im nächsten Schritt angegeben.
                    </p>
                    <div class="mt-6">
                      <router-link
                        :to="{ name: 'Create Order' }"
                        class="
                          flex
                          items-center
                          justify-center
                          px-6
                          py-3
                          text-base
                          font-medium
                          text-white
                          bg-indigo-600
                          border border-transparent
                          rounded-md
                          shadow-sm
                          hover:bg-indigo-700
                        "
                      >
                        Bestellen
                      </router-link>
                    </div>
                    <div
                      class="
                        flex
                        justify-center
                        mt-6
                        text-sm text-center text-gray-500
                      "
                    >
                      <p>
                        oder
                        <button
                          type="button"
                          class="
                            font-medium
                            text-indigo-600
                            hover:text-indigo-500
                          "
                          @click="isOpen = false"
                        >
                          weiter einkaufen<span aria-hidden="true">
                            &rarr;</span
                          >
                        </button>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XIcon } from "@heroicons/vue/outline";
import { AddToShoppingCartMessage, RemoveFromShoppingCartMessage } from "../types/api";
import ShoppingcartItem from "./ShoppingcartItem.vue";
import useUser from "../stores/user";
import {addToCart, loadCart, removeProductFromCart, updatePrices, useShoppingCart} from "../stores/shoppingCart";
import {useToast} from "vue-toastification";

export default defineComponent({
  components: {
    ShoppingcartItem,
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XIcon,
  },
  data() {
    const {user} = useUser();
    return {
      isOpen: false,
      shoppingCartData: useShoppingCart(),
      scrollBeforeLoad: { top: 0, left: 0 },
      user,
    };
  },
  async beforeMount() {
    this.$globalBus.on('shopping-cart.open', this.open);
    this.$globalBus.on('shopping-cart.close', this.close);
    this.$globalBus.on('shopping-cart.toggle', this.toggle);
    this.$globalBus.on('shopping-cart.set-open', this.setOpen);

    this.$echo.private(`app.user.${this.user.id}.shopping-cart`)
      .listen('ProductAddedToShoppingCartEvent', async (message: AddToShoppingCartMessage) => {
        await addToCart(async () => {
          return {
            product: message.product,
            count: message.count,
            selectedAttributes: message.selected_attributes,
            productPrice: message.price,
          };
        });
        useToast().info('Ein Produkt wurde dem Einkaufswagen hinzugefügt.');
        updatePrices(message.subtotal, message.discount, message.tax, message.total);
      })
      .listen('ProductRemovedFromShoppingCartEvent', async (message: RemoveFromShoppingCartMessage) => {
        console.log(message);
        await removeProductFromCart(async () => {
          return {
            product: message.product,
            selectedAttributes: message.selected_attributes,
          }
        });
        useToast().info('Ein Produkt wurde aus dem Einkaufswagen entfernt.');
        updatePrices(message.subtotal, message.discount, message.tax, message.total);
      });
  },
  async created() {
    await loadCart();
  },
  async unmounted() {
    this.$globalBus.off('shopping-cart.open', this.open);
    this.$globalBus.off('shopping-cart.close', this.close);
    this.$globalBus.off('shopping-cart.toggle', this.toggle);
    this.$globalBus.off('shopping-cart.set-open', this.setOpen);

    this.$echo.leave(`app.user.${this.user.id}.shopping-cart`);
  },
  methods: {
    open() {
      this.isOpen = true;
    },
    close() {
      this.isOpen = false;
    },
    toggle() {
      this.isOpen = !this.isOpen;
    },
    setOpen(isOpen: boolean) {
      this.isOpen = isOpen;
    },
  },
  watch: {
    $route(_a, _b) {
      this.isOpen = false;
    },
  },
});
</script>
