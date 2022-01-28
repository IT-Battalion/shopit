<template>
  <template v-if="!isSkeletor">
    <div
      class="
        w-full
        overflow-hidden
        rounded-md
        bg-backgroundColor
        min-h-80
        aspect-w-1
        group-hover:backgroundOpacity-80
        aspect-h-1
        lg:h-80 lg:aspect-none
      "
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
      <h3 class="col-span-2 mt-2 text-lg text-white">
        <a>
          {{ product?.name }}
        </a>
      </h3>
      <router-link
        :to="{ name: 'Product', params: { name: product?.name } }"
        class="col-span-1 col-start-1 mt-3"
      >
        <ButtonField iconSrc="/img/editBlack.svg" />
      </router-link>
      <router-link
        :to="{ name: 'Product', params: { name: product?.name } }"
        class="col-span-1 col-start-2 justify-self-end mt-3"
      >
        <ButtonField iconSrc="/img/binBlack.svg" />
      </router-link>
    </div>
  </template>
  <template v-else>
    <div
      class="
        w-full
        overflow-hidden
        rounded-md
        bg-backgroundColor
        min-h-80
        aspect-w-1
        group-hover:backgroundOpacity-80
        aspect-h-1
        lg:h-80 lg:aspect-none
      "
    >
      <Skeletor :pill="false" as="div" height="100%" />
    </div>
    <div class="grid grid-cols-2 grid-rows-2 justify-items-start">
      <h3 class="w-full col-span-1 mt-2 text-lg text-white">
        <Skeletor :pill="true" />
      </h3>
      <Skeletor
        :pill="true"
        as="button"
        width="80%"
        height="100%"
        class="col-span-1 col-start-1 mt-3"
      />
      <Skeletor
        :pill="true"
        as="button"
        width="80%"
        height="100%"
        class="col-span-1 col-start-2 justify-self-end mt-3"
      />
    </div>
  </template>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Product } from "../types/api";
import LoadingImage from "./LoadingImage.vue";
import ButtonField from "./ButtonField.vue";

export default defineComponent({
  components: { LoadingImage, ButtonField },
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
