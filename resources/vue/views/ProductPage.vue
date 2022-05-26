<template>
  <div class="w-5/6 h-full">
    <div>
      <swiper
        v-show="!state.isLoading"
        :navigation="true"
        :pagination="{
          dynamicBullets: true,
        }"
        class="w-full h-full"
      >
        <swiper-slide
          v-for="image in product.images"
          :key="image.id"
          class="object-cover w-full h-full"
        >
          <LoadingImage
            :alt="'productimage'"
            :src="'/product-image/' + image.id"
            class="object-contain w-full"
            height="60vh"
            imgClass="max-h-[60vh]"
            loadingClass="mx-auto md:w-1/2 rounded-3xl"
            @imageFinished="state.progressCurrent++"
          />
        </swiper-slide>
      </swiper>
      <Skeletor
        v-if="state.isLoading"
        :pill="false"
        as="div"
        class="object-contain w-full mx-auto md:w-1/2 rounded-3xl"
        height="60vh"
      />

      <!-- Product info -->
      <div
        class="
          max-w-2xl
          mx-auto
          pt-10
          pb-16
          px-4
          sm:px-6
          lg:max-w-7xl
          lg:pt-16
          lg:pb-24
          lg:px-8
          lg:grid
          lg:grid-cols-3
          lg:grid-rows-[auto,auto,1fr]
          lg:gap-x-8
        "
      >
        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
          <h1
            v-if="!state.isLoading"
            class="
              text-2xl
              font-extrabold
              tracking-tight
              text-white
              sm:text-3xl
            "
          >
            {{ product.name }}
          </h1>
          <div v-else class="h-10">
            <Skeletor :pill="true"/>
          </div>
        </div>

        <!-- Options -->
        <div class="mt-4 lg:mt-0 lg:row-span-3">
          <p v-if="!state.isLoading" class="text-3xl text-white">
            {{ product.price }}
          </p>
          <div v-else class="text-3xl">
            <Skeletor :pill="true"/>
          </div>

          <form class="mt-10">
            <AttributeSelector
              v-if="!state.isLoading"
              ref="selectedAttributes"
              :productAttributes="product.attributes"
            />

            <InputField
              v-if="!state.isLoading"
              ref="amount"
              labelName="Anzahl"
              type="number"
              value="1"
            />
            <ButtonField
              v-if="!state.isLoading"
              :loading="buttonLoading"
              class="mt-10 row-span-full"
              @click="addProduct"
            >
              <template v-slot:text><span>Hinzufügen</span></template>
              <template v-slot:icon><img src="/img/addToShoppingCart.svg"/></template>
            </ButtonField>
            <div v-else class="text-3xl w-1/2">
              <Skeletor :pill="true"/>
            </div>
          </form>
        </div>

        <div
          class="
            py-10
            lg:pt-6
            lg:pb-16
            lg:col-start-1
            lg:col-span-2
            lg:border-r
            lg:border-gray-200
            lg:pr-8
          "
        >
          <!-- Description and details -->
          <div>
            <div class="space-y-6">
              <v-md-preview :text="product.description" v-if="!state.isLoading" class="text-base text-white"/>
              <div v-else>
                <div class="w-2/3">
                  <Skeletor :pill="true"/>
                </div>
                <div class="w-1/3">
                  <Skeletor :pill="true"/>
                </div>
                <div class="w-1/2">
                  <Skeletor :pill="true"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {AxiosResponse} from "axios";
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from "@headlessui/vue";
import {Product, SelectedAttributes, ShoppingCartEntry} from "../types/api";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {defineComponent} from "@vue/runtime-core";
import {Swiper, SwiperSlide} from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import SwiperCore, {Navigation, Pagination} from "swiper";
import {endLoad, initLoad, initProgress, state} from "../loader";
import LoadingImage from "../components/LoadingImage.vue";
import AttributeSelector from "../components/AttributeSelector.vue";
import InputField from "../components/InputField.vue";
import {AttributeType} from "../types/api-values";
import {addToShoppingCart} from "../request";
import {cloneDeep, pick} from "lodash";
import ButtonField from "../components/ButtonField.vue";
import {mapActions, mapMutations} from "vuex";

SwiperCore.use([Navigation, Pagination]);

export default defineComponent({
  components: {
    LoadingImage,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    Swiper,
    SwiperSlide,
    AttributeSelector,
    InputField,
    ButtonField,
  },
  async created() {
    const route = useRoute();
    const name = route.params.name as string;
    await this.loadProduct(name);
  },
  data() {
    return {
      state,
      product: {attributes: {}} as Product, // if attributes aren't given before the AttributeSelector component loads
                                            // its type check for the productAttributes prop will fail
      buttonLoading: false,
    };
  },
  methods: {
    async loadProduct(name: string) {
      initLoad();
      let response: AxiosResponse<Product> = await this.$http.get(
        "/product/" + name
      );

      this.product = response.data;
      initProgress(this.product.images.length);
      endLoad();
    },
    async addProduct() {
      this.buttonLoading = true;
      let selectedAttributes: SelectedAttributes = (
        this.$refs.selectedAttributes as typeof AttributeSelector
      ).getSelected();
      let attributes: SelectedAttributes = cloneDeep(selectedAttributes);

      Object.keys(AttributeType)
        .filter((type) => (attributes as any)[type])
        .forEach((type) => {
          (attributes as any)[type] = {
            id: (attributes as any)[type].id,
            type: (attributes as any)[type].type,
          };
        });

      const count = (this.$refs.amount as typeof InputField).getValue();

      try {
        await this.addToCart(async () => {
          this.$globalBus.emit("shopping-cart.open");

          const response = await addToShoppingCart(
            this.product.name,
            count,
            attributes
          );
          const data = response.data;

          this.updatePrices(pick(data, ["subtotal", "discount", "tax", "total"]));
          this.buttonLoading = false;
          return {
            product: cloneDeep(this.product),
            count: data.count,
            selectedAttributes: cloneDeep(selectedAttributes),
            price: data.price,
          } as ShoppingCartEntry;
        });
      } catch (e) {
        console.log(e);
      }
    },
    ...mapMutations([
      "updatePrices",
    ]),
    ...mapActions([
      "addToCart",
    ]),
  },
  watch: {
    $route(to: RouteLocationNormalizedLoaded, from) {
      if (to.name === "Product") {
        this.loadProduct(to.params.name as string);
      }
    },
  },
});
</script>
