<template>
  <mq-responsive target="lg+">
    <div class="flex flex-row items-center justify-center w-full gap-5 h-28" :class="state.isLoading ? 'animate-pulse-emphasized' : ''">
      <template v-for="process in orderProcess" :key="process.name">
        <div class="flex flex-col items-center transition-opacity transition-size">
          <img :src="process.icon_url" :alt="process.name"
               class="transition-size transition-opacity ease-overshoot"
               :class="imageClasses(process.step, current)"/>
          <span class="mt-3 text-base text-center transition-opacity transition-size text-white" :class="textClasses(process.step, current)">{{
              process.name
            }}</span>
        </div>
        <span
          class="rounded-full transition-opacity bg-white w-16 h-1 opacity-80"
          v-if="process.name !== 'Abgeschlossen'"
        />
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 ml-auto mr-0">
      <template v-for="process in orderProcess" :key="process.name">
        <img :src="process.icon_url" :alt="process.name" class="w-8 h-8"/>
        <span
          class="w-1 h-10 bg-white rounded-full"
          v-if="process.name !== 'Abgeschlossen'"
        />
      </template>
    </div>
  </mq-responsive>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {OrderStatus} from "../types/api-values";
import {state} from "../loader";
import {Order} from "../types/api";
import {PropType} from "vue";
import {isEmpty} from "lodash";

export default defineComponent({
  name: "OrderProcess",
  props: {
    order: {
      type: Object as PropType<Order>,
    },
  },
  data() {
    const orderProcess = [
      {
        name: "Bestellt",
        icon_url: "/img/webshop.svg",
        step: -1,
      },
      {
        name: "Bezahlen",
        icon_url: "/img/paying.svg",
        step: OrderStatus.CREATED,
      },
      {
        name: "Produkte werden bestellt",
        icon_url: "/img/list.svg",
        step: OrderStatus.PAID,
      },
      {
        name: "Produkte werden geliefert",
        icon_url: "/img/order.svg",
        step: OrderStatus.ORDERED,
      },
      {
        name: "Abholen",
        icon_url: "/img/pickUp.svg",
        step: OrderStatus.RECEIVED,
      },
      {
        name: "Abgeschlossen",
        icon_url: "/img/done.svg",
        step: OrderStatus.HANDED_OVER,
      },
    ];
    return {
      orderProcess,
      state,
    };
  },
  computed: {
    current() {
      if (isEmpty(this.order))
        return -1;
      else
        return this.order?.status;
    },
  },
  methods: {
    imageClasses(step: number, current: number) {
      if (state.isLoading || step !== current)
        return "w-8 h-8 opacity-80";

      return "w-16 h-16";
    },
    textClasses(step: number, current: number) {
      if (state.isLoading || step !== current)
        return "text-sm opacity-80";

      return "text-lg";
    },
  },
});
</script>
