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
              class="absolute inset-0 transition-opacity bg-gray-500 bg-opacity-75 "
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
                <div
                  class="flex flex-col h-full bg-white shadow-xl "
                >
                  <div class="flex-1 px-4 py-6 overflow-y-auto sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-gray-900">
                        Shopping cart
                      </DialogTitle>
                      <div class="flex items-center ml-3 h-7">
                        <button
                          type="button"
                          class="p-2 -m-2 text-gray-400 hover:text-gray-500"
                          @click="isOpen = false"
                        >
                          <span class="sr-only">Close panel</span>
                          <XIcon class="w-6 h-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>

                    <div class="mt-8">
                      <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                          <template v-if="!this.isMetadataLoading">
                            <li
                              v-for="entry in shoppingCart.products"
                              :key="entry.product.id"
                              class="flex py-6"
                              v-show="!this.isLoading"
                            >
                              <div
                                class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md"
                              >
                                <img
                                  :src="
                                    '/product-image/' + entry.product.thumbnail.id
                                  "
                                  :alt="entry.product.name"
                                  class="object-cover object-center w-full h-full"
                                  @load="this.imagesLoading--"
                                  @error="this.imagesLoading--"
                                  @abort="this.imagesLoading--"
                                />
                              </div>

                              <div class="flex flex-col flex-1 ml-4">
                                <div>
                                  <div
                                    class="flex justify-between text-base font-medium text-gray-900 "
                                  >
                                    <h3>
                                      <router-link
                                        :to="'/product/' + entry.product.name"
                                        @click="isOpen = false"
                                      >
                                        {{ entry.product.name }}
                                      </router-link>
                                    </h3>
                                    <p class="ml-4">
                                      {{ entry.product.price }}
                                    </p>
                                  </div>
                                  <p class="mt-1 text-sm text-gray-500">
                                    {{ entry.product.name }}
                                  </p>
                                </div>
                                <div
                                  class="flex items-end justify-between flex-1 text-sm "
                                >
                                  <p class="text-gray-500">
                                    Qty {{ entry.count }}
                                  </p>

                                  <div class="flex">
                                    <button
                                      type="button"
                                      class="font-medium text-indigo-600  hover:text-indigo-500"
                                    >
                                      Remove
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <template v-if="this.areImagesLoading">
                              <li v-for="entry in shoppingCart.products"
                                :key="entry.product.id"  class="flex py-6">
                                <div
                                  class="flex-shrink-0 w-24 h-24 overflow-hidden rounded-md "
                                >
                                  <Skeletor
                                    class="object-cover object-center w-full h-full"
                                    :pill="false"
                                    :circle="false"
                                    size="100%"
                                  />
                                </div>

                                <div class="flex flex-col flex-1 ml-4">
                                  <Skeletor :pill="true" class="mb-4 mt-2" />
                                  <Skeletor :pill="true" width="80%" />
                                </div>
                              </li>
                            </template>
                          </template>
                          <template v-else>
                            <li v-for="index in 3" :key="index" class="flex py-6">
                              <div
                                class="flex-shrink-0 w-24 h-24 overflow-hidden rounded-md "
                              >
                                <Skeletor
                                  class="object-cover object-center w-full h-full"
                                  :pill="false"
                                  :circle="false"
                                  size="100%"
                                />
                              </div>

                              <div class="flex flex-col flex-1 ml-4">
                                <Skeletor :pill="true" class="mb-4 mt-2" />
                                <Skeletor :pill="true" width="80%" />
                              </div>
                            </li>
                          </template>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="px-4 py-6 border-t border-gray-200 sm:px-6">
                    <div
                      class="flex justify-between text-base font-medium text-gray-900 "
                    >
                      <p>Subtotal</p>
                      <p>$262.00</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">
                      Shipping and taxes calculated at checkout.
                    </p>
                    <div class="mt-6">
                      <router-link :to="{ name: 'order' }">
                        <a
                          href="#"
                          class="flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm  hover:bg-indigo-700"
                          >Checkout</a
                        >
                      </router-link>
                    </div>
                    <div
                      class="flex justify-center mt-6 text-sm text-center text-gray-500 "
                    >
                      <p>
                        or
                        <button
                          type="button"
                          class="font-medium text-indigo-600  hover:text-indigo-500"
                          @click="isOpen = false"
                        >
                          Continue Shopping<span aria-hidden="true">
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
import { defineComponent, computed } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XIcon } from "@heroicons/vue/outline";
import { AxiosResponse } from "axios";
import { ShoppingCart } from "../types/api";
import {endLoad, initLoad, initProgress, state} from "../loader";

export default defineComponent({
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XIcon,
  },
  data() {
    return {
      isMetadataLoading: true,
      imagesLoading: -1,
      areImagesLoading: computed(() => (this.imagesLoading as any) > 0),
      isLoading: computed(() => this.isMetadataLoading || this.areImagesLoading),
      isOpen: false,
      shoppingCart: {} as ShoppingCart,
    };
  },
  async created() {
    let response: AxiosResponse<ShoppingCart> = await this.$http.get(
      "/user/shopping-cart"
    );
    this.shoppingCart = response.data;
    this.imagesLoading = this.shoppingCart.products.length;
    this.isMetadataLoading = false;
  },
  methods: {
    toggleOpen() {
      this.isOpen = !this.isOpen;
    },
    setOpen(isOpen: boolean) {
      this.isOpen = isOpen;
    },
  },
});
</script>
