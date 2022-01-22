<template>
  <div class="grid justify-center h-full">
    <div
      class="flex flex-col justify-center w-full mx-auto my-auto text-white  justify-items-center bg-backgroundColor"
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
                class="inline-flex items-center px-3 py-2 text-base font-medium text-white rounded-md  group hover:text-opacity-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
              >
                <span>{{ category.name }}</span>
                <ChevronDownIcon
                  :class="open ? '' : 'text-opacity-70'"
                  class="w-5 h-5 ml-2 text-gray-400 transition duration-150 ease-in-out  group-hover:text-opacity-80"
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
                  class="absolute z-10 max-w-sm px-4 mt-3 transform -translate-x-1/2  left-full sm:px-0 lg:max-w-3xl"
                >
                  <input
                    type="text"
                    :placeholder="category.name"
                    class="bg-elevatedDark"
                  />
                </PopoverPanel>
              </transition>
            </Popover>
          </div>
          <button class="mx-5">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { ref } from "vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";

export default defineComponent({
  components: { Popover, PopoverButton, PopoverPanel, ChevronDownIcon },
  data() {
    return {
      categories: window.config.categories,
    };
  },
  setup() {
    return {
      solutions: [
        {
          name: "Insights",
          description: "Measure actions your users take",
          href: "##",
          icon: `
            <svg
              width="48"
              height="48"
              viewBox="0 0 48 48"
              fill="none"
              aria-hidden='true'
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect width="48" height="48" rx="8" fill="#FFEDD5" />
              <path
                d="M24 11L35.2583 17.5V30.5L24 37L12.7417 30.5V17.5L24 11Z"
                stroke="#FB923C"
                stroke-width="2"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M16.7417 19.8094V28.1906L24 32.3812L31.2584 28.1906V19.8094L24 15.6188L16.7417 19.8094Z"
                stroke="#FDBA74"
                stroke-width="2"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M20.7417 22.1196V25.882L24 27.7632L27.2584 25.882V22.1196L24 20.2384L20.7417 22.1196Z"
                stroke="#FDBA74"
                stroke-width="2"
              />
            </svg>
          `,
        },
        {
          name: "Automations",
          description: "Create your own targeted content",
          href: "##",
          icon: `
            <svg
              width="48"
              height="48"
              viewBox="0 0 48 48"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect width="48" height="48" rx="8" fill="#FFEDD5" />
              <path
                d="M28.0413 20L23.9998 13L19.9585 20M32.0828 27.0001L36.1242 34H28.0415M19.9585 34H11.8755L15.9171 27"
                stroke="#FB923C"
                stroke-width="2"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M18.804 30H29.1963L24.0001 21L18.804 30Z"
                stroke="#FDBA74"
                stroke-width="2"
              />
            </svg>
          `,
        },
        {
          name: "Reports",
          description: "Keep track of your growth",
          href: "##",
          icon: `
            <svg
              width="48"
              height="48"
              viewBox="0 0 48 48"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect width="48" height="48" rx="8" fill="#FFEDD5" />
              <rect x="13" y="32" width="2" height="4" fill="#FDBA74" />
              <rect x="17" y="28" width="2" height="8" fill="#FDBA74" />
              <rect x="21" y="24" width="2" height="12" fill="#FDBA74" />
              <rect x="25" y="20" width="2" height="16" fill="#FDBA74" />
              <rect x="29" y="16" width="2" height="20" fill="#FB923C" />
              <rect x="33" y="12" width="2" height="24" fill="#FB923C" />
            </svg>
          `,
        },
      ],
    };
  },
});
</script>
