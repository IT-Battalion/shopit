import { AxiosInstance } from "axios";


declare module '@vue/runtime-core' {
    export interface ComponentCustomProperties {
        $http: AxiosInstance;
    }
}
