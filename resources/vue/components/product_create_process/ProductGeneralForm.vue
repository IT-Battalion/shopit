<template>
  <div class="flex flex-col w-full mb-16 items-center">
    <h2 class="w-full mt-16 mb-8 text-3xl font-bold text-center text-white">Preis & Titel</h2>
    <form class="flex flex-col items-start" @submit.prevent="$emit('submit')">
      <InputField
        :errorMessage="errorName"
        :minlength="3"
        labelName="Produktname"
        :value="name"
        @update:value="value => {$emit('update:name', value.trim()); this.errorName = '';}"
      />
      <InputField
        :errorMessage="errorPrice"
        :min="1"
        labelName="Preis"
        type="text"
        :value="price"
        @update:value="value => {$emit('update:price', value.trim()); this.errorPrice = '';}"
      >
        <template v-slot:unit>{{ currency }}</template>
      </InputField>
    </form>
    <div class="flex flex-row my-5">
      <input
        id="highlighted"
        v-model="localHighlighted"
        class="my-5"
        name="highlighted"
        type="checkbox"
      />
      <label class="my-auto ml-2 text-center text-white" for="highlighted">
        Produkt hervorheben
      </label>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType} from "@vue/runtime-core";
import {Money} from "../../types/api";
import InputField from "../InputField.vue";

export default defineComponent({
  name: "ProductGeneralForm",
  components: {
    InputField,
  },
  props: {
    name: {
      type: String,
      required: true,
    },
    price: {
      type: String as PropType<Money>,
      required: true,
    },
    highlighted: {
      type: Boolean,
      required: true,
    },
  },
  emits: ['update:name', 'update:price', 'update:highlighted', 'submit'],
  setup() {
    return {
      currency: window.config.currency,
    };
  },
  data() {
    return {
      localHighlighted: this.highlighted,
      errorName: "",
      errorPrice: "",
    };
  },
  methods: {
    ready(): boolean {
      let ready = true;
      if (!this.name || this.name.trim().length <= 0) {
        ready = false;
        this.errorName = "erforderlich";
      }
      if (!this.price || this.price.trim().length <= 0) {
        ready = false;
        this.errorPrice = "erforderlich";
      }
      return ready;
    },
    async validate() {
      return this.ready() ? Promise.resolve() : Promise.reject();
    },
  },
  watch: {
    highlighted(val: boolean) {
      this.localHighlighted = val;
    },
    localHighlighted(val: boolean) {
      this.$emit('update:highlighted', val);
    },
  }
});
</script>

<style scoped>

</style>
