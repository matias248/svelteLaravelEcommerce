<script lang="ts">
  import ArrowDownIcon from "../../../assets/images/arrowDownIcon.svelte";
  import type { StoreDTO } from "../../../models/Store";
  import { clickOutside } from "../../../utils/utilsFunctions";
  import ShopSelectorDialog from "./ShopSelectorDialog.svelte";

  export let storesList: StoreDTO[] | undefined;
  export let selectedStore: StoreDTO | undefined;
  export let handlerSelectedInput: (store: StoreDTO) => void;
  export let handlerShopTextFilter: (text: string) => void;
  export let shopTextFilter: string;
  export let updadeStoresByFilter: () => void;

  let isComponentVisible = false;
  let buttonEl: HTMLDivElement;
  let dialogEl: HTMLDivElement;

  // Alternativa a useSideBarLogic: toggle y click outside
  function toggleDialog() {
    isComponentVisible = !isComponentVisible;
  }

  function closeDialog() {
    if (isComponentVisible) isComponentVisible = false;
  }
</script>

<!-- Click fuera para cerrar el diálogo -->
<div
  use:clickOutside
  onoutsideclick={() => {
    closeDialog();
  }}
>
  {#if isComponentVisible}
    <ShopSelectorDialog
      {storesList}
      {selectedStore}
      {handlerSelectedInput}
      {handlerShopTextFilter}
      {shopTextFilter}
      {updadeStoresByFilter}
    />
  {/if}

  <button
    type="button"
    id="ShopSelectorInput"
    class="flex h-full border-2 border-gray-400 rounded-lg dark:border-slate-700"
    aria-haspopup="dialog"
    aria-expanded={isComponentVisible}
    aria-label="Select store"
    onclick={toggleDialog}
  >
    <div class="w-[144px] ml-2 text-left">
      <p class="text-sm dark:text-white truncate max-w-full">My store</p>
      <p class="text-xs dark:text-white truncate max-w-full">
        {selectedStore?.name ?? "Store not selected"}
      </p>
    </div>
    <div class="size-[40px] flex items-center justify-items-center">
      <ArrowDownIcon />
    </div>
  </button>
</div>
