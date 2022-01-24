<template>
  <mq-responsive target="lg+">
    <div class="justify-center w-full flex flex-row items-center gap-5">
      <template v-for="process in orderProcess" :key="process.name">
        <div class="flex flex-col items-center">
          <img :src="process.icon_url" :alt="process.name" />
          <a class="text-base mt-3 text-white text-center">{{
            process.name
          }}</a>
        </div>
        <span
          class="w-20 h-2 bg-white rounded-full"
          v-if="process.name !== 'Abgeschlossen'"
        />
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 mr-0 ml-auto">
      <template v-for="process in orderProcess" :key="process.name">
        <img :src="process.icon_url" :alt="process.name" class="h-[3vh]" />
        <span
          class="w-1 h-10 bg-white rounded-full"
          v-if="process.name !== 'Abgeschlossen'"
        />
      </template>
    </div>
  </mq-responsive>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import {Order} from "../types/api";
import {PropType} from "vue";
import {OrderStatus} from "../types/api-values";

export default defineComponent({
  props: {
    order: {
      type: Object as PropType<Order>,
    },
  },
  setup() {
    const orderProcess = [
      {
        name: "Bestellen",
        icon_url: "/img/orderOrdered.svg",
        step: OrderStatus.CREATED,
      },
      {
        name: "Bezahlen",
        icon_url: "/img/orderPayed.svg",
        step: OrderStatus.PAID,
      },
      {
        name: "Auf Produkt warten",
        icon_url: "/img/orderWaiting.svg",
        step: OrderStatus.ORDERED,
      },
      {
        name: "Abholen",
        icon_url: "/img/orderCollect.svg",
        step: OrderStatus.RECEIVED,
      },
      {
        name: "Abgeschlossen",
        icon_url: "/img/orderComplete.svg",
        step: OrderStatus.HANDED_OVER,
      },
    ];
    return { orderProcess };
  },
  computed: {
    current() {
      if (this.order === undefined) {
        return -1;
      } else {
        return this.order.status;
      }
    }
  }
});
</script>
