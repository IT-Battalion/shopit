<template>
  <div>
    <slot></slot>
    <TransitionRoot :show="isOpen" as="template">
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
              class="absolute inset-0 transition-opacity bg-black bg-opacity-65"
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
                  class="
                    flex flex-col
                    h-full
                    overflow-y-scroll
                    shadow-xl
                    bg-backgroundColor
                  "
                >
                  <div
                    class="
                      flex
                      items-center
                      justify-center
                      flex-1
                      px-4
                      py-6
                      overflow-y-auto
                      sm:px-6
                    "
                  >
                    <button
                      class="
                        absolute
                        z-10
                        p-2
                        -m-2
                        text-gray-400
                        hover:text-gray-500
                        bottom-5
                      "
                      type="button"
                      @click="isOpen = false"
                    >
                      <span class="sr-only">Close panel</span>
                      <img
                        aria-hidden="true"
                        class="w-6 h-6"
                        src="/img/Xgray.svg"
                      />
                    </button>
                    <div
                      class="
                        absolute
                        bottom-0
                        flex flex-col
                        justify-center
                        w-56
                        pl-4
                        overflow-auto
                        text-white
                        sidebar
                      "
                    >
                      <div
                        v-for="category in categories"
                        v-bind:key="category.name"
                        class="flex flex-row my-6 ml-6 hover:text-gray-500"
                        @click="isOpen = false"
                      >
                        <span
                          :style="'background-color:#' + category.color"
                          class="object-scale-down w-8 h-8 mr-4 rounded"
                        ></span>
                        <router-link
                          :to="'/#' + category.name"
                          class="my-1 text-left"
                        >{{ category.name }}
                        </router-link
                        >
                      </div>
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
import {defineComponent} from "vue";
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot,} from "@headlessui/vue";

export default defineComponent({
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
  },
  data() {
    return {
      isOpen: false,
      categories: window.config.categories,
    };
  },
  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
    setShoppingCart(isOpen: boolean) {
      this.isOpen = isOpen;
    },
  },
});
</script>
