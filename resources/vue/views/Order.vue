<template>
  <OrderProcess :order="order" />
  <OrderInfo class="w-full" :order="order" @refresh="loadOrder" @confirm="confirmStep" @previous="previousStep" />
</template>

<script lang="ts">
import OrderProcess from "../components/OrderProcess.vue";
import OrderInfo from "../components/OrderInfo.vue";
import {Order} from "../types/api";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {defineComponent} from "vue";
import {OrderStatus} from "../types/api-values";
import {user} from "../stores/user";
import {useToast} from "vue-toastification";

export default defineComponent({
  name: 'User Order Detail',
  components: {
    OrderProcess,
    OrderInfo,
  },
  setup() {
    const route = useRoute();
    const toast = useToast();
    return {
      route,
      toast,
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
      order: {} as Order,
    };
  },
  methods: {
    async loadOrder() {
      let id = this.route.params.id;

      initLoad();
      let response = await this.$http.get<void, AxiosResponse<Order>>(`/${user.isAdmin ? 'admin' : 'user'}/orders/${id}`);
      if (this.order.status! > response.data.status!)
        response.data.status = this.order.status;
      this.order = response.data;
      endLoad();
    },

    async confirmStep() {
      let id = this.route.params.id;

      initLoad();
      try {
        let response = await this.$http.patch<any, AxiosResponse<Order>>(`/admin/orders/${id}`, {status: this.order.status + 1});
        if (this.order.status! > response.data.status!) // if something has changed during the request (e.g. a websocket event)
          response.data.status = this.order.status;
        this.order = response.data;
      } catch (e: any) {
        this.toast.error("Es ist ein Fehler aufgetreten");
      }
      endLoad();
    },

    async previousStep() {
      let id = this.route.params.id;

      initLoad();
      try {
        let response = await this.$http.patch<any, AxiosResponse<Order>>(`/admin/orders/${id}`, {status: this.order.status - 1});
        if (this.order.status! < response.data.status!) // if something has changed during the request (e.g. a websocket event)
          response.data.status = this.order.status;
        this.order = response.data;
      } catch (e) {
        this.toast.error("Es ist ein Fehler aufgetreten");
      }
      endLoad();
    },

    subscribe(orderId: string) {
      const events = new Map<String, OrderStatus>([
        ["OrderPaidEvent", OrderStatus.PAID],
        ["OrderOrderedEvent", OrderStatus.ORDERED],
        ["OrderDeliveredEvent", OrderStatus.RECEIVED],
        ["OrderReceivedEvent", OrderStatus.HANDED_OVER],
      ]);

      let channel = this.$echo.private(`app.order.${orderId}`);

      for (let [eventName, orderStatus] of events.entries()) {
        channel.listen(eventName.toString(), (_: any) => {
          if (orderStatus > this.order.status!)
            this.order.status = orderStatus;
        });
      }
    },

    unsubscribe(orderId: string) {
      this.$echo.leave(`app.order.${orderId}`);
    },
  },
  watch: {
      $route(to: RouteLocationNormalizedLoaded, from: RouteLocationNormalizedLoaded) {
        this.unsubscribe(from.params.id as string);
        this.subscribe(to.params.id as string);
      }
  },
});
</script>
