import {AttributeType, ClothingSize, OrderStatus} from "./api-values";

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
  is_admin: boolean,
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

export interface UserManagementUser {
  id?: number,
  username?: string,
  firstname?: string,
  lastname?: string,
  email?: string,
  isAdmin?: boolean,
  detail?: string,
}

export interface ProductCategory {
  id: number,
  name: string,
}

export interface ProductAttribute {
  id: number,
}

export interface ClothingAttribute extends ProductAttribute {
  type: AttributeType.CLOTHING,
  size: ClothingSize,
}

export interface DimensionAttribute extends ProductAttribute {
  type: AttributeType.DIMENSION,
  width: Meter,
  height: Meter,
  depth: Meter,
}

export interface VolumeAttribute extends ProductAttribute {
  type: AttributeType.VOLUME,
  volume: Liter,
}

export interface ColorAttribute extends ProductAttribute {
  type: AttributeType.COLOR,
  name: string,
  color: Color,
}

export type Unit = {
  value: number,
  unit: string,
};

export type Meter = Unit;
export type Liter = Unit;
export type Color = string;

export type Money = string;

export type SelectedAttributes = {
  [AttributeType.CLOTHING]?: ClothingAttribute,
  [AttributeType.DIMENSION]?: DimensionAttribute,
  [AttributeType.VOLUME]?: VolumeAttribute,
  [AttributeType.COLOR]?: ColorAttribute,
};

export type Attributes = {
  [AttributeType.CLOTHING]: [ClothingAttribute],
  [AttributeType.DIMENSION]: [DimensionAttribute],
  [AttributeType.VOLUME]: [VolumeAttribute],
  [AttributeType.COLOR]: [ColorAttribute],
}

export interface Product {
  id: number,
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
  attributes: Attributes,
}

export interface ShoppingCartDescriptor {
  name: string,
  selected_attributes: SelectedAttributes,
  count: number,
}

export interface ShoppingCartEntry {
  product: Product,
  selected_attributes: SelectedAttributes,
  count: number,
  price: Money,
}

export interface ShoppingCart {
  products: [ShoppingCartEntry],
  subtotal: string,
  discount: string,
  tax: string,
  total: string,
}

export interface AddToShoppingCartRequest {
  name: string,
  count: number,
  selected_attributes: SelectedAttributes,
}

export interface Coupon {
  id: number,
  discount: number,
  enabled: boolean,
  code: string,
  created_at: string,
  creator: string, //TOOD backend stuff
  enabled_until: string,
}

export interface Order {
  id?: number,
  status?: OrderStatus,
  created_at?: string,
  paid_at?: string,
  products_ordered_at?: string,
  products_received_at?: string,
  handed_over_at?: string,
  handed_over?: User, //TOOD backend stuff
  products_received?: User, //TOOD backend stuff
  products_ordered?: User, //TOOD backend stuff
  transaction_confirmed?: User,//TOOD backend stuff
  customer?: User, //TOOD backend stuff
  coupon?: Coupon, //TODO backend stuff
  subtotal?: Money,
  discount?: Money,
  tax?: Money,
  total?: Money,
}

export interface Invoice {
  id?: number,
  status?: string,
  price?: number,
  created_at?: string
}
