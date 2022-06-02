<template>
  <mq-responsive target="lg+">
    <div :class="state.isLoading ? 'animate-pulse-emphasized' : ''"
         class="flex flex-row items-center justify-center w-full gap-5 h-28">
      <template v-for="(process, index) in orderProgressSteps" :key="process.name">
        <div class="flex flex-col items-center">
          <img :alt="process.name" :class="imageClasses(process.latestStep, current)"
               :src="process.icon_url"
               class="transition-size transition-opacity ease-overshoot"/>
          <span :class="textClasses(process.latestStep, current)"
                class="mt-3 text-base text-center transition-opacity transition-size text-white">{{
              process.name
            }}</span>
        </div>
        <span
          class="rounded-full bg-white transition-opacity transition-size w-16"
          :class="index > current ? 'h-1 opacity-80' : 'h-2'"
          v-if="index < orderProgressSteps.length - 1"
        />
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 ml-auto mr-0">
      <template v-for="process in orderProgressSteps" :key="process.name">
        <img :alt="process.name" :src="process.icon_url" class="w-8 h-8"/>
        <span
          v-if="process.name !== 'Abgeschlossen'"
          class="w-1 h-10 bg-white rounded-full"
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
  name: "OrderProgressBar",
  props: {
    order: {
      type: Object as PropType<Order>,
    },
  },
  data() {
    const orderProgressSteps = [
      {
        name: "Bestellen",
        icon_url: "/img/webshop.svg",
        latestStep: -1,
      },
      {
        name: "Bezahlen",
        icon_url: "/img/paying.svg",
        latestStep: OrderStatus.CREATED,
      },
      {
        name: "Produkte werden bestellt",
        icon_url: "/img/list.svg",
        latestStep: OrderStatus.PAID,
      },
      {
        name: "Produkte werden geliefert",
        icon_url: "/img/order.svg",
        latestStep: OrderStatus.ORDERED,
      },
      {
        name: "Abholen",
        icon_url: "/img/pickUp.svg",
        latestStep: OrderStatus.RECEIVED,
      },
      {
        name: "Abgeschlossen",
        icon_url: "/img/done.svg",
        latestStep: OrderStatus.HANDED_OVER,
      },
    ];
    return {
      orderProgressSteps,
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
      if (state.isLoading || step > current)
        return "w-8 h-8 opacity-80";
      else if (step < current)
        return "w-8 h-8";
      else
        return "w-20 h-20";
    },
    textClasses(step: number, current: number) {
      if (state.isLoading || step > current)
        return "text-sm opacity-80";
      else if (step < current)
        return "text-sm";
      else
        return "text-lg";
    },
  },
});
</script>
