<template>
  <div class="grid justify-center h-full">
    <h1 class="mb-10 text-4xl font-bold text-center text-white">Kategorien</h1>
    <div
      class="
        flex flex-row flex-wrap
        justify-center
        w-full
        mx-auto
        my-auto
        text-white
        justify-items-center
      "
      v-if="!isLoading"
    >
      <div
        v-for="category in categories"
        :key="category.name"
        :name="category.name"
        class="p-5 m-5 bg-elevatedDark rounded-2xl"
      >
        <div class="flex flex-row items-center justify-center">
          <span
            v-if="!showInput.get(category.name)"
            @click="showInput.set(category.name, true)"
            class="cursor-pointer"
            >{{ category.name }}</span
          >
          <template v-else>
            <input
              type="text"
              :placeholder="category.name"
              ref="categoryname"
              class="text-white border-0 bg-elevatedDark w-28"
            />
            <button
              class="w-8 h-8 ml-5"
              @click="
                editCategory(category.id);
                showInput.set(category.name, false);
              "
            >
              <img src="/img/check.svg" alt="check" class="w-8 h-8" />
            </button>
          </template>
          <button class="ml-5" @click="deleteCategory(category.id)">
            <img src="/img/bin.svg" alt="delete" class="w-8 h-8" />
          </button>
        </div>
      </div>
    </div>
    <div
      class="
        flex flex-row flex-wrap
        justify-center
        w-full
        mx-auto
        my-auto
        text-white
        justify-items-center
      "
      v-else
    >
      <div v-for="i in 5" :key="i" class="w-40 h-16 m-5">
        <Skeletor :pill="true" />
      </div>
    </div>
    <div class="w-full">
      <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
        Kategorie Hinzufügen
      </h2>
      <div class="flex flex-row items-center justify-center w-full gap-4">
        <InputField ref="categorynamecreate" />
        <ButtonField class="mt-8" @click="createCategory">
          <template v-slot:icon><img src="/img/addBlack.svg" /></template>
        </ButtonField>
        <DialogModal />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import { endLoad, initLoad, state } from "../loader";
import ButtonField from "../components/ButtonField.vue";
import { useToast } from "vue-toastification";
import {
  CreateCategoryRequest,
  EditCategoryRequest,
  ProductCategory,
} from "../types/api";
import { AxiosResponse } from "axios";
import InputField from "../components/InputField.vue";
import DialogModal from "../components/DialogModal.vue";

export default defineComponent({
  components: {
    Popover,
    PopoverButton,
    PopoverPanel,
    ButtonField,
    InputField,
    DialogModal,
  },
  setup() {
    return {
      toast: useToast(),
      state,
    };
  },
  data() {
    return {
      categories: [] as ProductCategory[],
      showInput: new Map<string, Boolean>(),
      isLoading: false,
    };
  },
  async beforeMount() {
    await this.loadCategories();
  },
  methods: {
    async loadCategories() {
      this.isLoading = true;
      let response: AxiosResponse<ProductCategory[]> = await this.$http.get(
        "/admin/category"
      );
      this.categories = response.data;
      this.isLoading = false;
    },
    async editCategory(catID: number) {
      initLoad();
      try {
        let name = (this.$refs.categoryname as HTMLInputElement[])[0].value;
        let category = await this.$http.put<
          EditCategoryRequest,
          AxiosResponse<ProductCategory>
        >(`/admin/category/${catID}`, {
          name,
        });
        this.categories.forEach((value, index, array) => {
          if (value.id === catID) {
            array[index] = category.data;
          }
        });
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich bearbeitet.");
      } catch (e) {
        this.toast.error("Fehler beim bearbeiten der Kategorie.");
      }
      endLoad();
    },
    async deleteCategory(catID: number) {
      initLoad();
      try {
        let response = await this.$http.delete(`/admin/category/${catID}`);
        this.categories.forEach((value, index, array) => {
          if (value.id === catID) {
            array.splice(index, 1);
          }
        });
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich gelöscht.");
      } catch (e) {
        this.toast.error("Fehler beim löschen der Kategorie.");
      }
      endLoad();
    },
    async createCategory() {
      initLoad();
      try {
        let name = (
          this.$refs.categorynamecreate as typeof InputField
        ).getValue();
        console.log(name);
        let category = await this.$http.post<
          CreateCategoryRequest,
          AxiosResponse<ProductCategory>
        >(`/admin/category/`, {
          name,
        });
        this.categories.push(category.data);
        window.config.categories = this.categories;
        this.toast.success("Die Kategorie wurde erfolgreich erstellt.");
      } catch (e) {
        this.toast.error("Fehler beim erstellen der Kategorie.");
      }
      endLoad();
    },
  },
});
</script>
