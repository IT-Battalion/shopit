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
              class="
                absolute
                inset-0
                transition-opacity
                bg-gray-500 bg-opacity-75
              "
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
                    bg-white
                    shadow-xl
                  "
                >
                  <div
                    class="
                      flex-1
                      px-4
                      py-6
                      overflow-y-auto
                      sm:px-6
                      flex
                      items-center
                      justify-center
                    "
                  >
                    <button
                      type="button"
                      class="
                        p-2
                        -m-2
                        text-gray-400
                        hover:text-gray-500
                        bottom-5
                        absolute
                        z-10
                      "
                      @click="isOpen = false"
                    >
                      <span class="sr-only">Close panel</span>
                      <XIcon class="w-6 h-6" aria-hidden="true" />
                    </button>
                    <div
                      class="
                        overflow-auto
                        flex flex-col
                        justify-center
                        w-56
                        pl-4
                        text-black
                        sidebar
                        absolute
                        bottom-0
                      "
                    >
                      <div
                        v-for="category in categories"
                        v-bind:key="category.name"
                        class="flex flex-row my-6 ml-6 hover:text-gray-500"
                        @click="isOpen = false"
                      >
                        <span class="object-scale-down h-8 w-8 mr-4 rounded" :style="'background-color:#'+category.color"></span>
                        <router-link
                          class="my-1 text-left"
                          :to="'/#' + category.name"
                          >{{ category.name }}</router-link>
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
import { ref, defineComponent } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XIcon } from "@heroicons/vue/outline";

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
      isOpen: false,
      categories: window.config.categories,
    };
  },
  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
    setOpen(isOpen: boolean) {
      this.isOpen = isOpen;
    },
  },
});
</script>
