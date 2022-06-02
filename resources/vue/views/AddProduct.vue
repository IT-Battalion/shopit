<template>
  <div>
    <ProductProcessBar :step="selectedStep" :latest-step="latestStep" @changeStep="changeStep" />
    <form>
      <ProductGeneralForm ref="general" v-model:price="newProduct.price" v-model:name="newProduct.name" v-model:highlighted="newProduct.highlighted" v-show="selectedStep === 0" @submit="forward" />
      <ProductImages ref="images" v-model:images="newProduct.images" v-show="selectedStep === 1" />
      <CategoriesAttributes ref="attributes" v-model:category="newProduct.category" v-model:attributes="newProduct.attributes" v-show="selectedStep === 2" />
      <Description ref="description" v-model:description="newProduct.description" v-show="selectedStep === 3" />
    </form>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton/>
      <BackwardButton v-if="selectedStep !== 0" @click="backward"/>
      <ForwardButton v-if="selectedStep !== 3" @click="forward"/>
      <ButtonField v-if="selectedStep === 3" class="px-8 py-8 mx-2" @click="createProduct">
        <template v-slot:text>Erstellen</template>
        <template v-slot:icon><img src="/img/doneBlack.svg"/></template>
      </ButtonField>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import CancelButton from "../components/buttons/CancelButton.vue";
import BackwardButton from "../components/buttons/BackwardButton.vue";
import ForwardButton from "../components/buttons/ForwardButton.vue";
import {Money, NewProduct, Product} from "../types/api";
import ProductProcessBar from "../components/product_create_process/ProductProgressBar.vue";
import ProductGeneralForm from "../components/product_create_process/ProductGeneralForm.vue";
import ProductImages from "../components/product_create_process/ProductImages.vue";
import CategoriesAttributes from "../components/product_create_process/CategoriesAttributes.vue";
import Description from "../components/product_create_process/Description.vue";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {useToast} from "vue-toastification";
import ButtonField from "../components/ButtonField.vue";

export default defineComponent({
  components: {
    Description,
    CategoriesAttributes,
    BackwardButton,
    CancelButton,
    ProductProcessBar,
    ForwardButton,
    ProductGeneralForm,
    ProductImages,
    ButtonField,
  },
  setup() {
    return {
      toast: useToast(),
    };
  },
  data() {
    return {
      latestStep: 0,
      selectedStep: 0,
      newProduct: {
        name: '',
        price: '' as Money,
        highlighted: false,
        images: [],
        category: {
          id: 0,
          name: 'Loading...',
          color: '#FFFFFF',
        },
        attributes: {
          dimensions: [],
          volumes: [],
          clothing: [],
          colors: [],
        },
        description: '',
      } as NewProduct,
      steps: [] as any[],
    };
  },
  mounted() {
    this.steps = [
      this.$refs.general,
      this.$refs.images,
      this.$refs.attributes,
      this.$refs.description,
    ];
  },
  methods: {
    async validateSelectedStep(): Promise<void> {
      return (this.steps[this.selectedStep] as any).validate() as Promise<void>;
    },
    async forward() {
      this.validateSelectedStep().then(() => {
        this.selectedStep++;
        if (this.latestStep < this.selectedStep) {
          this.latestStep = this.selectedStep;
        }
      }).catch((_)=>{});
    },
    async backward() {
      if (this.selectedStep <= 0) {
        return;
      }
      this.validateSelectedStep().then(() => {
        this.selectedStep--;
      }).catch((_)=>{});
    },
    async changeStep(step: number) {
      if (step >= 0 && step <= this.latestStep + 1) {
        this.validateSelectedStep().then(() => {
          this.selectedStep = step;
          if (this.latestStep < this.selectedStep) {
            this.latestStep = this.selectedStep;
          }
        }).catch((_)=>{});
      }
    },
    async createProduct() {
      console.log(this.newProduct);
      initLoad();
      try {
        let product = await this.$http.post<NewProduct, AxiosResponse<Product>>(
          "/admin/product",
          this.newProduct
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
