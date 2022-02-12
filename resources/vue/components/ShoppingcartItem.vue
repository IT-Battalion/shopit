<template>
  <div
    class="
      flex-shrink-0
      w-24
      h-28
      overflow-hidden
      rounded-md
    "
  >
    <router-link
      :to="{ name: 'Product', params: { name: entry.product.name } }"
      @click="clickedLink"
    >
      <LoadingImage
        :alt="entry.product.name"
        :src="'/product-image/' + entry.product.thumbnail.id"
        class="object-cover object-center w-full h-full"
      />
    </router-link>
  </div>

  <div class="flex flex-col flex-1 ml-4">
    <div>
      <div class="flex justify-between text-base font-medium text-gray-200">
        <router-link
          :to="{ name: 'Product', params: { name: entry.product.name } }"
          @click="clickedLink"
        >
          <h3>
            {{ entry.product.name }}
          </h3>
        </router-link>
        <p class="ml-4">
          {{ entry.price }}
        </p>
      </div>
      <Attributes :selected-attributes="entry.selectedAttributes"/>
    </div>
    <div class="flex items-end justify-between flex-1 text-sm">
      <p class="text-gray-200">{{ count }} Stück</p>

      <div class="flex">
        <button
          class="font-medium text-indigo-600 hover:text-indigo-500"
          type="button"
          @click="remove"
        >
          Entfernen
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {PropType} from "vue";
import {ShoppingCartDescriptor, ShoppingCartEntry,} from "../types/api";
import LoadingImage from "./LoadingImage.vue";
import Attributes from "./Attributes.vue";
import {removeFromShoppingCart} from "../request";
import {toInteger} from "lodash";
import {mapActions, mapMutations} from "vuex";

export default defineComponent({
  props: {
    shoppingCartEntry: {
      type: Object as PropType<ShoppingCartEntry>,
      required: true,
    },
    index: {
      type: Number,
      required: true,
    },
  },
  emits: ["linkClick"],
  data() {
    return {
      entry: this.shoppingCartEntry,
      count: this.shoppingCartEntry.count,
    };
  },
  methods: {
    async remove() {
      let descriptor: ShoppingCartDescriptor = {
        name: this.entry.product.name,
        selectedAttributes: this.entry.selectedAttributes,
        count: this.count,
      };
      try {
        await this.removeIndexFromCart(async () => {
          const response = await removeFromShoppingCart(
            descriptor.name,
            descriptor.count,
            descriptor.selectedAttributes
          );
          let prices = response.data;
          this.updatePrices(prices.subtotal, prices.discount, prices.tax, prices.total);
          return toInteger(this.index);
        });
      } catch (e) {
        console.error(e);
      }
    },
    clickedLink() {
      this.$emit("linkClick");
    },
    ...mapMutations([
      "updatePrices",
    ]),
    ...mapActions([
      "removeIndexFromCart",
    ]),
  },
  components: {Attributes, LoadingImage},
});
</script>
