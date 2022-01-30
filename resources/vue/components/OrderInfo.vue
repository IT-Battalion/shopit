<template>
  <div class="flex flex-col items-center">
    <h2 class="w-full my-16 text-3xl font-bold text-center text-white">
      Bestellung #{{ showLoading(state.isLoading, order.id?.toString()) }} - {{ showLoading(state.isLoading, statusText) }}
    </h2>
    <div class="w-full p-10 sm:bg-elevatedDark rounded-3xl md:w-1/2">
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>Zwischensumme (Netto)</p>
        <p v-if="order.discount !== undefined">
          {{ order.subtotal }}
        </p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div
        class="flex justify-between my-2 text-base text-gray-200 font-base"
        v-if="order.discount !== '0,-€' && order.discount !== undefined"
      >
        <p>Rabatt (Coupon)</p>
        <p v-if="order.discount !== undefined">
          -{{ order.discount }}
        </p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base text-gray-200 font-base">
        <p>USt</p>
        <p v-if="order.discount !== undefined">{{ order.tax }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <div class="flex justify-between my-2 text-base font-medium text-white">
        <p>Gesamt</p>
        <p v-if="order.discount !== undefined">{{ order.total }}</p>
        <Skeletor :pill="true" class="w-1/4" height="1rem" v-else />
      </div>
      <FileList />
    </div>
    <div class="flex mt-12 gap-6">
      <ButtonField v-if="user.isAdmin && order.status !== firstStatus" :icon-spinner="state.isLoading" @click="previousStep">
        <template v-slot:text><span>{{ showLoading(state.isLoading, "Hoppalla zurück") }}</span></template>
        <template v-slot:icon><img src="/img/backBlack.svg" class="w-5 h-5 m-1" /></template>
      </ButtonField>
      <ButtonField :iconSpinner="state.isLoading" @click="refresh">
        <template v-slot:text><span>Neu laden</span></template>
        <template v-slot:icon>
          <svg
            class="h-5 w-5"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
            />
          </svg></template>
      </ButtonField>
      <ButtonField v-if="user.isAdmin && order.status !== lastStatus" :icon-spinner="state.isLoading" @click="confirmStep">
        <template v-slot:text><span>{{ showLoading(state.isLoading, confirmText) }}</span></template>
        <template v-slot:icon><img src="/img/doneBlack.svg" /></template>
      </ButtonField>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import {Order} from "../types/api";
import {state} from "../loader";
import {getZahlwort} from "../util";
import FileList from './FileList.vue';
import ButtonField from "./ButtonField.vue";
import {user} from "../stores/user";
import {OrderStatus} from "../types/api-values";

export default defineComponent({
  name: "OrderInfo",
  components: {ButtonField, FileList},
  props: {
    order: {
      type: Object as PropType<Order>,
    },
  },
  setup() {
    return {
      firstStatus: OrderStatus.CREATED,
      lastStatus: OrderStatus.HANDED_OVER,
    };
  },
  data() {
    return {
      user,
      state,
    }
  },
  emits: ['refresh', 'confirm', 'previous'],
  methods: {
    refresh() {
      this.$emit('refresh');
    },

    getZahlwort(id: number) {
      return getZahlwort(id.toString());
    },

    confirmStep() {
      this.$emit('confirm');
    },

    previousStep() {
      this.$emit('previous');
    },

    showLoading(when: boolean, otherwise: string) {
        return when ? "Loading..." : otherwise;
    }
  },
  computed: {
    confirmText() {
      const labels = [
        "Bezahlt",
        "Bestellt",
        "Erhalten",
        "Übergeben",
      ];
      if (this.order?.status! in labels)
        return labels[this.order?.status!];
      else
        return "Loading...";
    },
    statusText() {
      const labels = [
        "Bestellt",
        "Bezahlt",
        "Wird geliefert",
        "Abholbereit",
        "Übergeben",
      ];
      if (this.order?.status! in labels)
        return labels[this.order?.status!];
      else
        return "Loading...";
    },
  },
});
</script>
