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
  "XS",
  "S",
  "M",
  "L",
  "XL",
];

export enum OrderStatus {
  CREATED = 0,
  PAID = 1,
  ORDERED = 2,
  RECEIVED = 3,
  HANDED_OVER = 4,
}

export const OrderStatusLabels = [
  "erstellt",
  "bezahlt",
  "bestellt",
  "erhalten",
  "übergeben",
];

export enum ValueChangeStep {
  INCREMENT = "increment",
  DECREMENT = "decrement",
}

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
    this.description = "";
    this.highlighted = false;
    this.images = [];
    this.price = 0;
    this.title = "";
  }

  public getClothingAttributeValue(): string[] {
    return this.attributes.clothing.value;
  }

  public getColorAttributeValue(): Map<string, string> {
    return this.attributes.colors.value;
  }

  public getDimensionAttributeValue(): Set<DimensionAttribute> {
    return this.attributes.dimensions.value;
  }

  public getVolumeAttributeValue(): Set<VolumeAttribute> {
    return this.attributes.volumes.value;
  }

  public isClothingAttributeEnabled(): boolean {
    return this.attributes.clothing.enabled;
  }

  public isColorAttributeEnabled(): boolean {
    return this.attributes.colors.enabled;
  }

  public isDimensionAttributeEnabled(): boolean {
    return this.attributes.dimensions.enabled;
  }

  public isVolumeAttributeEnabled(): boolean {
    return this.attributes.volumes.enabled;
  }

  public setColorAttributeEnabled(value: boolean): void {
    this.attributes.colors.enabled = value;
  }

  public setDimensionAttributeEnabled(value: boolean): void {
    this.attributes.dimensions.enabled = value;
  }

  public setClothingAttributeEnabled(value: boolean): void {
    this.attributes.clothing.enabled = value;
  }

  public setVolumeAttributeEnabled(value: boolean): void {
    this.attributes.volumes.enabled = value;
  }

  public setClothingAttributeValue(value: string[]): void {
    this.attributes.clothing.value = value;
  }

  public setColorAttributeValue(value: Map<string, string>): void {
    this.attributes.colors.value = value;
  }

  public setDimensionAttributeValue(value: Set<DimensionAttribute>): void {
    this.attributes.dimensions.value = value;
  }

  public setVolumeAttributeValue(value: Set<VolumeAttribute>): void {
    this.attributes.volumes.value = value;
  }

  static save(object: TemporaryProductCreateStorage): void {
    window.localStorage.setItem("product", JSON.stringify(object));
  }

  static load(): TemporaryProductCreateStorage {
    let json = window.localStorage.getItem("product");
    if (json !== null) {
      return JSON.parse(json) as TemporaryProductCreateStorage;
    }
    return new ProductProcessCreateProcessStorage();
  }
}
