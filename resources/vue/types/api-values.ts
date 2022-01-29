import { Color, Meter, TemporaryColor, TemporaryDimension } from "./api";

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

export const clothingSizeLabels = [
  'XS',
  'S',
  'M',
  'L',
  'XL',
];

export enum OrderStatus {
  CREATED = 0,
  PAID = 1,
  ORDERED = 2,
  RECEIVED = 3,
  HANDED_OVER = 4,
}

export const OrderStatusLables = [
  'erstellt',
  'bezahlt',
  'bestellt',
  'erhalten',
  'übergeben',
];