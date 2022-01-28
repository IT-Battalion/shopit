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
                  class="absolute z-10 flex flex-row max-w-sm px-4 mt-3 transform -translate-x-1/2  left-full sm:px-0 lg:max-w-3xl"
                >
                  <input
                    type="text"
                    :placeholder="category.name"
                    :id="category.id"
                    class="bg-elevatedDark rounded-2xl"
                    ref="categoryname"
                  />
                  <button class="w-8 h-8 my-auto ml-5" @click="editCategory(category.id)">
                    <img src="/img/check.svg" alt="check" class="w-8 h-8"/>
                  </button>
                </PopoverPanel>
              </transition>
            </Popover>
          </div>
          <button class="mx-5" @click="deleteCategory(category.id)">
            <img src="/img/bin.svg" alt="delete" class="w-8 h-8"/>
          </button>
        </div>
      </div>
    </div>
    <div class="w-full">
      <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
        Kategorie Hinzufügen
      </h2>
      <div class="w-full max-w-sm px-4 top-16">
        <Popover v-slot="{ open }" class="relative">
          <PopoverButton
            :class="open ? '' : 'text-opacity-90'"
            class="inline-flex items-center px-3 py-2 ml-20 text-base font-medium text-white rounded-md  group hover:text-opacity-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
          >
            <ButtonField iconSrc="/img/addBlack.svg"/>
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
              class="absolute z-10 flex flex-row max-w-sm px-4 mt-3  sm:px-0 lg:max-w-3xl"
            >
              <input
                type="text"
                placeholder="Name"
                class="text-white bg-elevatedDark rounded-2xl" ref="categorynamecreate"
              />
              <button class="w-8 h-8 my-auto ml-5" @click="createCategory">
                <img src="/img/check.svg" alt="check" class="w-8 h-8"/>
              </button>
            </PopoverPanel>
          </transition>
        </Popover>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";
import {endLoad, initLoad} from "../loader";
import ButtonField from "../components/ButtonField.vue";
import {useToast} from "vue-toastification";
import {CreateCategoryRequest, EditCategoryRequest, ProductCategory} from "../types/api";
import {AxiosResponse} from "axios";

export default defineComponent({
  components: {
    Popover,
    PopoverButton,
    PopoverPanel,
    ChevronDownIcon,
    ButtonField,
  },
  setup() {
    return {
      toast: useToast(),
    };
  },
  data() {
    return {
      categories: [] as ProductCategory[],
    };
  },
  async beforeMount() {
    await this.loadCategories();
  },
  methods: {
    async loadCategories() {
      let response: AxiosResponse<ProductCategory[]> = await this.$http.get(
        '/admin/category'
      );
      this.categories = response.data;
    },
    async editCategory(catID: number) {
      initLoad();
      try {
        let name = (this.$refs.categoryname as HTMLInputElement[])[0].value;
        let category = await this.$http.put<EditCategoryRequest, AxiosResponse<ProductCategory>>(
          `/admin/category/${catID}`,
          {
            name,
          }
        );
        this.categories.forEach((value, index, array) => {
          if (value.id === catID) {
            array[index] = category.data;
          }
        });
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich bearbeitet.");
      } catch (e) {
        this.toast.error('Fehler beim bearbeiten der Kategorie.');
      }
      endLoad();
    },
    async deleteCategory(catID: number) {
      initLoad();
      try {
        let response = await this.$http.delete(
          `/admin/category/${catID}`
        );
        this.categories.forEach((value, index, array) => {
          if (value.id === catID) {
            array.splice(index, 1);
          }
        });
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich gelöscht.");
      } catch (e) {
        this.toast.error('Fehler beim löschen der Kategorie.');
      }
      endLoad();
    },
    async createCategory() {
      initLoad();
      try {
        let name = (this.$refs.categorynamecreate as HTMLInputElement).value;
        let category = await this.$http.post<CreateCategoryRequest, AxiosResponse<ProductCategory>>(
          `/admin/category/`,
          {
            name
          }
        );
        this.categories.push(category.data);
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich erstellt.");
      } catch (e) {
        this.toast.error('Fehler beim erstellen der Kategorie.');
      }
      endLoad();
    },
  },
});
</script>
