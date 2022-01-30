<template>
  <div>
    <AddProductProcessBar />
    <div class="grid w-full grid-cols-1 grid-rows-2 my-16 place-items-center">
      <InputField
        labelName="Produktname"
        ref="product_name"
        :errorMessage="errorTitle"
      />
      <InputField
        labelName="Preis"
        type="number"
        ref="product_price"
        :errorMessage="errorPrice"
      />
      <div class="flex flex-row my-5">
        <input
          type="checkbox"
          name="highlighted"
          id="highlighted"
          class="my-5"
          ref="highlighted"
        />
        <label for="highlighted" class="my-auto ml-2 text-center text-white">
          Produkt hervorheben.
        </label>
      </div>
    </div>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton />
      <ForwardButton @click="forward" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import InputField from "../components/InputField.vue";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import { ProductCreateProcessStorage } from "../types/api";
import { isUndefined } from "lodash";
import AddProductProcessBar from "../components/product_create_process/AddProductProcessBar.vue";

export default defineComponent({
  components: {
    BackwardButton,
    CancelButton,
    AddProductProcessBar,
    ForwardButton,
    InputField,
  },
  data() {
    return {
      productCreateStorage: Object as ProductCreateProcessStorage,
      errorTitle: "",
      errorPrice: "",
    };
  },
  async mounted() {
    let data = window.localStorage.getItem("product");
    if (!isUndefined(data) && data != null && data != "undefined") {
      this.productCreateStorage = JSON.parse(data);
    } else {
      this.productCreateStorage = {};
    }
    await this.insertStoredData();
  },
  methods: {
    async insertStoredData() {
      if (!isUndefined(this.productCreateStorage)) {
        (this.$refs.highlighted as HTMLInputElement).checked = Boolean(
          this.productCreateStorage.highlighted ?? false
        );
        (this.$refs.product_name as typeof InputField).setValue(
          this.productCreateStorage.title ?? ""
        );
        (this.$refs.product_price as typeof InputField).setValue(
          this.productCreateStorage.price ?? ""
        );
      }
    },
    async forward() {
      this.errorTitle = "";
      this.errorPrice = "";
      if (
        (this.$refs.product_name as typeof InputField).getValue() &&
        (this.$refs.product_price as typeof InputField).getValue()
      ) {
        await this.saveToLocalStorage();
        await this.$router.push({ name: "Add Product images" });
      } else {
        if (!(this.$refs.product_name as typeof InputField).getValue())
          this.errorTitle = "Produkttitel ist erforderlich!";
        if (!(this.$refs.product_price as typeof InputField).getValue())
          this.errorPrice = "Produktpreis ist erforderlich!";
      }
    },
    async saveToLocalStorage() {
      this.productCreateStorage.highlighted = (
        this.$refs.highlighted as HTMLInputElement
      ).checked;
      this.productCreateStorage.title = (
        this.$refs.product_name as typeof InputField
      ).getValue();
      this.productCreateStorage.price = (
        this.$refs.product_price as typeof InputField
      ).getValue();
      window.localStorage.setItem(
        "product",
        JSON.stringify(this.productCreateStorage)
      );
    },
  },
});
</script>
