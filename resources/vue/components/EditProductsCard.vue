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
    <div class="flex flex-col justify-items-start">
      <h3 class="mt-2 text-lg text-white">
        <router-link :to="{ name: 'Product', params: { name: product?.name } }">
          {{ product?.name }}
        </router-link>
      </h3>
      <div class="mt-3 flex justify-between w-full">
        <router-link :to="{name: 'Edit Product', params: {name: product?.name}}">
          <ButtonField :loading="isLoading">
            <template v-slot:icon><img src="/img/editBlack.svg" /></template>
          </ButtonField>
        </router-link>
        <ButtonField :loading="isLoading || deleteLoading" @click="this.delete">
          <template v-slot:icon><img src="/img/binBlack.svg" /></template>
        </ButtonField>
      </div>
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
import {defineComponent, PropType} from "vue";
import {NewProduct, Product} from "../types/api";
import LoadingImage from "./LoadingImage.vue";
import ButtonField from "./ButtonField.vue";
import {AxiosResponse} from "axios";
import {useToast} from "vue-toastification";
import {endLoad, initLoad} from "../loader";

export default defineComponent({
  components: { LoadingImage, ButtonField },
  props: {
    product: Object as PropType<Product>,
    isLoading: Boolean,
    isSkeletor: {
      type: Boolean,
      default: false,
    },
  },
  setup() {
    return {
      toast: useToast(),
    };
  },
  data() {
    return {
      deleteLoading: false,
    };
  },
  emits: ['imageLoaded', 'deleted'],
  methods: {
    imageLoaded() {
      this.$emit("imageLoaded");
    },
    async delete() {
      this.deleteLoading = true;
      try {
        await this.$http.delete(
          "/admin/product/" + this.product?.name,
        );
        this.$emit('deleted');
        this.toast.success("Successfully deleted Product " + this.product?.name);
      } catch (e) {
        console.error(e);
        this.toast.error("Failed to delete Product " + this.product?.name);
      } finally {
        this.deleteLoading = false;
      }
    },
  },
});
</script>
