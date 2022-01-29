<template>
  <mq-responsive target="lg+">
    <div class="flex flex-row items-center justify-center w-full gap-5">
      <template v-for="process in orderProcess" :key="process.name">
        <router-link :to="process.link" v-if="!isLoading && current.valueOf() >= process.step.valueOf()">
          <div class="flex flex-col items-center">
            <img :src="process.icon_url" :alt="process.name" class="w-10 h-10" />
            <span class="mt-3 text-base text-center text-white">{{
              process.name
            }}</span>
          </div>
          <span
            class="w-20 h-2 bg-white rounded-full"
            v-if="process.name !== 'Abgeschlossen'"
          />
        </router-link>
        <template v-else>
          <div class="flex flex-col items-center">
            <img :src="process.icon_url" :alt="process.name" class="w-10 h-10" />
            <span class="mt-3 text-base text-center text-white">{{
                process.name
              }}</span>
          </div>
          <span
            class="w-20 h-2 bg-white rounded-full"
            v-if="process.name !== 'Abgeschlossen'"
          />
        </template>
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 ml-auto mr-0">
      <template v-for="process in orderProcess" :key="process.name">
        <img :src="process.icon_url" :alt="process.name" class="w-8 h-8" />
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
import { OrderStatus } from "../types/api-values";
import {useRoute} from "vue-router";
import {orders} from "../stores/order";
import {toInteger} from "lodash";
import {state} from "../loader";

export default defineComponent({
  setup() {
    const orderProcess = [
      {
        name: "Bestellt",
        icon_url: "/img/webshop.svg",
        link: {name: 'Admin Order Created'},
        step: OrderStatus.CREATED,
      },
      {
        name: "Geld empfangen",
        icon_url: "/img/paying.svg",
        link: {name: 'Admin Order Pay'},
        step: OrderStatus.PAID,
      },
      {
        name: "Auf Produkte warten",
        icon_url: "/img/waiting.svg",
        link: {name: 'Admin Order Ordered'},
        step: OrderStatus.ORDERED,
      },
      {
        name: "Übergeben",
        icon_url: "/img/pickUp.svg",
        link: {name: 'Admin Order Received'},
        step: OrderStatus.RECEIVED,
      },
      {
        name: "Abgeschlossen",
        icon_url: "/img/done.svg",
        link: {name: 'Admin Order Handed Over'},
        step: OrderStatus.HANDED_OVER,
      },
    ];
    return {
      orderProcess,
      orders,
      isLoading: state.isLoading,
    };
  },
  computed: {
    current() {
      if (this.order === undefined) {
        return -1;
      } else {
        return (this as any).order.status;
      }
    },
    order() {
      const route = useRoute();
      const id = route.params.id;
      return (this as any).orders.orders[toInteger(id)];
    }
  },
});
</script>
