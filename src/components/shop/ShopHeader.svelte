<script lang="ts">
  import { onMount } from "svelte";
  import ShoppingCartIcon from "../../assets/images/shoppingCartIcon.svelte";
  import SearchBar from "../SearchBar.svelte";
  import ShopSelectorInput from "./ShopHeaderComponents/ShopSelectorInput.svelte";
  import { fade } from "svelte/transition";
  import { cubicOut } from "svelte/easing";
  let isVisible: boolean = $state(true);
  let props = $props();
  let element: HTMLElement | undefined;

  onMount(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        isVisible = entry.isIntersecting; // true si está visible
      },
      {
        root: null, // null = viewport
        threshold: 0.1, // 0.1 = 10% visible
      }
    );

    if (element) observer.observe(element);

    return () => observer.disconnect();
  });
</script>

<header class="h-[64px] mb-4 sm:mb-8">
  <div
    class="bg-slate-100 border-gray-200 dark:bg-gray-800 max-w-[1000px] mx-auto w-[90%] rounded-lg"
  >
    <div class="flex items-center max-w-full gap-[4px] justify-between mx-2">
      <div class=" hidden sm:block">
        <ShopSelectorInput
          storesList={props.storesList}
          selectedStore={props.selectedStore}
          handlerSelectedInput={props.handlerSelectedInput}
          handlerShopTextFilter={props.handlerShopTextFilter}
          shopTextFilter={props.textFilterShop}
          updadeStoresByFilter={props.updadeStoresByFilter}
        />
      </div>

      <div class="flex-1">
        <SearchBar
          textHover=""
          handlerValueChange={props.handlerProductTextFilter}
          textFilter={props.textFilterProduct}
          functionOnSubmit={props.updadeProductsByFilter}
          id="filterproducts"
        />
      </div>

      <div bind:this={element} class="flex items-center lg:order-2">
        <button
          id="shoppingCart"
          onclick={() => props.handlerCartListVisble(true)}
          class="relative bg-blue-600 hover:bg-blue-700 rounded-full p-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden"
        >
          <div class="size-6"><ShoppingCartIcon /></div>

          {#if props.numberOfElementsInCartShop != 0 && props.numberOfElementsInCartShop != undefined}
            <div
              class={"absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full my-auto text-center flex items-center justify-center overflow-hidden " +
                (props.numberOfElementsInCartShop > 9 ? "size-6 " : "size-5")}
            >
              <div>
                {props.numberOfElementsInCartShop > 99
                  ? "+99"
                  : props.numberOfElementsInCartShop}
              </div>
            </div>
          {/if}
        </button>
      </div>
    </div>
  </div>
  {#if !isVisible}
    <div transition:fade={{ duration: 500, delay: 100, easing: cubicOut }}

    class="fixed w-full top-4 pointer-events-none">
      <div
        class=" mx-auto max-w-[1000px] w-[90%] flex flex-row-reverse px-2 py-1"
      >
        <button
          id="shoppingCartFixed"
          onclick={() => props.handlerCartListVisble(true)}
          class="relative bg-blue-600 hover:bg-blue-700 rounded-full p-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden pointer-events-auto"
        >
          <div class="size-6"><ShoppingCartIcon /></div>
          {#if props.numberOfElementsInCartShop != 0 && props.numberOfElementsInCartShop != undefined}
            <div
              class={"absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full my-auto text-center flex items-center justify-center overflow-hidden " +
                (props.numberOfElementsInCartShop > 9 ? "size-6 " : "size-5")}
            >
              <div>
                {props.numberOfElementsInCartShop > 99
                  ? "+99"
                  : props.numberOfElementsInCartShop}
              </div>
            </div>
          {/if}
        </button>
      </div>
    </div>
  {/if}
</header>
