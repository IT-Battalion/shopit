<template>
  <div>
    <AddProductProcess/>
    <div
      class="flex flex-col items-center justify-center w-full mt-10 gap-y-10"
    >
      <div>
        <h2 class="w-full mb-5 text-2xl font-bold text-center text-white">
          Kategorie
        </h2>
        <div class="z-50 w-72 top-16">
          <Listbox v-model="selectedCategory" ref="product_categories">
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
          <InputField labelName="Weite" type="number" ref="product_dimension_width"/>
          <InputField labelName="Höhe" type="number" ref="product_dimension_height"/>
          <InputField labelName="Tiefe" type="number" ref="product_dimension_depth"/>
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
          <InputField type="number" ref="product_volume"/>
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
        <ColorPicker class="ml-5" ref="product_color"/>
      </div>
    </div>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton/>
      <BackwardButton @click="backward"/>
      <ForwardButton @click="forward"/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import AddProductProcess from "../components/AddProductProcess.vue";
import Multiselect from "@vueform/multiselect";
import {ref} from "vue";
import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Switch,} from "@headlessui/vue";
import {CheckIcon, SelectorIcon} from "@heroicons/vue/solid";
import ColorPicker from "../components/ColorPicker.vue";
import {clothingSizeLabels} from "../types/api-values";
import InputField from "../components/InputField.vue";
import ButtonField from "../components/ButtonField.vue";
import {AxiosResponse} from "axios";
import {ProductCategory} from "../types/api";
import CancelButton from "../components/buttons/CancelButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";

export default defineComponent({
  components: {
    ButtonField,
    AddProductProcess,
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
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  setup() {
    const colorEnabled = ref(false);
    const colothingEnabled = ref(false);
    const dimensionEnabled = ref(false);
    const volumeEnabled = ref(false);

    return {
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
      categories: [] as ProductCategory[],
      selectedCategory: Object as unknown as ProductCategory,
    };
  },
  async beforeMount() {
    await this.loadCategories();
  },
  async mounted() {
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      let category = window.localStorage.getItem('product.category');
      if (category != null) {
        this.selectedCategory = JSON.parse(category);
      } else {
        this.selectedCategory = this.categories[0];
      }
      this.dimensionEnabled = Boolean(window.localStorage.getItem('product.dimension'));
      this.volumeEnabled = Boolean(window.localStorage.getItem('product.volume'));
      this.colorEnabled = Boolean(window.localStorage.getItem('product.color'));
      this.colothingEnabled = Boolean(window.localStorage.getItem('product.clothing'));
      this.value = JSON.parse(window.localStorage.getItem('product.clothings') ?? '{}');
      (this.$refs.product_volume as typeof InputField).setValue(window.localStorage.getItem('product.volumes'));
      (this.$refs.product_color as typeof ColorPicker).colors = JSON.parse(window.localStorage.getItem('product.colors') ?? '{}');
      let dim = JSON.parse(window.localStorage.getItem('product.dimensions') ?? '{}');
      (this.$refs.product_dimension_width as typeof InputField).setValue(dim[0]);
      (this.$refs.product_dimension_height as typeof InputField).setValue(dim[1]);
      (this.$refs.product_dimension_depth as typeof InputField).setValue(dim[2]);
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product images'});
    },
    async forward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product description'});
    },
    async saveToLocalStorage() {
      let category = this.selectedCategory; //id, name
      window.localStorage.setItem('product.category', JSON.stringify(category));

      window.localStorage.setItem('product.clothing', String(this.colothingEnabled)) //true or false
      let clothing = this.value;
      window.localStorage.setItem('product.clothings', JSON.stringify(clothing));

      window.localStorage.setItem('product.volume', String(this.volumeEnabled)) //true or false
      let volume = (this.$refs.product_volume as typeof InputField).getValue()
      window.localStorage.setItem('product.volumes', volume);

      window.localStorage.setItem('product.dimension', String(this.dimensionEnabled)) //true or false
      let dimension = [
        (this.$refs.product_dimension_width as typeof InputField).getValue(),
        (this.$refs.product_dimension_height as typeof InputField).getValue(),
        (this.$refs.product_dimension_depth as typeof InputField).getValue()
      ];
      window.localStorage.setItem('product.dimensions', JSON.stringify(dimension));

      window.localStorage.setItem('product.color', String(this.colorEnabled)) //true or false
      let color = (this.$refs.product_color as typeof ColorPicker).colors;
      window.localStorage.setItem('product.colors', JSON.stringify(color));

      await this.$router.push({name: 'Add Product description'});
    },
    async loadCategories() {
      let response: AxiosResponse<ProductCategory[]> = await this.$http.get(
        '/admin/category'
      );
      this.categories = response.data;
    },
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
