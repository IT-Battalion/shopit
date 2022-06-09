import {ProductCategory} from "./api";
import {UserState} from "../store/modules/user";

export interface GlobalConfig {
  currency: string,
  categories: ProductCategory[]
  userState: UserState,
}
