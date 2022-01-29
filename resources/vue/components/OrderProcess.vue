<template>
  <mq-responsive target="lg+">
    <div class="flex flex-row items-center justify-center w-full gap-5">
      <template v-for="process in orderProcess" :key="process.name">
        <router-link :to="process.link" v-if="!state.isLoading && current.valueOf() >= process.step.valueOf()">
          <div class="flex flex-col items-center">
            <img :src="process.icon_url" :alt="process.name" class="w-10 h-10"/>
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
            <img :src="process.icon_url" :alt="process.name" class="w-10 h-10"/>
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
import {useRoute} from "vue-router";
import {orders} from "../stores/order";
import {toInteger} from "lodash";
import {state} from "../loader";

export default defineComponent({
  data() {
    const route = useRoute();
    const id = route.params.id;
    const orderProcess = [
      {
        name: "Bestellen",
        icon_url: "/img/webshop.svg",
        link: {name: 'Order Created', params: {id}},
        step: OrderStatus.CREATED,
      },
      {
        name: "Bezahlen",
        icon_url: "/img/paying.svg",
        link: {name: 'Order Pay', params: {id}},
        step: OrderStatus.PAID,
      },
      {
        name: "Auf Produkt warten",
        icon_url: "/img/waiting.svg",
        link: {name: 'Order Ordered', params: {id}},
        step: OrderStatus.ORDERED,
      },
      {
        name: "Abholen",
        icon_url: "/img/pickUp.svg",
        link: {name: 'Order Receive', params: {id}},
        step: OrderStatus.RECEIVED,
      },
      {
        name: "Abgeschlossen",
        icon_url: "/img/done.svg",
        link: {name: 'Order Handed Over', params: {id}},
        step: OrderStatus.HANDED_OVER,
      },
    ];
    return {
      orderProcess,
      orders,
      state,
    };
  },
  computed: {
    current() {
      let order = this.order;
      if (order === undefined) {
        return -1;
      } else {
        return (this as any).order.status;
      }
    },
    order() {
      return orders.get(toInteger((this as any).id));
    }
  },
  watch: {
    'state.isLoading'(val) {
      console.log(orders);
    },
  },
});
</script>
