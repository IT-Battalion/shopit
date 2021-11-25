import { AxiosResponse } from "axios"
import { ApiResponse } from "./types/api"

export type User = { name: string; username: string }
export type UserList = Array<User & { password: string }>

export async function getUser() {
  const request = await fetch('/current.json')
  const user: User = await request.json()
  return user
}

interface LoginData {
  username: string,
  password: string,
}

interface LoginResponseData {
  redirect_to: string,
  username: string,
  name: string,
  firstname: string,
  lastname: string,
  email: string,
  employeeType: string,
  class: string,
  lang: string,
  isAdmin: boolean,
}

export async function login(username: string, password: string): Promise<LoginResponseData> {
  return window.axios.post<LoginData, AxiosResponse<ApiResponse<LoginResponseData>>>('/login', { 'username': username, 'password': password }).then(response => {
    return response.data.data;
  }).catch(response => {
    return response;
  });
}

export async function logout(): Promise<void> {
  return window.axios.post('/logout');
}