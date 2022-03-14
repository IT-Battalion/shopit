<template>
  <div>
    <ProductProcessBar/>
    <div class="grid w-full grid-cols-1 grid-rows-2 my-16 place-items-center">
      <InputField
        ref="product_name"
        :errorMessage="errorTitle"
        :minlength="3"
        labelName="Produktname"
      />
      <InputField
        ref="product_price"
        :errorMessage="errorPrice"
        :min="1"
        labelName="Preis"
        type="number"
      />
      <div class="flex flex-row my-5">
        <input
          id="highlighted"
          ref="highlighted"
          class="my-5"
          name="highlighted"
          type="checkbox"
        />
        <label class="my-auto ml-2 text-center text-white" for="highlighted">
          Produkt hervorheben.
        </label>
      </div>
    </div>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton/>
      <ForwardButton @click="forward"/>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import InputField from "../components/InputField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {TemporaryProductCreateStorage} from "../types/api";
import ProductProcessBar from "../components/product_create_process/ProductProcessBar.vue";
import {ProductProcessCreateProcessStorage} from "../types/api-values";

export default defineComponent({
  components: {
    BackwardButton,
    CancelButton,
    ProductProcessBar,
    ForwardButton,
    InputField,
  },
  data() {
    return {
      productCreateStorage: {} as ProductProcessCreateProcessStorage as TemporaryProductCreateStorage,
      errorTitle: "",
      errorPrice: "",
      highlighted: {} as HTMLInputElement,
      title: InputField,
      price: InputField,
    };
  },
  async mounted() {
    this.highlighted = this.$refs.highlighted as HTMLInputElement;
    this.title = this.$refs.product_name as typeof InputField;
    this.price = this.$refs.product_price as typeof InputField;
    this.productCreateStorage = ProductProcessCreateProcessStorage.load();
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      this.highlighted.checked = this.productCreateStorage.highlighted;
      this.title.setValue(this.productCreateStorage.title);
      this.price.setValue(this.productCreateStorage.price);
    },
    async forward() {
      this.errorTitle = "";
      this.errorPrice = "";
      if (this.title.getValue() && this.price.getValue() && this.price.getValue() > 0) {
        await this.saveToLocalStorage();
        await this.$router.push({name: "Add Product images"});
      } else {
        if (!this.title.getValue())
          this.errorTitle = "Produkttitel ist erforderlich!";
        if (!this.price.getValue() || this.price.getValue() < 1)
          this.errorPrice = "Produktpreis ist erforderlich!";
      }
    },
    async saveToLocalStorage() {
      this.productCreateStorage.highlighted = this.highlighted.checked;
      this.productCreateStorage.title = this.title.getValue();
      this.productCreateStorage.price = this.price.getValue();
      ProductProcessCreateProcessStorage.save(this.productCreateStorage);
    },
  },
});
</script>
