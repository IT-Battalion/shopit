<template>
  <AdminOrderProcess/>
  <router-view/>
</template>

<script lang="ts">
import OrderProcess from "../../components/OrderProcess.vue";
import {Order} from "../../types/api";
import OrderCreate from "../../components/OrderCreate.vue";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {endLoad, initLoad} from "../../loader";
import {AxiosResponse} from "axios";
import {defineComponent} from "vue";
import {toInteger} from "lodash";
import AdminOrderProcess from "../../components/AdminOrderProcess.vue";
import {orders} from "../../stores/order";

export default defineComponent({
  components: {
    AdminOrderProcess,
    OrderCreate,
    OrderProcess,
  },
  setup() {
    return {
      route: useRoute(),
    }
  },
  async created() {
    this.subscribe(this.route.params.id as string)
    await this.loadOrder();
  },
  async unmounted() {
    this.unsubscribe(this.route.params.id as string);
  },
  data() {
    return {
      orders,
    };
  },
  methods: {
    async loadOrder() {
      let id = this.route.params.id;
      initLoad();
      let response = await this.$http.get<void, AxiosResponse<Order>>(`/admin/orders/${id}`);
      this.orders.set(toInteger(id), response.data);
      endLoad();
    },
    subscribe(orderId: string) {
      this.$echo.private(`app.order.${orderId}`)
        .listen('OrderPaidEvent', (e: any) => {
          console.log(e);
        })
        .listen('OrderOrderedEvent', (e: any) => {
          console.log(e);
        })
        .listen('OrderDeliveredEvent', (e: any) => {
          console.log(e);
        })
        .listen('OrderReceivedEvent', (e: any) => {
          console.log(e);
        });
    },
    unsubscribe(orderId: string) {
      this.$echo.leave(`app.order.${orderId}`);
    }
  },
  watch: {
    $route(to: RouteLocationNormalizedLoaded, from: RouteLocationNormalizedLoaded) {
      this.unsubscribe(from.params.id as string);
      this.subscribe(to.params.id as string);
    }
  },
});
</script>
