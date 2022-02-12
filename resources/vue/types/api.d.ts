import {AttributeType, ClothingSize, OrderStatus} from "./api-values";

export interface LoginRequestData {
  username: string,
  password: string,
  remember: boolean,
}

export interface User {
  id: number,
  username: string,
  firstname: string,
  lastname: string,
  email: string,
  lang: string,
  isAdmin: boolean,
  enabled: boolean,
}

export interface ProductCategory {
  id: number,
  name: string,
  color: string,
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
  selectedAttributes: SelectedAttributes,
  count: number,
}

export interface ShoppingCartEntry {
  product: Product,
  selectedAttributes: SelectedAttributes,
  count: number,
  price: Money,
}

export interface ShoppingCart {
  products: [ShoppingCartEntry],
  coupon: string,
  subtotal: string,
  discount: string,
  tax: string,
  total: string,
}

export interface AddToShoppingCartResponse {
  count: number,
  subtotal: Money,
  discount: Money,
  tax: Money,
  total: Money,
  price: Money,
}

export interface AddToShoppingCartMessage {
  product: Product,
  count: number,
  selectedAttributes: SelectedAttributes,
  subtotal: Money,
  discount: Money,
  tax: Money,
  total: Money,
  price: Money,
}

export interface RemoveFromShoppingCartMessage {
  product: Product,
  selectedAttributes: SelectedAttributes,
  subtotal: Money,
  discount: Money,
  tax: Money,
  total: Money,
  price: Money,
}

export interface RemoveFromShoppingCartRequest {
  name: string,
  count: number,
  selectedAttributes: SelectedAttributes,
}

export interface ShoppingCartPrices {
  subtotal: Money,
  discount: Money,
  tax: Money,
  total: Money,
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
  id: number,
  status: OrderStatus,
  created_at: string,
  paid_at?: string,
  products_ordered_at?: string,
  products_received_at?: string,
  handed_over_at?: string,
  handed_over?: User,
  products_received?: User,
  products_ordered?: User,
  transaction_confirmed?: User,
  customer?: User,
  coupon?: Coupon,
  subtotal: Money,
  discount: Money,
  tax: Money,
  total: Money,
}

export interface Invoice {
  id?: number,
  status?: string,
  price?: number,
  created_at?: string
}

export interface CreateCouponRequest {
  code: string,
  discount: number,
  enabled_until: string,
}

export interface CreateCategoryRequest {
  name: string,
}

export interface EditCategoryRequest {
  name: string,
}

export interface BanUserRequest {
  reason: string,
}

export interface Ban {
  disabled_at?: string,
  reason?: string,
  disabled_by?: User,
}

export interface CreateProductRequest {
  name: string,
  description: string,
  price: number,
  product_category_id: number,
}

export interface ProductImage {
  path: string,
}

export interface CreateProductImageRequest {
  product_id: number,
  image: string,
}

export interface CreateProductClothingAttributesRequest {
  size: number,
}

export interface CreateProductDimensionAttributesRequest {
  width: number
  height: number,
  depth: number,
}

export interface CreateProductVolumeAttributesRequest {
  volume: number,
}

export interface CreateProductColorAttributesRequest {
  name: string,
  color: string,
}

export interface CreateProductVolumeAttributesLinkRequest {
  product_id: number,
  product_volume_attribute_id: number,
}

export interface CreateProductDimensionAttributesLinkRequest {
  product_id: number,
  product_dimension_attribute_id: number,
}

export interface CreateProductClothingAttributesLinkRequest {
  product_id: number,
  product_clothing_attribute_id: number,
}

export interface CreateProductColorAttributesLinkRequest {
  product_id: number,
  product_color_attribute_id: number,
}

export interface CreateHighlightedProductRequest {
  product_id: number,
}

export interface UpdateProductThumbnailRequest {
  product_id: number,
  thumbnail_id: number,
}

export interface TemporaryProductCreateStorage {
  title: string;
  price: number;
  description: string;
  highlighted: boolean;
  category: null | ProductCategory;
  images: string[];
  attributes: {
    dimensions: {
      value: Set<DimensionAttribute>;
      enabled: boolean;
    };
    volumes: {
      value: Set<VolumeAttribute>;
      enabled: boolean;
    };
    clothing: {
      value: string[];
      enabled: boolean;
    };
    colors: {
      value: Map<string, string>;
      enabled: boolean;
    };
  };

  isColorAttributeEnabled(): boolean;

  isDimensionAttributeEnabled(): boolean;

  isClothingAttributeEnabled(): boolean;

  isVolumeAttributeEnabled(): boolean;

  setColorAttributeEnabled(value: boolean): void;

  setDimensionAttributeEnabled(value: boolean): void;

  setClothingAttributeEnabled(value: boolean): void;

  setVolumeAttributeEnabled(value: boolean): void;

  getColorAttributeValue(): Map<string, string>;

  getClothingAttributeValue(): string[];

  getVolumeAttributeValue(): Set<VolumeAttribute>;

  getDimensionAttributeValue(): Set<DimensionAttribute>;

  setColorAttributeValue(value: Map<string, string>): void;

  setVolumeAttributeValue(value: Set<VolumeAttribute>): void;

  setClothingAttributeValue(value: string[]): void;

  setDimensionAttributeValue(value: Set<DimensionAttribute>): void;
}

export interface TemporaryColor {
  name: string,
  color: Color,
}

export interface TemporaryDimension {
  width: Meter,
  height: Meter,
  depth: Meter,
}
