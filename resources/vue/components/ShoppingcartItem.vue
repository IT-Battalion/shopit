<template>
  <div
    class="
      flex-shrink-0
      w-24
      h-28
      overflow-hidden
      border border-gray-200
      rounded-md
    "
  >
    <router-link :to="{name: 'Product', params: {name: entry.product.name}}" @click="clickedLink">
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
        <router-link :to="{name: 'Product', params: {name: entry.product.name}}" @click="clickedLink">
          <h3>
            {{ entry.product.name }}
          </h3>
        </router-link>
        <p class="ml-4">
          {{ entry.price }}
        </p>
      </div>
      <Attributes
        :selected-attributes="entry.selected_attributes"
      />
    </div>
    <div class="flex items-end justify-between flex-1 text-sm">
      <p class="text-gray-500">{{ count }} Stück</p>

      <div class="flex">
        <button
          type="button"
          class="font-medium text-indigo-600 hover:text-indigo-500"
          @click="remove"
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
import {
  SelectedAttributes,
  ShoppingCartDescriptor,
  ShoppingCartEntry,
} from "../types/api";
import LoadingImage from "./LoadingImage.vue";
import Attributes from "./Attributes.vue";
import {removeFromShoppingCart} from "../request";

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
  emits: ['linkClick'],
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
        selected_attributes: this.entry.selected_attributes,
        count: this.count,
      };
      this.$globalBus.emit("shopping-cart.load");
      try {
        const response = await removeFromShoppingCart(descriptor.name, descriptor.count, descriptor.selected_attributes);
        let data = response.data;
        this.$globalBus.emit("shopping-cart.remove", {
          index: this.index,
          ...data,
        });
      } catch (e) {
        console.error(e);
      }
    },
    clickedLink() {
      this.$emit('linkClick');
    }
  },
  components: { Attributes, LoadingImage },
});
</script>
