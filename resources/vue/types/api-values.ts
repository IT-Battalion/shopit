import {DimensionAttribute, ProductCategory, TemporaryProductCreateStorage, VolumeAttribute} from "./api";

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

export class ProductProcessCreateProcessStorage implements TemporaryProductCreateStorage {
  attributes: {
    dimensions: {
      value: Set<DimensionAttribute>;
      enabled: boolean
    };
    volumes: {
      value: Set<VolumeAttribute>;
      enabled: boolean
    };
    clothing: {
      value: string[];
      enabled: boolean
    };
    colors: {
      value: Map<string, string>;
      enabled: boolean
    }
  };
  category: null | ProductCategory;
  description: string;
  highlighted: boolean;
  images: string[];
  price: number;
  title: string;


  constructor() {
    this.attributes = {
      dimensions: {
        value: new Set<DimensionAttribute>(),
        enabled: false,
      },
      volumes: {
        value: new Set<VolumeAttribute>(),
        enabled: false,
      },
      clothing: {
        value: [],
        enabled: false,
      },
      colors: {
        value: new Map<string, string>(),
        enabled: false,
      }
    };
    this.category = null;
    this.description = '';
    this.highlighted = false;
    this.images = [];
    this.price = 0;
    this.title = '';
  }

  getClothingAttributeValue(): string[] {
    return this.attributes.clothing.value;
  }

  getColorAttributeValue(): Map<string, string> {
    return this.attributes.colors.value;
  }

  getDimensionAttributeValue(): Set<DimensionAttribute> {
    return this.attributes.dimensions.value;
  }

  getVolumeAttributeValue(): Set<VolumeAttribute> {
    return this.attributes.volumes.value;
  }

  isClothingAttributeEnabled(): boolean {
    return this.attributes.clothing.enabled;
  }

  isColorAttributeEnabled(): boolean {
    return this.attributes.colors.enabled;
  }

  isDimensionAttributeEnabled(): boolean {
    return this.attributes.dimensions.enabled;
  }

  isVolumeAttributeEnabled(): boolean {
    return this.attributes.volumes.enabled;
  }

  setColorAttributeEnabled(value: boolean): void {
    this.attributes.colors.enabled = value;
  }

  setDimensionAttributeEnabled(value: boolean): void {
    this.attributes.dimensions.enabled = value;
  }

  setClothingAttributeEnabled(value: boolean): void {
    this.attributes.clothing.enabled = value;
  }

  setVolumeAttributeEnabled(value: boolean): void {
    this.attributes.volumes.enabled = value;
  }

  setClothingAttributeValue(value: string[]): void {
    this.attributes.clothing.value = value;
  }

  setColorAttributeValue(value: Map<string, string>): void {
    this.attributes.colors.value = value;
  }

  setDimensionAttributeValue(value: Set<DimensionAttribute>): void {
    this.attributes.dimensions.value = value;
  }

  setVolumeAttributeValue(value: Set<VolumeAttribute>): void {
    this.attributes.volumes.value = value;
  }

  static save(object: ProductProcessCreateProcessStorage): void {
    window.localStorage.setItem("product", JSON.stringify(object));
  }

  static load(): ProductProcessCreateProcessStorage {
    let json = window.localStorage.getItem('product');
    if (json !== null) {
      return JSON.parse(json);
    }
    return new ProductProcessCreateProcessStorage();
  }
}
