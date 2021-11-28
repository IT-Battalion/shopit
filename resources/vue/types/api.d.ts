export interface ApiResponse<T = any> {
    status: string,
    message: string,
    data: T,
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
