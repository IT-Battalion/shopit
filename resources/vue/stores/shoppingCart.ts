import {computed, ComputedRef, reactive, toRefs} from "vue";
import {Money, Product, SelectedAttributes, ShoppingCart} from "../types/api";
import {cloneDeep, isEqual, toInteger, toPlainObject} from "lodash";
import {AxiosResponse} from "axios";
import {UnwrapNestedRefs} from "@vue/reactivity";

export const shoppingCartData: UnwrapNestedRefs<{ isLoading: ComputedRef<boolean>; changingProducts: boolean; shoppingCart: UnwrapNestedRefs<ShoppingCart>; changingCoupon: boolean }> = reactive({
  shoppingCart: reactive({} as ShoppingCart),
  changingProducts: false,
  changingCoupon: false,
  isLoading: computed(() => shoppingCartData.changingProducts || shoppingCartData.changingCoupon),
});

export async function addToCart(getProduct: () => Promise<{product: Product, count: number, selectedAttributes: SelectedAttributes, productPrice: Money}>) {
  shoppingCartData.changingProducts = true;
  const {product, count, selectedAttributes, productPrice} = await getProduct();

  let found = false;
  for (let entry of shoppingCartData.shoppingCart.products) {
    if (entry.product.name === product.name &&
      isEqual(toPlainObject(cloneDeep(entry.selected_attributes)), toPlainObject(selectedAttributes)))
    {
      found = true;
      entry.price = productPrice;
      entry.count = count;
    }
  }

  if (!found) {
    shoppingCartData.shoppingCart.products.push({
      product: product,
      count: count,
      selected_attributes: selectedAttributes,
      price: productPrice,
    });
  }

  shoppingCartData.changingProducts = false;
}

export async function removeProductFromCart(getProduct: () => Promise<{product: Product, selectedAttributes: SelectedAttributes}>) {
  shoppingCartData.changingProducts = true;
  const {product, selectedAttributes} = await getProduct();

  for (let index in shoppingCartData.shoppingCart.products) {
    let entry = shoppingCartData.shoppingCart.products[index];

    if (entry.product.name === product.name &&
      isEqual(toPlainObject(cloneDeep(entry.selected_attributes)), toPlainObject(selectedAttributes))) {
      shoppingCartData.shoppingCart.products.splice(toInteger(index), 1);
    }
  }

  shoppingCartData.changingProducts = false;
}

export async function removeIndexFromCart(index: () => Promise<number>) {
  shoppingCartData.changingProducts = true;
  shoppingCartData.shoppingCart.products.splice(await index(), 1);
  shoppingCartData.changingProducts = false;
}

export async function loadCart() {
  shoppingCartData.changingProducts = true;
  let response: AxiosResponse<ShoppingCart> = await window.axios.get(
    "/user/shopping-cart"
  );
  shoppingCartData.shoppingCart = response.data;
  shoppingCartData.changingProducts = false;
}

export function updatePrices(subtotal: string, discount: string, tax: string, total: string) {
  shoppingCartData.shoppingCart.subtotal = subtotal;
  shoppingCartData.shoppingCart.discount = discount;
  shoppingCartData.shoppingCart.tax = tax;
  shoppingCartData.shoppingCart.total = total;
}

export function useShoppingCart() {
  return toRefs(shoppingCartData);
}
