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
import {ProductCategory, ProductCreateProcessStorage} from "../types/api";
import CancelButton from "../components/buttons/CancelButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import {isUndefined} from "lodash";
import {endLoad, initLoad} from "../loader";

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
      value: [] as string[],
      optionsClothing: clothingSizeLabels,
      categories: [] as ProductCategory[],
      selectedCategory: Object as unknown as ProductCategory,
      productCreateStorage: Object as ProductCreateProcessStorage,
    };
  },
  async beforeMount() {
    await this.loadCategories();
    if (isUndefined(this.selectedCategory)) this.selectedCategory = this.categories[0];
  },
  async mounted() {
    let data = window.localStorage.getItem('product');
    if (!isUndefined(data) && data != null && data != 'undefined') {
      this.productCreateStorage = JSON.parse(data);
    }
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      if (!isUndefined(this.productCreateStorage)) {
        let category = this.productCreateStorage.category;
        if (!isUndefined(category)) {
          this.selectedCategory = category;
        }
        if (!isUndefined(this.productCreateStorage.attributes)) {
          if (!isUndefined(this.productCreateStorage.attributes.dimension)) {
            this.dimensionEnabled = this.productCreateStorage.attributes.dimension.enabled ?? false;
            let dim = this.productCreateStorage.attributes.dimension.value;
            if (!isUndefined(dim)) {
              (this.$refs.product_dimension_width as typeof InputField).setValue(dim.width ?? "");
              (this.$refs.product_dimension_height as typeof InputField).setValue(dim.height ?? "");
              (this.$refs.product_dimension_depth as typeof InputField).setValue(dim.depth ?? "");
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.volume)) {
            this.volumeEnabled = this.productCreateStorage.attributes.volume.enabled ?? false;
            if (!isUndefined(this.productCreateStorage.attributes.volume.value)) {
              (this.$refs.product_volume as typeof InputField).setValue(this.productCreateStorage.attributes.volume.value.volume ?? "");
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.color)) {
            this.colorEnabled = this.productCreateStorage.attributes.color.enabled ?? false;
            if (!isUndefined(this.productCreateStorage.attributes.color.value)) {
              if (!isUndefined(this.productCreateStorage.attributes.color.value.color)) {
                (this.$refs.product_color as typeof ColorPicker).setSelectedName(this.productCreateStorage.attributes.color.value.color.selectedName ?? "");
                (this.$refs.product_color as typeof ColorPicker).selectedColor = this.productCreateStorage.attributes.color.value.color.selectedColor ?? "";
                (this.$refs.product_color as typeof ColorPicker).colors = this.productCreateStorage.attributes.color.value.color.colors;
              }
            }
          }
          if (!isUndefined(this.productCreateStorage.attributes.clothing)) {
            this.colothingEnabled = this.productCreateStorage.attributes.clothing.enabled ?? false;
            let val = this.productCreateStorage.attributes.clothing.value;
            if (!isUndefined(val)) {
              if (!isUndefined(val.size)) {
                this.value = val.size;
              }
            }
          }
        }
      }
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
      this.productCreateStorage.category = this.selectedCategory; //id,name
      if (isUndefined(this.productCreateStorage.attributes)) this.productCreateStorage.attributes = {};
      if (isUndefined(this.productCreateStorage.attributes.clothing)) this.productCreateStorage.attributes.clothing = {};
      if (isUndefined(this.productCreateStorage.attributes.clothing.value)) this.productCreateStorage.attributes.clothing.value = {};
      if (isUndefined(this.productCreateStorage.attributes.color)) this.productCreateStorage.attributes.color = {};
      if (isUndefined(this.productCreateStorage.attributes.color.value)) this.productCreateStorage.attributes.color.value = {};
      if (isUndefined(this.productCreateStorage.attributes.color.value.color)) this.productCreateStorage.attributes.color.value.color = {};
      if (isUndefined(this.productCreateStorage.attributes.volume)) this.productCreateStorage.attributes.volume = {};
      if (isUndefined(this.productCreateStorage.attributes.volume.value)) this.productCreateStorage.attributes.volume.value = {};
      if (isUndefined(this.productCreateStorage.attributes.dimension)) this.productCreateStorage.attributes.dimension = {};
      if (isUndefined(this.productCreateStorage.attributes.dimension.value)) this.productCreateStorage.attributes.dimension.value = {};
      this.productCreateStorage.attributes.clothing.enabled = this.colothingEnabled ?? false;
      this.productCreateStorage.attributes.clothing.value.size = this.value;
      this.productCreateStorage.attributes.volume.enabled = this.volumeEnabled ?? false;
      this.productCreateStorage.attributes.volume.value.volume = (this.$refs.product_volume as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.color.enabled = this.colorEnabled ?? false;
      this.productCreateStorage.attributes.color.value.color.colors = (this.$refs.product_color as typeof ColorPicker).colors;
      this.productCreateStorage.attributes.color.value.color.selectedColor = (this.$refs.product_color as typeof ColorPicker).selectedColor;
      this.productCreateStorage.attributes.color.value.color.selectedName = (this.$refs.product_color as typeof ColorPicker).getSelectedName();
      this.productCreateStorage.attributes.dimension.enabled = this.dimensionEnabled;
      this.productCreateStorage.attributes.dimension.value.width = (this.$refs.product_dimension_width as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.dimension.value.height = (this.$refs.product_dimension_height as typeof InputField).getValue() ?? "";
      this.productCreateStorage.attributes.dimension.value.depth = (this.$refs.product_dimension_depth as typeof InputField).getValue() ?? "";
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));
      await this.$router.push({name: 'Add Product description'});
    },
    async loadCategories() {
      initLoad();
      let response: AxiosResponse<ProductCategory[]> = await this.$http.get(
        '/admin/category'
      );
      this.categories = response.data;
      endLoad();
    },
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
