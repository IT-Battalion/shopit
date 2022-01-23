import {AxiosInstance} from "axios";
import {Emitter} from "mitt";
import Echo from "laravel-echo";


declare module '@vue/runtime-core' {
  export interface ComponentCustomProperties {
    $http: AxiosInstance;
    $globalBus: Emitter<any>,
    $echo: Echo,
  }
}
