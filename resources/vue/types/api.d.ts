export interface LoginRequestData {
  username: string,
  password: string,
  remember: boolean,
}

export interface LoginResponseData {
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

export interface User {
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

export interface ProductCategory {
  id: number,
  name: string,
  icon: {
    id: number,
  },
}

export enum AttributeType {
  CLOTHING = 0,
  DIMENSION = 1,
  VOLUME = 2,
  COLOR = 3,
}

export enum ClothingSize {
  XS = 0,
  S = 1,
  M = 2,
  L = 3,
  XL = 4,
}

export type Unit = {
  value: number,
  unit: string,
};

export type Meter = Unit;
export type Liter = Unit;
export type Color = string;

export type Money = {
  amount: string,
  currency: string,
}

export interface Product {
  name: string,
  description: string,
  price: Money,
  tax: string,
  available: number,
  thumbnail: {
    id: number,
  },
  images: [{
    id: number,
  }],
  attributes: {
    [AttributeType.CLOTHING]: [{
      type: AttributeType.CLOTHING,
      size: ClothingSize,
    }],
    [AttributeType.DIMENSION]: [{
      type: AttributeType.DIMENSION,
      width: Meter,
      height: Meter,
      depth: Meter,
    }],
    [AttributeType.VOLUME]: [{
      type: AttributeType.VOLUME,
      volume: Liter,
    }],
    [AttributeType.COLOR]: [{
      type: AttributeType.COLOR,
      name: string,
      color: Color,
    }],
  }
}
