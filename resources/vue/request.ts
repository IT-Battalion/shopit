import {AxiosResponse} from "axios"
import {AddToShoppingCartRequest, LoginRequestData, LoginResponseData, SelectedAttributes} from "./types/api"

export async function login(username: string, password: string, stayLoggedIn: boolean): Promise<LoginResponseData> {
  return new Promise<LoginResponseData>((res, rej) => {
    window.axios.post<LoginRequestData, AxiosResponse<LoginResponseData>>('/login', {
      username: username,
      password: password,
      remember: stayLoggedIn,
    }, {
      baseURL: '/',
    }).then(response => {
      res(response.data);
    }).catch(response => {
      rej(response);
    });
  });
}

export async function logout(): Promise<void> {
  return window.axios.post('/logout', undefined, {
    baseURL: '/',
  });
}

export async function addToShoppingCart(name: string, count: number, selectedAttributes: SelectedAttributes) {
  return window.axios.post<AddToShoppingCartRequest, AxiosResponse<void>>('/user/shopping-cart', {
    name: name,
    count: count,
    selected_attributes: selectedAttributes,
  });
}
