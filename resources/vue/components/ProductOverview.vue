<template>
  <div class="w-5/6 h-full">
    <div>
      <swiper
        :navigation="true"
        :pagination="{
          dynamicBullets: true,
        }"
        v-show="!state.isLoading"
        class="w-full h-full"
      >
        <swiper-slide
          class="object-cover w-full h-full"
          v-for="image in product.images"
          :key="image.id"
        >
          <LoadingImage
            :src="'/product-image/' + image.id"
            :alt="'productimage'"
            class="object-contain w-full"
            imgClass="max-h-[60vh]"
            loadingClass="mx-auto md:w-1/2 rounded-3xl"
            height="60vh"
            @imageFinished="state.progressCurrent++"
          />
        </swiper-slide>
      </swiper>
      <Skeletor
        :pill="false"
        as="div"
        height="60vh"
        class="object-contain w-full mx-auto md:w-1/2 rounded-3xl"
        v-if="state.isLoading"
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
            class="text-2xl font-extrabold tracking-tight text-white  sm:text-3xl"
            v-if="!state.isLoading"
          >
            {{ product.name }}
          </h1>
          <div v-else class="h-10">
            <Skeletor :pill="true" />
          </div>
        </div>

        <!-- Options -->
        <div class="mt-4 lg:mt-0 lg:row-span-3">
          <p class="text-3xl text-white" v-if="!state.isLoading">
            {{ product.price }}
          </p>
          <div class="text-3xl" v-else>
            <Skeletor :pill="true" />
          </div>

          <form class="mt-10">
            <AttributeSelector
              v-if="!state.isLoading"
              :productattributes="product.attributes"
              ref="selectedAttributes"
            />

            <InputField labelName="Anzahl" value="1" ref="amount" type="number" v-if="!state.isLoading" />

            <button
              class="flex items-center justify-center w-full px-8 py-3 mt-10 text-base font-medium text-gray-900 bg-white  row-span-full rounded-3xl hover:bg-gray-300"
              type="button"
              @click="addProduct"
            >
              <a class="pr-2">Add to Bag</a>
              <svg
                fill="#000"
                version="1.1"
                viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg"
                class="object-scale-down h-8"
              >
                <g>
                  <path
                    d="m48.359 42.656c-0.09375-0.89062-0.15625-1.7969-0.15625-2.7188s0.046875-1.8438 0.15625-2.75h-25.078l-2.125-8.0625c-0.3125-1.2031-1.4062-2.0312-2.6406-2.0312h-9.5312c-1.5156 0-2.7344 1.2188-2.7344 2.7344s1.2188 2.7344 2.7344 2.7344h7.4219l2.125 8.0625s0 0.015625 0.015625 0.015625l6.6406 25.609c0.3125 1.2031 1.4062 2.0312 2.6562 2.0312h0.32812c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h6.5c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h0.32812c1.25 0 2.3438-0.82812 2.6562-2.0312l0.28125-1.1094c-2.6562-0.375-5.1719-1.1875-7.4844-2.3281-7.7031-3.75-13.219-11.281-14.156-20.156zm-9.0156 28.812c0 1.7344-1.4062 3.1562-3.1562 3.1562-1.7344 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4219-3.1719 3.1562-3.1719 1.75 0 3.1562 1.4219 3.1562 3.1719zm22.516 0c0 1.7344-1.4219 3.1562-3.1562 3.1562-1.75 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4062-3.1719 3.1562-3.1719 1.7344 0 3.1562 1.4219 3.1562 3.1719z"
                  />
                  <path
                    d="m73.703 19.906c-11.047 0-20.031 9-20.031 20.047s8.9844 20.031 20.031 20.031c11.062 0 20.031-8.9844 20.031-20.031 0-11.062-8.9688-20.047-20.031-20.047zm5.9531 22.766h-3.2188v3.2188c0 1.5-1.2188 2.7344-2.7344 2.7344-1.5 0-2.7344-1.2344-2.7344-2.7344v-3.2188h-3.2031c-1.5156 0-2.7344-1.2344-2.7344-2.7344 0-1.5156 1.2188-2.7344 2.7344-2.7344h3.2031v-3.2188c0-1.5156 1.2344-2.7344 2.7344-2.7344 1.5156 0 2.7344 1.2188 2.7344 2.7344v3.2188h3.2188c1.5156 0 2.7344 1.2188 2.7344 2.7344-0.015625 1.5-1.2188 2.7344-2.7344 2.7344z"
                  />
                </g>
              </svg>
            </button>
          </form>
        </div>

        <div
          class="py-10  lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8"
        >
          <!-- Description and details -->
          <div>
            <div class="space-y-6">
              <p class="text-base text-white" v-if="!state.isLoading">
                {{ product.description }}
              </p>
              <div v-else>
                <div class="w-2/3">
                  <Skeletor :pill="true" />
                </div>
                <div class="w-1/3">
                  <Skeletor :pill="true" />
                </div>
                <div class="w-1/2">
                  <Skeletor :pill="true" />
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
import {Product, ShoppingCartDescriptor,} from "../types/api";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {defineComponent} from "@vue/runtime-core";
import {Swiper, SwiperSlide} from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import SwiperCore, {Navigation, Pagination} from "swiper";
import {endLoad, initLoad, initProgress, state} from "../loader";
import LoadingImage from "./LoadingImage.vue";
import AttributeSelector from "./AttributeSelector.vue";
import InputField from "./InputField.vue";
import {AttributeType} from "../types/api-values";

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
  },
  data() {
    return {
      state: state,
      product: Object as any as Product,
    };
  },
  async beforeMount() {
    const route = useRoute();
    const name = route.params.name as string;

    await this.loadProduct(name);
  },
  methods: {
    async loadProduct(name: string) {
      initLoad();
      let response: AxiosResponse<Product> = await this.$http.get(
        "/product/" + name
      );

      this.product = response.data;
      console.log(this.product.attributes);
      initProgress(this.product.images.length);
      endLoad();
    },
    async addProduct() {
      let selectedAttributes = (
        this.$refs.selectedAttributes as typeof AttributeSelector
      ).getSelected();

      Object.keys(AttributeType)
        .filter((type) => selectedAttributes[type])
        .forEach(type => {
        selectedAttributes[type] = {
          id: selectedAttributes[type].id,
          type: selectedAttributes[type].type,
        };
      });

      let entry: ShoppingCartDescriptor = {
        name: this.product.name,
        selected_attributes: selectedAttributes,
        count: (this.$refs.amount as typeof InputField).getValue(),
      };

      try {
        let response = await this.$http.post('/user/shopping-cart/add', entry);
        this.$globalBus.emit('shopping-cart.add');
        console.log(response);
      } catch (e) {
        console.log(e);
      }
    },
  },
  watch: {
    $route(to: RouteLocationNormalizedLoaded, from) {
      if (to.path.startsWith("/product/")) {
        this.loadProduct(to.params.name as string);
      }
    },
  },
});
</script>
