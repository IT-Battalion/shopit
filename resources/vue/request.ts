import {AxiosResponse} from "axios"
import {ApiResponse, LoginData, LoginResponseData} from "./types/api"

export type User = { name: string; username: string }
export type UserList = Array<User & { password: string }>

export async function getUser() {
    const request = await fetch('/current.json')
    const user: User = await request.json()
    return user
}

export async function login(username: string, password: string): Promise<LoginResponseData> {
    return new Promise<LoginResponseData>((res, rej) => {
        window.axios.post<LoginData, AxiosResponse<ApiResponse<LoginResponseData>>>('/login', {
            'username': username,
            'password': password,
        }).then(response => {
            res(response.data.data);
        }).catch(response => {
            rej(response);
        });
    });
}

export async function logout(): Promise<void> {
    return window.axios.post('/logout');
}
