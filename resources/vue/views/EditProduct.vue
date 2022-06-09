<template>
  <div>
    <ProductProcessBar :step="selectedStep" :latest-step="latestStep" @changeStep="changeStep" />
    <form v-if="!productLoading">
      <ProductGeneralForm ref="general" v-model:price="product.price" v-model:name="product.name" v-model:highlighted="product.highlighted" v-show="selectedStep === 0" @submit="forward" />
      <ProductImages ref="images" v-model:images="product.images" v-show="selectedStep === 1"/>
      <CategoriesAttributes ref="attributes" v-model:category="product.category" v-model:attributes="product.attributes" v-show="selectedStep === 2" />
      <Description ref="description" v-model:description="product.description" v-show="selectedStep === 3" />
    </form>
    <div class="flex justify-end mt-10 sm:mr-20">
      <CancelButton/>
      <BackwardButton v-if="selectedStep !== 0" @click="backward"/>
      <ForwardButton v-if="selectedStep !== 3" @click="forward"/>
      <ButtonField v-if="selectedStep === 3" class="px-8 py-8 mx-2" @click="editProduct">
        <template v-slot:text>Bearbeiten</template>
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
import {endLoad, initLoad, initProgress} from "../loader";
import {AxiosResponse} from "axios";
import {useToast} from "vue-toastification";
import ButtonField from "../components/ButtonField.vue";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {AttributeType} from "../types/api-values";
import {FilePondInitialFile} from "filepond";

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
    let route = useRoute();
    return {
      latestStep: 3,
      selectedStep: 0,
      name: route.params.name as string,
      productLoading: false,
      product: {
        id: 0,
        name: route.params.name as string,
        description: 'Loading...',
        price: 'Loading...' as Money,
        highlighted: false,
        tax: 0,
        images: [],
        thumbnail: {
          id: -1,
        },
        category: {
          id: 0,
          name: 'Loading...',
          color: '#FFFFFF',
        },
        attributes: {
          [AttributeType.DIMENSION]: [],
          [AttributeType.VOLUME]: [],
          [AttributeType.CLOTHING]: [],
          [AttributeType.COLOR]: [],
        },
      } as Product,
    };
  },
  mounted() {
    this.loadProduct(this.name);
  },
  computed: {
    steps() {
      return [
        this.$refs.general,
        this.$refs.images,
        this.$refs.attributes,
        this.$refs.description,
      ];
    },
  },
  methods: {
    async loadProduct(name: string) {
      initLoad();
      this.productLoading = true;
      let response = await this.$http.get<undefined, AxiosResponse<Product>>("/admin/product/" + name);

      this.product = response.data;
      this.product.images = this.product.images.map<FilePondInitialFile>((value: FilePondInitialFile) => {return {source: value.source, options: {type: 'local'}}});
      this.productLoading = false;
      endLoad();
    },
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
    async editProduct() {
      initLoad();
      try {
        await this.$http.put<NewProduct, AxiosResponse<Product>>(
          "/admin/product/" + this.product.name,
          this.product
        );
        this.toast.success("Produkt wurde erfolgreich erstellt.");
      } catch (e) {
        this.toast.error("Fehler beim erstellen des Produktes");
        console.error(e);
      }
      endLoad();
    }
  },
  watch: {
    $route(to: RouteLocationNormalizedLoaded, from) {
      if (to.name === "Edit Product") {
        this.loadProduct(to.params.name as string);
      }
    },
  },
});
</script>
