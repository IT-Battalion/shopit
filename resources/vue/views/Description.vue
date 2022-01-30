<template>
  <div>
    <AddProductProcessBar/>
    <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
      Produktbeschreibung
    </h2>
    <div class="m-10 bg-white">
      <QuillEditor theme="snow" toolbar="essential" ref="desc"/>
    </div>
    <div class="flex flex-row gap-x-2">
      <div class="flex justify-end mt-10 sm:mr-20">
        <CancelButton/>
        <BackwardButton @click="backward"/>
      </div>
      <ButtonField class="mt-auto mb-2" @click="createProduct">
        <template v-slot:icon><img src="/img/doneBlack.svg" /></template>
      </ButtonField>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";
import {QuillEditor} from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import ButtonField from "../components/ButtonField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {Product, ProductCreateProcessStorage,} from "../types/api";
import {isUndefined} from "lodash";
import {useToast} from "vue-toastification";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";

export default defineComponent({
  components: {
    AddProductProcessBar,
    QuillEditor,
    ButtonField,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: Object as ProductCreateProcessStorage,
      toast: useToast(),
    };
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
        (this.$refs.desc as typeof QuillEditor).setContents(this.productCreateStorage.description ?? ""); //https://en.wikipedia.org/wiki/Operational_transformation
      }
    },
    async saveToLocalStorage() {
      this.productCreateStorage.description = (this.$refs.desc as typeof QuillEditor).getContents(); //https://en.wikipedia.org/wiki/Operational_transformation
      window.localStorage.setItem('product', JSON.stringify(this.productCreateStorage));
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: 'Add Product attributes'});
    },
    async clearLocalStorage() {
      window.localStorage.removeItem('product');
    },
    async createProduct() {
      initLoad();
      await this.saveToLocalStorage();
      try {
        let product = await this.$http.post<ProductCreateProcessStorage, AxiosResponse<Product>>(
          '/admin/product',
          this.productCreateStorage
        );
        this.toast.success('Produkt wurde erfolgreich erstellt.');
        console.log(product);
      } catch (e) {
        this.toast.error('Fehler beim erstellen des Produktes');
        throw e;
      }
      endLoad();
    }
  },
});
</script>
