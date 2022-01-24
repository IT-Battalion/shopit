import {reactive} from "vue";
import {Order} from "../types/api";

export const orders = reactive({} as {[key:number]: {isLoading:boolean, order?:Order}});
