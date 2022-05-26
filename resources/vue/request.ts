import {AxiosResponse} from "axios"
import {
  AddToShoppingCartResponse,
  LoginRequestData,
  ProductCategory,
  RemoveFromShoppingCartRequest,
  SelectedAttributes,
  ShoppingCartDescriptor,
  ShoppingCartPrices,
  User
} from "./types/api"

export function getCSRFCookie() {
  window.axios.get("/sanctum/csrf-cookie", {baseURL: ""}).catch(_ => {
    console.error("CSRF couldn't be fetched");
  });
}

export async function login(username: string, password: string, stayLoggedIn: boolean): Promise<User> {
  return new Promise<User>((res, rej) => {
    window.axios.post<LoginRequestData, AxiosResponse<User>>("/login", {
      username: username,
      password: password,
      remember: stayLoggedIn,
    }, {
      baseURL: "/",
    }).then(response => {
      res(response.data);
    }).catch(response => {
      rej(response);
    });
  });
}

export async function logout(): Promise<void> {
  return window.axios.post("/logout", undefined, {
    baseURL: "/",
  });
}

export async function addToShoppingCart(name: string, count: number, selectedAttributes: SelectedAttributes) {
  return window.axios.post<ShoppingCartDescriptor, AxiosResponse<AddToShoppingCartResponse>>("/user/shopping-cart", {
    name: name,
    count: count,
    selectedAttributes: selectedAttributes,
  });
}

export async function removeFromShoppingCart(name: string, count: number, selectedAttributes: SelectedAttributes) {
  return window.axios.post<RemoveFromShoppingCartRequest, AxiosResponse<ShoppingCartPrices>>("/user/shopping-cart/remove", {
    name,
    count,
    selectedAttributes: selectedAttributes,
  });
}

export async function loadCategories(): Promise<ProductCategory[]> {
  let response: AxiosResponse<ProductCategory[]> = await window.axios.get(
    "/admin/category"
  );
  return response.data;
}

export async function getImpressum(): Promise<String> {
  let response: AxiosResponse<String> = await window.axios.get(
    "/impressum/get"
  );
  return response.data;
}

export async function getAGB(): Promise<String> {
  let response: AxiosResponse<String> = await window.axios.get(
    "/agb/get"
  );
  return response.data;
}
