import { writable } from "svelte/store";

interface PathData {
  inStores: boolean;
  inProducts: boolean;
  storeName?: string;
  storeId?: string;
  productName?: string;
  productId?: string;
}

export const pathData = writable<PathData>({ inStores: false, inProducts: false, storeName: undefined, productName: undefined, storeId: undefined, productId: undefined });

export const inShop = writable(true);

