<template>
  <div
    class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md "
  >
    <router-link :to="'/product/' + entry.product.name">
      <LoadingImage
        :src="'/product-image/' + entry.product.thumbnail.id"
        :alt="entry.product.name"
        class="object-cover object-center w-full h-full"
      />
    </router-link>
  </div>

  <div class="flex flex-col flex-1 ml-4">
    <div>
      <div class="flex justify-between text-base font-medium text-gray-900">
        <router-link :to="'/product/' + entry.product.name">
          <h3>
            {{ entry.product.name }}
          </h3>
        </router-link>
        <p class="ml-4">
          {{ entry.product.price }}
        </p>
      </div>
      <p class="mt-1 text-sm text-gray-500">
        {{ entry.product.name }}
      </p>
    </div>
    <div class="flex items-end justify-between flex-1 text-sm">
      <p class="text-gray-500">Qty {{ count }}</p>

      <div class="flex">
        <button
          type="button"
          class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          Entfernen
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import { PropType } from "vue";
import { ShoppingCartEntry } from "../types/api";
import LoadingImage from "./LoadingImage.vue";

export default defineComponent({
  props: {
    shoppingCartEntry: {
      type: Object as PropType<ShoppingCartEntry>,
      required: true,
    },
  },
  data() {
    return {
      entry: this.shoppingCartEntry,
      count: this.shoppingCartEntry.count,
    };
  },
  components: { LoadingImage },
});
</script>
