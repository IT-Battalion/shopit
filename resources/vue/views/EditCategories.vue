<template>
  <div class="grid justify-center h-full">
    <div
      class="
        flex flex-col
        justify-center
        w-full
        mx-auto
        my-auto
        text-white
        justify-items-center
        bg-backgroundColor
      "
    >
      <h1 class="mb-10 text-4xl font-bold text-center text-white">
        Kategorien
      </h1>
      <div
        v-for="category in categories"
        :key="category.name"
        :name="category.name"
        class="my-6 ml-6 rounded-full"
      >
        <div class="grid items-center grid-cols-2 grid-rows-1 my-1 text-left">
          <div class="w-full max-w-sm px-4 top-16">
            <Popover v-slot="{ open }" class="relative">
              <PopoverButton
                :class="open ? '' : 'text-opacity-90'"
                class="
                  inline-flex
                  items-center
                  px-3
                  py-2
                  text-base
                  font-medium
                  text-white
                  rounded-md
                  group
                  hover:text-opacity-100
                  focus:outline-none
                  focus-visible:ring-2
                  focus-visible:ring-white
                  focus-visible:ring-opacity-75
                "
              >
                <span>{{ category.name }}</span>
                <ChevronDownIcon
                  :class="open ? '' : 'text-opacity-70'"
                  class="
                    w-5
                    h-5
                    ml-2
                    text-gray-400
                    transition
                    duration-150
                    ease-in-out
                    group-hover:text-opacity-80
                  "
                  aria-hidden="true"
                />
              </PopoverButton>

              <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="translate-y-1 opacity-0"
              >
                <PopoverPanel
                  class="
                    absolute
                    z-10
                    max-w-sm
                    px-4
                    mt-3
                    transform
                    -translate-x-1/2
                    left-full
                    sm:px-0
                    lg:max-w-3xl
                    flex flex-row
                  "
                >
                  <input
                    type="text"
                    :placeholder="category.name"
                    class="bg-elevatedDark rounded-2xl"
                  />
                  <button class="ml-5 w-8 h-8 my-auto">
                    <img src="/img/check.svg" alt="check" class="w-8 h-8" />
                  </button>
                </PopoverPanel>
              </transition>
            </Popover>
          </div>
          <button class="mx-5">
            <img src="/img/bin.svg" alt="delete" class="w-8 h-8" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";
import {endLoad, initLoad} from "../loader";

export default defineComponent({
  components: {Popover, PopoverButton, PopoverPanel, ChevronDownIcon},
  data() {
    return {
      categories: window.config.categories,
    };
  },
  methods: {
    async editCategory() {
      initLoad();
      await this.$http.put('/admin/category/edit'); //TODO implement correct way of api resource
      endLoad();
    },
    async deleteCategory() {
      initLoad();
      await this.$http.delete('/admin/category/');
      endLoad();
    },
    async createCategory() {
      initLoad();
      await this.$http.post('/admin/category');
      endLoad();
    },
  },
});
</script>
