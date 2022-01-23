<template>
  <div>
    <AddProductProcess />
    <div class="grid w-full grid-cols-1 grid-rows-5 my-16 place-items-center">
      <div class="z-20 w-72 top-16">
        <Listbox v-model="selectedCategory">
          <div class="relative mt-1">
            <ListboxButton
              class="relative w-full py-2 pl-3 pr-10 text-left bg-white rounded-lg shadow-md cursor-default  focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm"
            >
              <span class="block truncate">{{ selectedCategory.name }}</span>
              <span
                class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none "
              >
                <SelectorIcon
                  class="w-5 h-5 text-gray-400"
                  aria-hidden="true"
                />
              </span>
            </ListboxButton>

            <transition
              leave-active-class="transition duration-100 ease-in"
              leave-from-class="opacity-100"
              leave-to-class="opacity-0"
            >
              <ListboxOptions
                class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg  max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
              >
                <ListboxOption
                  v-slot="{ active, selected }"
                  v-for="category in categories"
                  :key="category.name"
                  :value="category"
                  as="template"
                >
                  <li
                    :class="[
                      active ? 'text-amber-900 bg-amber-100' : 'text-gray-900',
                      'cursor-default select-none relative py-2 pl-10 pr-4',
                    ]"
                  >
                    <span
                      :class="[
                        selected ? 'font-medium' : 'font-normal',
                        'block truncate',
                      ]"
                      >{{ category.name }}</span
                    >
                    <span
                      v-if="selected"
                      class="absolute inset-y-0 left-0 flex items-center pl-3  text-amber-600"
                    >
                      <CheckIcon class="w-5 h-5" aria-hidden="true" />
                    </span>
                  </li>
                </ListboxOption>
              </ListboxOptions>
            </transition>
          </div>
        </Listbox>
      </div>
      <section class="p-10">
        <label
          for="clothingSizes"
          class="relative items-center p-4 flex-inline isolate rounded-2xl"
        >
          <input
            id="clothingSizes"
            type="checkbox"
            class="relative z-20 text-purple-600 rounded-md peer focus:ring-0"
          />
          <span class="relative z-20 ml-2">Checkbox clothingSizes</span>
          <div
            class="absolute inset-0 z-10 bg-white border  peer-checked:bg-purple-50 peer-checked:border-purple-300 rounded-2xl"
          ></div>
        </label>
      </section>
      <section class="p-10">
        <label
          for="dimensions"
          class="relative items-center p-4 flex-inline isolate rounded-2xl"
        >
          <input
            id="dimensions"
            type="checkbox"
            class="relative z-20 text-purple-600 rounded-md peer focus:ring-0"
          />
          <span class="relative z-20 ml-2">Checkbox dimensions</span>
          <div
            class="absolute inset-0 z-10 bg-white border  peer-checked:bg-purple-50 peer-checked:border-purple-300 rounded-2xl"
          ></div>
        </label>
      </section>
      <section class="p-10">
        <label
          for="volumes"
          class="relative items-center p-4 flex-inline isolate rounded-2xl"
        >
          <input
            id="volumes"
            type="checkbox"
            class="relative z-20 text-purple-600 rounded-md peer focus:ring-0"
          />
          <span class="relative z-20 ml-2">Checkbox volumes</span>
          <div
            class="absolute inset-0 z-10 bg-white border  peer-checked:bg-purple-50 peer-checked:border-purple-300 rounded-2xl"
          ></div>
        </label>
      </section>
      <section class="p-10">
        <label
          for="colors"
          class="relative items-center p-4 flex-inline isolate rounded-2xl"
        >
          <input
            id="colors"
            type="checkbox"
            class="relative z-20 text-purple-600 rounded-md peer focus:ring-0"
          />
          <span class="relative z-20 ml-2"> Text </span>
          <div
            class="absolute inset-0 z-10 bg-white border  peer-checked:bg-purple-50 peer-checked:border-purple-300 rounded-2xl"
          ></div>
        </label>
      </section>
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Add Product description' }"
      :last="{ name: 'Add Product images' }"
      :cancel="{ name: 'Admin' }"
    />
    <ColorPicker />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import { ref } from "vue";
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from "@heroicons/vue/solid";
import ColorPicker from "../components/ColorPicker.vue";

export default defineComponent({
  components: {
    AddProductProcess,
    ForwardBackwardButton,
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    CheckIcon,
    SelectorIcon,
    ColorPicker,
  },
  setup() {
    const categories = window.config.categories;
    const selectedCategory = ref(categories[0]);

    return {
      categories,
      selectedCategory,
    };
  },
});
</script>