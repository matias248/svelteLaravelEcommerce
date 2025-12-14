<script lang="ts">
  import { onMount } from "svelte";
  import { page } from "$app/state";
  import Spinner from "../../assets/images/spinner.svelte";
  import type { ProductDTO } from "../../models/Product";
  import { getProductsWithstore } from "../../services/productService";
  import DisplayNotFound from "../DisplayNotFound.svelte";
  import FixedButton from "../FixedButton.svelte";
  import { goto } from "$app/navigation";
  import ProductImageGallery from "./ProductImageGallery.svelte";
  import { pathData } from "../../store";

  let products: ProductDTO[] | undefined = undefined;
  let isLoading: boolean = false;
  const title = "List of products";
  export let storeId: number | undefined;

  onMount(async () => {
    if (storeId !== undefined)
      try {
        const data = await getProductsWithstore(storeId);
        products = data.products;
        console.log(products)
        pathData.set({
          inStores: true,
          inProducts: true,
          storeName: data.store.name,
          storeId: data.store.id + "",
          productName: undefined,
          productId: undefined,
        });
      } catch (error) {
        console.error("Error loading products", error);
        products = undefined;
        pathData.set({
          inStores: false,
          inProducts: false,
          storeName: undefined,
          storeId: undefined,
          productName: undefined,
          productId: undefined,
        });
      } finally {
        isLoading = false;
      }
  });
</script>

{#if isLoading}
  <div class="flex justify-center">
    <Spinner />
  </div>
{:else if products && products.length >= 0}
  <div class="mx-auto max-w-[1600px] w-[90%]">
    <div class="mb-8 text-4xl text-center dark:text-white">{title}</div>

    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:gap-y-4 gap-y-6 mx-8 pb-4 md:justify-items-center"
    >
      {#each products as product (product.id)}
        <ProductImageGallery
          onClick={() => {
            goto(`/stores/${product.storeId}/products/${product.id}`);
          }}
          onClickToEdit={() => {
            goto(`/stores/${product.storeId}/products/${product.id}/edit`);
          }}
          {product}
        />
      {/each}
    </div>

    <FixedButton
      functionToDo={() => goto(`/stores/${storeId}/products/new`)}
      title="Create a product"
    />
  </div>
{:else}
  <DisplayNotFound />
{/if}
