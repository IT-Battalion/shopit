<template>
  <div>
    <AddProductProcess />
    <div
      class="flex flex-col items-center justify-center w-full mt-10 gap-y-10"
    >
      <div>
        <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
          Kategorie
        </h2>
        <div class="z-50 w-72 top-16">
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
                        active
                          ? 'text-amber-900 bg-amber-100'
                          : 'text-gray-900',
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
      </div>
      <div class="flex flex-row items-center justify-center w-full">
        <Switch
          v-model="dimensionEnabled"
          :class="dimensionEnabled ? 'bg-indigo-700' : 'bg-gray-300'"
          class="
            relative
            inline-flex
            flex-shrink-0
            h-[38px]
            w-[74px]
            border-2 border-transparent
            rounded-full
            cursor-pointer
            transition-colors
            ease-in-out
            duration-200
            focus:outline-none
            focus-visible:ring-2
            focus-visible:ring-white
            focus-visible:ring-opacity-75
          "
        >
          <span class="sr-only">Use setting</span>
          <span
            aria-hidden="true"
            :class="dimensionEnabled ? 'translate-x-9' : 'translate-x-0'"
            class="
              pointer-events-none
              inline-block
              h-[34px]
              w-[34px]
              rounded-full
              bg-white
              shadow-lg
              transform
              ring-0
              transition
              ease-in-out
              duration-200
            "
          />
        </Switch>
        <div
          class="flex flex-col items-center justify-center w-1/4 p-5 ml-5  rounded-2xl bg-elevatedDark"
        >
          <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
            Dimensionen
          </h2>
          <InputField labelName="Weite" type="number" />
          <InputField labelName="Höhe" type="number" />
          <InputField labelName="Tiefe" type="number" />
        </div>
      </div>
      <div class="flex flex-row items-center justify-center w-full">
        <Switch
          v-model="colothingEnabled"
          :class="colothingEnabled ? 'bg-indigo-700' : 'bg-gray-300'"
          class="
            relative
            inline-flex
            flex-shrink-0
            h-[38px]
            w-[74px]
            border-2 border-transparent
            rounded-full
            cursor-pointer
            transition-colors
            ease-in-out
            duration-200
            focus:outline-none
            focus-visible:ring-2
            focus-visible:ring-white
            focus-visible:ring-opacity-75
          "
        >
          <span class="sr-only">Use setting</span>
          <span
            aria-hidden="true"
            :class="colothingEnabled ? 'translate-x-9' : 'translate-x-0'"
            class="
              pointer-events-none
              inline-block
              h-[34px]
              w-[34px]
              rounded-full
              bg-white
              shadow-lg
              transform
              ring-0
              transition
              ease-in-out
              duration-200
            "
          />
        </Switch>
        <div class="w-1/4 p-5 ml-5 rounded-2xl bg-elevatedDark">
          <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
            Kleidungsgrößen
          </h2>
          <Multiselect
            v-model="value"
            mode="tags"
            :close-on-select="false"
            :searchable="true"
            :create-option="true"
            :options="optionsClothing"
          />
        </div>
      </div>
      <div class="flex flex-row items-center justify-center w-full">
        <Switch
          v-model="volumeEnabled"
          :class="volumeEnabled ? 'bg-indigo-700' : 'bg-gray-300'"
          class="
            relative
            inline-flex
            flex-shrink-0
            h-[38px]
            w-[74px]
            border-2 border-transparent
            rounded-full
            cursor-pointer
            transition-colors
            ease-in-out
            duration-200
            focus:outline-none
            focus-visible:ring-2
            focus-visible:ring-white
            focus-visible:ring-opacity-75
          "
        >
          <span class="sr-only">Use setting</span>
          <span
            aria-hidden="true"
            :class="volumeEnabled ? 'translate-x-9' : 'translate-x-0'"
            class="
              pointer-events-none
              inline-block
              h-[34px]
              w-[34px]
              rounded-full
              bg-white
              shadow-lg
              transform
              ring-0
              transition
              ease-in-out
              duration-200
            "
          />
        </Switch>
        <div
          class="flex flex-col items-center justify-center w-1/4 p-5 ml-5  rounded-2xl bg-elevatedDark"
        >
          <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
            Volumen
          </h2>
          <InputField type="number" />
        </div>
      </div>
      <div class="flex flex-row items-center justify-center w-full">
        <Switch
          v-model="colorEnabled"
          :class="colorEnabled ? 'bg-indigo-700' : 'bg-gray-300'"
          class="
            relative
            inline-flex
            flex-shrink-0
            h-[38px]
            w-[74px]
            border-2 border-transparent
            rounded-full
            cursor-pointer
            transition-colors
            ease-in-out
            duration-200
            focus:outline-none
            focus-visible:ring-2
            focus-visible:ring-white
            focus-visible:ring-opacity-75
          "
        >
          <span class="sr-only">Use setting</span>
          <span
            aria-hidden="true"
            :class="colorEnabled ? 'translate-x-9' : 'translate-x-0'"
            class="
              pointer-events-none
              inline-block
              h-[34px]
              w-[34px]
              rounded-full
              bg-white
              shadow-lg
              transform
              ring-0
              transition
              ease-in-out
              duration-200
            "
          />
        </Switch>
        <ColorPicker class="ml-5" />
      </div>
    </div>
    <ForwardBackwardButton
      :next="{ name: 'Add Product description' }"
      :last="{ name: 'Add Product images' }"
      :cancel="{ name: 'Admin' }"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import ForwardBackwardButton from "../components/ForwardBackwardButton.vue";
import Multiselect from "@vueform/multiselect";
import { ref } from "vue";
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
  Switch,
} from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from "@heroicons/vue/solid";
import ColorPicker from "../components/ColorPicker.vue";
import { clothingSizeLabels } from "../types/api-values";
import InputField from "../components/InputField.vue";

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
    Switch,
    Multiselect,
    InputField,
  },
  setup() {
    const categories = window.config.categories;
    const selectedCategory = ref(categories[0]);
    const colorEnabled = ref(false);
    const colothingEnabled = ref(false);
    const dimensionEnabled = ref(false);
    const volumeEnabled = ref(false);

    return {
      categories,
      selectedCategory,
      colorEnabled,
      colothingEnabled,
      dimensionEnabled,
      volumeEnabled,
    };
  },
  data() {
    return {
      value: [],
      optionsClothing: clothingSizeLabels,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>