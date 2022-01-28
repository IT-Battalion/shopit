import {reactive, toRefs} from "vue";
import {Order} from "../types/api";

export const orders = reactive(new Map as Map<number, Order>);

export function useOrders() {
  return toRefs(orders);
}
