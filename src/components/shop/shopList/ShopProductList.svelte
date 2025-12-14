<script lang="ts">
  import Spinner from "../../../assets/images/spinner.svelte";
  import type { CartItemDTO } from "../../../models/CartItem";
  import type { ProductDTO } from "../../../models/Product";
  import { getQuantityOfProductInCartShop, productDTOtoCartItemDTO } from "../../../utils/utilsFunctions";
  import NavigationInputs from "./NavigationInputs.svelte";
  import ShopProductImageGallery from "./ShopProductImageGallery.svelte";
  // Props
  export let products: ProductDTO[] | undefined;
  export let isLoading: boolean;
  export let currentPage: number;
  export let totalPages: number;
  export let handlerCurrentPage: (page: number) => void;
  export let changeQuantityInCartShop: (
    shopItem: CartItemDTO,
    quantity: number
  ) => void;

  export let cartShopList: CartItemDTO[];
</script>

<div
  id="shopProductListContainer"
  class="max-w-[1200px] mx-auto w-[90%] flex flex-col"
>
  <!-- Pagination -->
  <div class="self-end">
    <NavigationInputs
      {currentPage}
      {totalPages}
      styleOverride="mb-2"
      {handlerCurrentPage}
    />
  </div>

  <!-- No items -->
  {#if !isLoading && (!products || products.length === 0)}
    <div
      class="dark:text-white rounded-lg min-h-[300px] dark:bg-gray-600 bg-gray-300 p-2 w-full flex items-center justify-center"
    >
      No items found
    </div>
  {/if}

  <!-- Spinner -->
  {#if isLoading}
    <div class="flex justify-center">
      <Spinner />
    </div>
  {/if}

  <!-- Product list -->
  {#if !isLoading && products && products.length > 0}
    <div
      id="shopProductList"
      class="grid grid-cols-1 min-[1040px]:grid-cols-3 xl:grid-cols-4 md:gap-y-4 gap-y-6 rounded-lg min-h-[300px] dark:bg-gray-600 bg-gray-300 p-2 md:justify-items-center"
    >
      {#each products as product (product.id)}
        <div
          class="w-full min-[1040px]:w-[258px]"
          id={"ShopProductElementGalleryContainer" + product.id}
        >
          <ShopProductImageGallery
            cartItem={productDTOtoCartItemDTO(
              product,
              getQuantityOfProductInCartShop(cartShopList, product.id)
            )}
            {changeQuantityInCartShop}
          />
        </div>
      {/each}
      
    </div>
  {/if}
</div>

