<template>
  <template v-if="!isSkeletor">
    <div
      class="w-full overflow-hidden rounded-md  bg-backgroundColor min-h-80 aspect-w-1 group-hover:backgroundOpacity-80 aspect-h-1 lg:h-80 lg:aspect-none"
    >
      <router-link :to="{ name: 'Product', params: { name: product?.name } }">
        <LoadingImage
          :src="'/product-image/' + product?.thumbnail.id"
          :alt="product?.name"
          class="object-cover object-center w-full h-full lg:w-full lg:h-full"
          @imageFinished="imageLoaded()"
        />
      </router-link>
    </div>
    <div class="grid grid-cols-2 grid-rows-2 justify-items-start">
      <h3 class="col-span-1 mt-2 text-lg text-white">
        <a>
          {{ product?.name }}
        </a>
      </h3>
      <p class="col-span-1 my-auto text-base font-medium text-gray-300">
        {{ product?.price }}
      </p>
      <router-link :to="{ name: 'Product', params: { name: product?.name } }">
        <button
          class="w-20 h-10 col-span-1 col-start-2 py-1 my-auto bg-white  row-span-full rounded-3xl hover:bg-gray-300 justify-self-end"
          type="button"
        >
          <svg
            fill="#000"
            version="1.1"
            viewBox="0 0 100 100"
            xmlns="http://www.w3.org/2000/svg"
            class="object-scale-down h-8 mx-auto"
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
      </router-link>
    </div>
  </template>
  <template v-else>
    <div
      class="w-full overflow-hidden rounded-md  bg-backgroundColor min-h-80 group-hover:backgroundOpacity-80 aspect-h-1 h-80 lg:aspect-none"
    >
      <Skeletor :pill="false" as="div" height="100%" />
    </div>
    <div class="grid grid-cols-2 grid-rows-2 justify-items-start">
      <h3 class="w-full col-span-1 mt-2 text-lg text-white">
        <Skeletor :pill="true" />
      </h3>
      <p class="w-full col-span-1 my-auto text-base font-medium text-gray-300">
        <Skeletor :pill="true" />
      </p>
      <button
        class="w-20 h-10 col-span-1 col-start-2 py-1 my-auto bg-white  row-span-full rounded-3xl hover:bg-gray-300 justify-self-end"
        type="button"
      >
        <svg
          fill="#000"
          version="1.1"
          viewBox="0 0 100 100"
          xmlns="http://www.w3.org/2000/svg"
          class="object-scale-down h-8 mx-auto"
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
    </div>
  </template>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Product } from "../types/api";
import LoadingImage from "./LoadingImage.vue";

export default defineComponent({
  components: { LoadingImage },
  props: {
    product: Object as () => Product,
    isLoading: Boolean,
    isSkeletor: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["imageLoaded"],
  methods: {
    imageLoaded() {
      this.$emit("imageLoaded");
    },
  },
});
</script>
