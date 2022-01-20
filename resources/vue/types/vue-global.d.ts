import { AxiosInstance } from "axios";
import {Emitter} from "mitt";


declare module '@vue/runtime-core' {
    export interface ComponentCustomProperties {
        $http: AxiosInstance;
        $globalBus: Emitter<any>,
    }
}
