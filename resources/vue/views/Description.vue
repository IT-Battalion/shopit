<template>
  <div>
    <ProductProcessBar/>
    <h2 class="w-full my-10 text-2xl font-bold text-center text-white">
      Produktbeschreibung
    </h2>
    <div>
      <QuillEditor ref="desc" theme="snow" toolbar="essential"/>
    </div>
    <div class="flex mt-10 sm:mr-20">
      <CancelButton/>
      <BackwardButton @click="backward"/>
      <ButtonField class="px-6 py-4 mx-2" @click="createProduct">
        <template v-slot:text>Erstellen</template>
        <template v-slot:icon><img src="/img/doneBlack.svg"/></template>
      </ButtonField>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import ProductProcessBar from "../components/product_create_process/ProductProcessBar.vue";
import {QuillEditor} from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import ButtonField from "../components/ButtonField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {Product, TemporaryProductCreateStorage,} from "../types/api";
import {useToast} from "vue-toastification";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {ProductProcessCreateProcessStorage} from "../types/api-values";

export default defineComponent({
  components: {
    ProductProcessBar,
    QuillEditor,
    ButtonField,
    BackwardButton,
    ForwardButton,
    CancelButton,
  },
  data() {
    return {
      productCreateStorage: {} as ProductProcessCreateProcessStorage as TemporaryProductCreateStorage,
      toast: useToast(),
      quilleditor: QuillEditor,
    };
  },
  async mounted() {
    this.productCreateStorage = ProductProcessCreateProcessStorage.load();
    this.quilleditor = this.$refs.desc as typeof QuillEditor;
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      this.quilleditor.setContents(this.productCreateStorage.description); //https://en.wikipedia.org/wiki/Operational_transformation
    },
    async saveToLocalStorage() {
      this.productCreateStorage.description = this.quilleditor.getContents(); //https://en.wikipedia.org/wiki/Operational_transformation
      ProductProcessCreateProcessStorage.save(this.productCreateStorage);
    },
    async backward() {
      await this.saveToLocalStorage();
      await this.$router.push({name: "Add Product attributes"});
    },
    async clearLocalStorage() {
      window.localStorage.removeItem("product");
    },
    async createProduct() {
      initLoad();
      await this.saveToLocalStorage();
      try {
        let product = await this.$http.post<TemporaryProductCreateStorage, AxiosResponse<Product>>(
          "/admin/product",
          this.productCreateStorage
        );
        this.toast.success("Produkt wurde erfolgreich erstellt.");
        await this.$router.push({name: "Product detail", params: {name: product.data.name}});
      } catch (e) {
        this.toast.error("Fehler beim erstellen des Produktes");
      }
      endLoad();
    }
  },
});
</script>
