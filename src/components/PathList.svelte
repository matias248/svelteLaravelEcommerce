<script lang="ts">
  import { goto } from "$app/navigation";
  import { pathData } from "../store.ts";
</script>

<nav
  class="pl-2 text-xs sm:text-base text-gray-900 dark:text-white flex w-full gap-1 max-w-[100vh]"
  aria-label="Breadcrumb"
>
  {#if $pathData.inStores && $pathData.storeName}
    <a
      id="NavStoresTitle"
      class="overflow-hidden max-w-[60px] hover:opacity-75 cursor-pointer"
      href="/stores/"
      on:click|preventDefault={() => goto("/stores/")}
    >
      Stores
    </a>
  {/if}

  {#if $pathData.storeName}
    <span>{">"}</span>
    <a
      id="NavStoreName"
      class="truncate max-w-[80px] sm:max-w-[200px] overflow-hidden text-ellipsis hover:opacity-75 cursor-pointer"
      href={`/stores/${$pathData.storeId}/`}
      on:click|preventDefault={() =>
        $pathData.storeId && goto(`/stores/${$pathData.storeId}/`)}
    >
      {$pathData.storeName}
    </a>
  {/if}

  {#if $pathData.inProducts}
    <span>{">"}</span>
    <a
      id="NavProductsTitle"
      class="overflow-hidden max-w-[80px] sm:max-w-[200px] text-ellipsis hover:opacity-75 cursor-pointer"
      href={`/stores/${$pathData.storeId}/products`}
      on:click|preventDefault={() =>
        $pathData.storeId && goto(`/stores/${$pathData.storeId}/products`)}
    >
      Products
    </a>
  {/if}

  {#if $pathData.productName}
    <span>{">"}</span>
    <a
      id="NavProductName"
      class="truncate overflow-hidden max-w-[80px] sm:max-w-[200px] text-ellipsis hover:opacity-75 cursor-pointer"
      href={`/stores/${$pathData.storeId}/products/${$pathData.productId}`}
      on:click|preventDefault={() =>
        $pathData.storeId &&
        $pathData.productId &&
        goto(`/stores/${$pathData.storeId}/products/${$pathData.productId}`)}
    >
      {$pathData.productName}
    </a>
  {/if}
</nav>
