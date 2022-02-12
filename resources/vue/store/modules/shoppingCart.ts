import {Money, Product, SelectedAttributes, ShoppingCart, ShoppingCartEntry} from "../../types/api";
import {cloneDeep, isEqual, toInteger, toPlainObject} from "lodash";
import {Module} from "vuex";
import {State} from "../index";

export interface ShoppingCartState {
  shoppingCart: ShoppingCart,
  changingProducts: boolean,
  changingCoupon: boolean,
}

let loadingProducts: Promise<void> | undefined = undefined;

const shoppingCartState: Module<ShoppingCartState, State> = {
  state() {
    return {
      shoppingCart: {},
      changingProducts: false,
      changingCoupon: false,
    } as ShoppingCartState;
  },

  getters: {
    isLoading(state) {
      return state.changingProducts || state.changingCoupon;
    }
  },

  mutations: {
    changeProducts(state) {
      state.changingProducts = true;
    },

    productsChanged(state) {
      state.changingProducts = false;
    },

    changeCoupon(state) {
      state.changingCoupon = true;
    },

    couponChanged(state) {
      state.changingCoupon = false;
    },

    changeOrCreateEntry(state, entry: ShoppingCartEntry) {
      for (let currentEntry of state.shoppingCart.products) {
        if (entry.product.name === entry.product.name &&
          isEqual(toPlainObject(cloneDeep(currentEntry.selectedAttributes)), entry.selectedAttributes)) {
          currentEntry.price = entry.price;
          currentEntry.count = entry.count;
          return;
        }
      }
      state.shoppingCart.products.push(entry);
    },

    removeProduct(state, entryIdentification: { product: Product, selectedAttributes: SelectedAttributes }) {
      const {product, selectedAttributes} = entryIdentification;
      for (let index in state.shoppingCart.products) {
        let i = toInteger(index);
        let entry = state.shoppingCart.products[i];
        if (entry.product.name === product.name &&
          isEqual(toPlainObject(cloneDeep(entry.selectedAttributes)), toPlainObject(selectedAttributes))) {
          state.shoppingCart.products.splice(i, 1);
          return;
        }
      }
    },

    removeIndex(state, index: number) {
      state.shoppingCart.products.splice(index, 1);
    },

    replaceShoppingCart(state, newShoppingCart: ShoppingCart) {
      state.shoppingCart = newShoppingCart;
    },

    updatePrices(state, newPrices: { subtotal: Money, discount: Money, tax: Money, total: Money }) {
      state.shoppingCart = Object.assign(state.shoppingCart, newPrices);
    }
  },

  actions: {
    async addToCart({commit}, getProduct: () => Promise<ShoppingCartEntry>) {
      commit("changeProducts");
      const product = await getProduct();
      commit("changeOrCreateEntry", product);
      commit("productsChanged");
    },

    async removeProductFromCart({commit}, getEntryIdentification: () => Promise<{ product: Product, selectedAttributes: SelectedAttributes }>) {
      commit("changeProducts");
      const entryIdentification = await getEntryIdentification();
      commit("removeProduct", entryIdentification);
      commit("productsChanged");
    },

    async removeIndexFromCart({commit}, index: () => Promise<number>) {
      commit("changeProducts");
      commit("removeIndex", await index());
      commit("productsChanged");
    },

    async loadCart({commit}) {
      commit("changeProducts");
      if (!loadingProducts) {
        loadingProducts = window.axios.get("/user/shopping-cart")
          .then((response) => {
            commit("replaceShoppingCart", response.data);
          });
      }
      await loadingProducts;
      commit("productsChanged");
    },
  }
}

export default shoppingCartState;
