import {ProductCategory} from "./api";
import {UserState} from "../store/modules/user";

export interface GlobalConfig {
  categories: ProductCategory[]
  userState: UserState,
}
