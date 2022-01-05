export interface LoginRequestData {
    username: string,
    password: string,
    remember: boolean,
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

interface HighlightedProductData {
    name: string,
    description: string,
    price: number,
    imgSrc: string,
    attribute: [{
        type: number,
        values_available: any,
    }]
    amount: number,
}

interface User {
    username?: string,
    name?: string,
    firstname?: string,
    lastname?: string,
    email?: string,
    employeeType?: string,
    class?: string,
    lang?: string,
    isAdmin?: boolean,
    isLoggedIn?: boolean,
}

interface Product {
    name: string,
    description: string,
    price: number,
    imgSrc: string,
    attribute: [{
        type: number,
        values_available: any,
    }]
}
