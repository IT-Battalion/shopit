<template>
  <OrderProgressBar :order="order"/>
  <OrderInfo :order="order" class="w-full" @confirm="confirmStep" @previous="previousStep" @refresh="loadOrder"/>
</template>

<script lang="ts">
import OrderProgressBar from "../components/OrderProgressBar.vue";
import OrderInfo from "../components/OrderInfo.vue";
import {Order} from "../types/api";
import {RouteLocationNormalizedLoaded, useRoute} from "vue-router";
import {endLoad, initLoad} from "../loader";
import {AxiosResponse} from "axios";
import {defineComponent} from "vue";
import {ValueChangeStep} from "../types/api-values";
import {useToast} from "vue-toastification";

export default defineComponent({
  name: "User Order Detail",
  components: {
    OrderProgressBar,
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
  computed: {
    user() {
      return this.$store.state.userState.user;
    },
  },
  methods: {
    async loadOrder() {
      let id = this.route.params.id;

      initLoad();
      let response = await this.$http.get<void, AxiosResponse<Order>>(`/${this.user?.isAdmin ? "admin" : "user"}/orders/${id}`);
      this.order = response.data;
      endLoad();
    },

    async confirmStep() {
      let id = this.route.params.id;

      initLoad();
      try {
        let response = await this.$http.patch<any, AxiosResponse<Order>>(`/admin/orders/${id}`, {direction: ValueChangeStep.INCREMENT});
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
        let response = await this.$http.patch<any, AxiosResponse<Order>>(`/admin/orders/${id}`, {direction: ValueChangeStep.DECREMENT});
        this.order = response.data;
      } catch (e) {
        this.toast.error("Es ist ein Fehler aufgetreten");
      }
      endLoad();
    },

    subscribe(orderId: string) {
      const events = [
        "OrderCreatedEvent",
        "OrderPaidEvent",
        "OrderProductsOrderedEvent",
        "OrderProductsReceivedEvent",
        "OrderHandedOverEvent",
      ];

      let channel = this.$echo.private(`app.order.${orderId}`);

      for (let eventName of events) {
        channel.listen(eventName.toString(), (event: { order: Order }) => {
          this.order = event.order;
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
