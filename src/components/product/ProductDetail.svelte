<script lang="ts">
  import { goto } from "$app/navigation";
  import Spinner from "../../assets/images/spinner.svelte";
  import {
    ProductKeysToNotDisplayInDetails,
    type ProductDTO,
  } from "../../models/Product";
  import { getProductByIdWithstore } from "../../services/productService";
  import { pathData } from "../../store";
  import { formatString } from "../../utils/utilsFunctions";
  import DisplayNotFound from "../DisplayNotFound.svelte";
  import { onMount } from "svelte";

  // Props (reemplaza export let)
  const props = $props<{
    title: string;
    productId?: number | string;
    storeId?: number | string;
  }>();

  // Estado local
  let isLoading = $state(false);
  let product = $state<ProductDTO | undefined>();

  const keysToIgnore = ProductKeysToNotDisplayInDetails ?? [];

  function goToEdit() {
    goto(`/stores/${props.storeId}/products/${props.productId}/edit`);
  }

  onMount(() => {
    if (props.productId !== undefined && props.storeId !== undefined) {
      isLoading = true;
      getProductByIdWithstore(+props.storeId, +props.productId)
        .then((r) => {
          product = r.product;
          pathData.set({
            inStores: true,
            inProducts: true,
            storeName: r.store.name,
            storeId: r.store.id + "",
            productName: product.name,
            productId: product.id + "",
          });
        })
        .catch(() => {
          console.error("Error loading product");
        })
        .finally(() => {
          isLoading = false;
        });
    }
  });
</script>

<div>
  {#if isLoading}
    <div class="flex justify-center"><Spinner /></div>
  {:else if product}
    <div class="mb-6 text-4xl text-center mb-16 dark:text-white">
      {props.title}
    </div>

    <div class="max-w-[1000px] mx-auto w-[90%] rounded-lg pb-2">
      <div class="text-3xl text-center mb-1 dark:text-white flex justify-end">
        <button
          onclick={goToEdit}
          id="gotoEditButton"
          class="max-h-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Go to Edit
        </button>
      </div>

      <ul
        class="space-y-2 bg-slate-100 border-gray-200 dark:bg-gray-800 dark:text-white rounded-lg"
      >
        {#each Object.entries(product).filter( ([key]) => keysToIgnore.every((notKey: string) => notKey !== key) ) as element, index}
          <li
            id={"displayProductElement" + index}
            class="flex justify-between border border-gray-200 rounded-lg shadow-xs bg-slate-400 dark:bg-gray-500 dark:border-gray-700 gap-2 mt-2"
          >
            <div
              id={"displayProductElement" + index + "key"}
              class="bg-slate-300 dark:bg-gray-600 rounded-l-lg px-1 w-1/2 overflow-y-auto"
            >
              {formatString(element[0])}
            </div>
            <div
              id={"displayProductElement" + index + "value"}
              class="bg-slate-300 dark:bg-gray-600 rounded-r-lg px-1 w-1/2 overflow-y-auto text-start"
            >
              {element[1]}
            </div>
          </li>
        {/each}
      </ul>
    </div>
  {:else}
    <DisplayNotFound />
  {/if}
</div>
