<template>
  <OrderProcess :order="order" />
  <router-view />
</template>

<script lang="ts">
import OrderProcess from "../../components/OrderProcess.vue";
import {Order} from "../../types/api";
import OrderCreate from "../../components/OrderCreate.vue";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {endLoad, initLoad} from "../../loader";
import { AxiosResponse } from "axios";
import {defineComponent} from "vue";
export default defineComponent({
  components: {
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
  },
  async unmounted() {
    this.unsubscribe(this.route.params.id as string);
  },
  async data() {
    return {
      order: Object as Order,
    };
  },
  methods: {
    async loadOrder() {
      let id = this.route.params.id;
      let url = '';
      if (this.route.meta.isAdminView) {
        url = '/admin/order'; // TODO: api admin endpoint for orders
      } else {
        url = `/user/order/${id}`;
      }

      initLoad();
      let response = await this.$http.get<void, AxiosResponse<Order>>(url);
      (await this).order = response.data;
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
