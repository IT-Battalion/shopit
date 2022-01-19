<template>
  <div class="w-5/6 h-full">
    <div>
      <swiper
        :navigation="true"
        :pagination="{
          dynamicBullets: true,
        }"
        v-show="!isLoading"
        class="w-full h-full"
      >
        <template v-if="!isLoading || state.isProgressing">
          <swiper-slide
            class="object-cover w-full h-full"
            v-for="image in product.images"
            :key="image.id"
          >
            <img
              :src="'/product-image/' + image.id"
              :alt="'productimage'"
              @load="state.progressCurrent++"
              @error="state.progressCurrent++"
              class="object-contain w-full max-h-[60vh]"
            />
          </swiper-slide>
        </template>
      </swiper>
      <Skeletor
        :pill="false"
        as="div"
        height="60vh"
        class="object-contain w-full mx-auto md:w-1/2 rounded-3xl"
        v-if="isLoading"
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
            v-if="!isLoading"
          >
            {{ product.name }}
          </h1>
          <div v-else class="h-10">
            <Skeletor :pill="true" />
          </div>
        </div>

        <!-- Options -->
        <div class="mt-4 lg:mt-0 lg:row-span-3">
          <p class="text-3xl text-white" v-if="!isLoading">
            {{ product.price }}
          </p>
          <div class="text-3xl" v-else>
            <Skeletor :pill="true" />
          </div>

          <form class="mt-10">
            <!-- Colors -->
            <div v-for="attribute in product.attributes" :key="attribute">
              <div v-if="attribute.type == 3">
                <h3 class="text-sm font-medium text-white">Color</h3>

                <RadioGroup v-model="selectedColor" class="mt-4">
                  <RadioGroupLabel class="sr-only">
                    Choose a color
                  </RadioGroupLabel>
                  <div class="flex items-center space-x-3">
                    <RadioGroupOption
                      as="template"
                      v-for="color in attribute"
                      :key="color.name"
                      :value="color"
                      v-slot="{ active, checked }"
                    >
                      <div
                        :class="[
                          color.selectedClass,
                          active && checked ? 'ring ring-offset-1' : '',
                          !active && checked ? 'ring-2' : '',
                          '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none',
                        ]"
                      >
                        <RadioGroupLabel as="p" class="sr-only">
                          {{ color.name }}
                        </RadioGroupLabel>
                        <span
                          aria-hidden="true"
                          :class="[
                            color.class,
                            'h-8 w-8 border border-white border-opacity-10 rounded-full',
                          ]"
                        />
                      </div>
                    </RadioGroupOption>
                  </div>
                </RadioGroup>
              </div>

              <!-- Sizes -->
              <div class="mt-10" v-if="attribute.type == 0">
                <div class="flex items-center justify-between">
                  <h3 class="text-sm font-medium text-white">Size</h3>
                  <a
                    href="#"
                    class="text-sm font-medium text-gray-400  hover:text-gray-700"
                    >Size guide</a
                  >
                </div>

                <RadioGroup v-model="selectedSize" class="mt-4">
                  <RadioGroupLabel class="sr-only">
                    Choose a size
                  </RadioGroupLabel>
                  <div
                    class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4"
                  >
                    <RadioGroupOption
                      as="template"
                      v-for="size in attribute"
                      :key="size.name"
                      :value="size"
                      :disabled="!size.inStock"
                      v-slot="{ active, checked }"
                    >
                      <div
                        :class="[
                          size.inStock
                            ? 'shadow-sm text-gray-300 cursor-pointer'
                            : 'text-gray-900 cursor-not-allowed',
                          active ? 'ring-2 ring-white' : '',
                          'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-400 focus:outline-none sm:flex-1 sm:py-6',
                        ]"
                      >
                        <RadioGroupLabel as="p">
                          {{ size.name }}
                        </RadioGroupLabel>
                        <div
                          v-if="size.inStock"
                          :class="[
                            active ? 'border' : 'border-2',
                            checked
                              ? 'border-indigo-500'
                              : 'border-transparent',
                            'absolute -inset-px rounded-md pointer-events-none',
                          ]"
                          aria-hidden="true"
                        />
                        <div
                          v-else
                          aria-hidden="true"
                          class="absolute border-2 border-gray-200 rounded-md pointer-events-none  -inset-px"
                        >
                          <svg
                            class="absolute inset-0 w-full h-full text-gray-200 stroke-2 "
                            viewBox="0 0 100 100"
                            preserveAspectRatio="none"
                            stroke="currentColor"
                          >
                            <line
                              x1="0"
                              y1="100"
                              x2="100"
                              y2="0"
                              vector-effect="non-scaling-stroke"
                            />
                          </svg>
                        </div>
                      </div>
                    </RadioGroupOption>
                  </div>
                </RadioGroup>
              </div>
            </div>
            <button
              class="flex items-center justify-center w-full px-8 py-3 mt-10 text-base font-medium text-gray-900 bg-white  row-span-full rounded-3xl hover:bg-gray-300"
              type="button"
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
              <p class="text-base text-white" v-if="!isLoading">
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
import { AxiosResponse } from "axios";
import { ref } from "vue";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { Product } from "../types/api";
import { RouteLocationNormalizedLoaded, useRoute } from "vue-router";
import { computed } from "vue";
import { defineComponent } from "@vue/runtime-core";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import SwiperCore, { Navigation, Pagination } from "swiper";
import { initProgress, initLoad, state, endLoad } from "../loader";

SwiperCore.use([Navigation, Pagination]);

export default defineComponent({
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    Swiper,
    SwiperSlide,
  },
  data() {
    return {
      state: state,
      product: [] as any as Product,
    };
  },
  computed: {
    isLoading() {
      return (this as any).state.isLoading || (this as any).state.isProgressing;
    },
  },
  async created() {
    const route = useRoute();
    const name = route.params.name as string;

    this.loadProduct(name);
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
