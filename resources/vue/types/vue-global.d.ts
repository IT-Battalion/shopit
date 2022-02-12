import {AxiosInstance} from "axios";
import {Emitter} from "mitt";
import Echo from "laravel-echo";
import {Store} from "vuex";
import {State} from "../store";


declare module "@vue/runtime-core" {
  export interface ComponentCustomProperties {
    $http: AxiosInstance;
    $globalBus: Emitter<any>,
    $echo: Echo,
    $store: Store<State>
  }
}
