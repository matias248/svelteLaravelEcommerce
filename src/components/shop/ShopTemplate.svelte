<script lang="ts">
  import { onMount, untrack } from "svelte";
  import type { CartItemDTO } from "../../models/CartItem";
  import { arrayCategoryType, type ProductDTO } from "../../models/Product";
  import type { StoreDTO } from "../../models/Store";
  import { getProductsPublicUrl } from "../../services/productService";
  import {
    getStores,
    getStoresFilteredByNameCityCodeZip,
  } from "../../services/storeService";
  import {
    getTotalProductsElements,
    getTrueKeys,
  } from "../../utils/utilsFunctions";
  import OrderConfirm from "./OrderConfirm.svelte";
  import ShopCart from "./ShopCart.svelte";
  import ShopHeader from "./ShopHeader.svelte";
  import ShopCategoryList from "./shopCategory/ShopCategoryList.svelte";
  import ShopProductList from "./shopList/ShopProductList.svelte";
  import ShopSelectorInput from "./ShopHeaderComponents/ShopSelectorInput.svelte";

  let storesList = $state<StoreDTO[]>([]);
  let selectedStore = $state<StoreDTO | undefined>();
  let shopTextFilter = $state<string>("");
  let currentPage = $state<number>(1);
  let productTextFilter = $state<string>("");
  let isLoading = $state<boolean>(true);
  let totalPages = $state<number>();
  let products = $state<ProductDTO[]>([]);

  const handlerCurrentPage = (page: number) => {
    currentPage = page;
  };

  const handlerStoreSelected = (store: StoreDTO) => {
    selectedStore = store;
  };
  const handlerShopTextFilter = (text: string) => {
    shopTextFilter = text;
  };

  let handlerProductTextFilter = (text: string) => {
    productTextFilter = text;
  };

  let orderConfirmModal = $state(false);
  let cartListVisble = $state(false);
  let cartData: CartItemDTO[] = $state([]);

  let numberOfElementsInCartShop = $derived(
    getTotalProductsElements(cartData ?? [])
  );

  let handleOrderConfirmModal = () => {
    orderConfirmModal = !orderConfirmModal;
    if (orderConfirmModal == false) {
      cartData = [];
      cartListVisble=false;
    }
  };
  let handleCartListVisbleModal = () => {
    cartListVisble = !cartListVisble;
  };

  let changeQuantityInCartShop = (shopItem: CartItemDTO, quantity: number) => {
    let indexOfShopItemInTheArray: number = -1;
    if (quantity === 0) {
      let newArray = cartData?.filter((element) => {
        return element.id !== shopItem.id;
      });
      cartData = newArray;
    } else {
      cartData?.forEach((element, index) => {
        if (element.id === shopItem.id) {
          indexOfShopItemInTheArray = index;
        }
      });
      if (indexOfShopItemInTheArray === -1 || cartData === undefined) {
        let newCartItem: CartItemDTO = shopItem;
        newCartItem.quantity = quantity;
        if (cartData) {
          cartData = [newCartItem, ...cartData];
        } else {
          cartData = [newCartItem];
        }
      } else {
        let newCartShopList = [...cartData];
        newCartShopList[indexOfShopItemInTheArray].quantity = quantity;
        cartData = newCartShopList;
      }
    }
  };

  const getFilteredStores = (textFilter: string) => {
    getStoresFilteredByNameCityCodeZip(textFilter).then((storesFiltered) => {
      storesList = storesFiltered;
    });
  };

  let filterCategoryMap = $state<Map<string, boolean>>(
    new Map(arrayCategoryType.map((item) => [item, false]))
  );

  function setMap(key: string, value: boolean) {
    filterCategoryMap = new Map(filterCategoryMap);
    filterCategoryMap.set(key, value);
  }

  const getFilteredProducts = (textFilter: string) => {
    getProductsPublicUrl(
      getTrueKeys(filterCategoryMap),
      currentPage !== 0 ? currentPage : 1,
      10,
      textFilter,
      selectedStore?.id
    )
      .then((data) => {
        products = data.products;
        totalPages = data.totalPages;
        isLoading = false;
      })
      .catch(() => {
        console.error("Error loading products filtered");
      });
  };

  $effect(() => {
    filterCategoryMap;
    currentPage;
    selectedStore;

    getFilteredProducts(untrack(() => productTextFilter));
  });

  onMount(() => {
    getStores()
      .then((stores) => {
        storesList = stores;
      })
      .catch(() => {
        console.error("Error loading stores");
      });
    getFilteredProducts(productTextFilter);
  });
</script>

<div class="pb-4">
  {#if orderConfirmModal}
    <OrderConfirm functionToDo={handleOrderConfirmModal} />
  {/if}
  {#if cartListVisble}
    <ShopCart
      handlerCartListVisble={handleCartListVisbleModal}
      cart={cartData}
      {changeQuantityInCartShop}
      handlerOrderConfirmModal={handleOrderConfirmModal}
    />
  {/if}
  <ShopHeader
    updadeStoresByFilter={() => getFilteredStores(shopTextFilter ?? "")}
    updadeProductsByFilter={() => getFilteredProducts(productTextFilter ?? "")}
    {storesList}
    {selectedStore}
    handlerSelectedInput={handlerStoreSelected}
    {handlerShopTextFilter}
    textFilterShop={shopTextFilter}
    textFilterProduct={productTextFilter}
    {handlerProductTextFilter}
    handlerCartListVisble={(value: boolean) => (cartListVisble = value)}
    {numberOfElementsInCartShop}
  />
  <div class=" block sm:hidden ml-[5%] w-[188px] mb-4">
    <ShopSelectorInput
      {storesList}
      {selectedStore}
      handlerSelectedInput={handlerStoreSelected}
      {handlerShopTextFilter}
      {shopTextFilter}
      updadeStoresByFilter={() => getFilteredStores(shopTextFilter ?? "")}
    />
  </div>
  <div class="mb-4">
    <ShopCategoryList updateFilterCategoryMap={setMap} {filterCategoryMap} />
  </div>
  <ShopProductList
    {products}
    {isLoading}
    {currentPage}
    totalPages={totalPages ?? 1}
    {handlerCurrentPage}
    cartShopList={cartData ?? []}
    {changeQuantityInCartShop}
  />
</div>
