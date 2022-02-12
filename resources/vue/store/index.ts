import {createStore, Store} from "vuex";
import userState, {UserState} from "./modules/user";
import persist from "./plugins/persist";
import {InjectionKey} from "vue";
import shoppingCartState, {ShoppingCartState} from "./modules/shoppingCart";

export interface State {
  userState: UserState,
  shoppingCartState: ShoppingCartState,
}

export const key: InjectionKey<Store<State>> = Symbol();

export const store = createStore<State>({
  state: () => {
    return {} as State;
  },
  modules: {
    userState,
    shoppingCartState,
  },
  plugins: [
    persist.plugin,
  ],
});
