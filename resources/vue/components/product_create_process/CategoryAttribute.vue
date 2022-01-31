<template>
  <div>
    <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
      Kategorie
    </h2>
    <div class="z-50 w-72 top-16">
      <Listbox v-model="selected" ref="product_categories">
        <div class="relative mt-1">
          <ListboxButton
            class="relative w-full py-2 pl-3 pr-10 text-left bg-white rounded-lg shadow-md cursor-default  focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm">
            <span class="block truncate">{{ selected.name }}</span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none ">
                  <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true"/>
            </span>
          </ListboxButton>
          <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                      leave-to-class="opacity-0">
            <ListboxOptions
              class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg  max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
              <ListboxOption v-slot="{ active, selected }" v-for="category in categories" :key="category.name"
                             :value="category" as="template">
                <li
                  :class="[active ? 'text-amber-900 bg-amber-100': 'text-gray-900', 'cursor-default select-none relative py-2 pl-10 pr-4']">
                  <span :class="[selected ? 'font-medium' : 'font-normal', 'block truncate']">{{ category.name }}</span>
                  <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3  text-amber-600">
                        <CheckIcon class="w-5 h-5" aria-hidden="true"/>
                  </span>
                </li>
              </ListboxOption>
            </ListboxOptions>
          </transition>
        </div>
      </Listbox>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, SelectorIcon} from "@heroicons/vue/solid";
import {loadCategories} from "../../request";
import {ProductCategory} from "../../types/api";
import {endLoad, initLoad} from "../../loader";

export default defineComponent({
  components: {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxLabel,
    ListboxOption,
    CheckIcon,
    SelectorIcon,
  },
  data() {
    return {
      selected: {} as ProductCategory,
      temp: {} as ProductCategory,
      categories: [] as ProductCategory[],
      isLoading: true,
    }
  },
  async beforeMount() {
    initLoad();
    await loadCategories().then(value => {
      this.categories = value;
      if ((this.selected.name == undefined || this.selected.id == undefined) && (this.temp.name == undefined || this.temp.id == undefined)) {
        this.selected = this.categories[0];
      }
      this.isLoading = false;
      if (this.temp.name != undefined || this.temp.id != undefined) {
        this.selected = this.temp;
      }
    }).finally(endLoad);
  },
  methods: {
    getSelected(): ProductCategory {
      return this.selected;
    },
    setSelected(value: ProductCategory) {
      this.isLoading ? this.temp = value : this.selected = value;
    }
  },
});
</script>
