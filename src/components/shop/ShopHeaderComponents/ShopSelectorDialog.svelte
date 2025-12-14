<script lang="ts">
  import { fly } from "svelte/transition";
  import type { StoreDTO } from "../../../models/Store";
  import SearchBar from "../../SearchBar.svelte";
  import ShopSelectorDialogButtonConfirm from "./ShopSelectorDialogButtonConfirm.svelte";
  import ShopSelectorDialogStoreInputList from "./ShopSelectorDialogStoreInputList.svelte";

  let shopSelectedTemporal = $state<StoreDTO | undefined>();

  let props = $props();

  const handlerStoreSelected = (store: StoreDTO) => {
    shopSelectedTemporal = store;
  };
</script>

<div
  transition:fly={{ x: -300, duration: 500, opacity: 0 }}
  class="fixed h-dvh bg-gray-300 dark:bg-gray-500 top-0 left-0 max-[460px]:w-[50%] w-[40%] md:w-[30%] z-10 rounded-r-lg flex flex-col gap-1 px-1"
>
  <div class="dark:text-white font-bold self-center">Select your store</div>

  <div class="dark:text-slate-100 text-sm mb-1">
    Enter your zip code or city to see the nearest stores. This will allow you
    to filter products by store.
  </div>

  <div class=" ">
    <SearchBar
      textHover={props.textHover}
      textFilter={props.shopTextFilter}
      handlerValueChange={props.handlerShopTextFilter}
      functionOnSubmit={props.updadeStoresByFilter}
      id="filtershops"
    />
  </div>

  <div class="flex-1 overflow-auto mb-2">
    <ShopSelectorDialogStoreInputList
      storesList={props.storesList ?? []}
      selectedStore={shopSelectedTemporal}
      handlerTemporalStore={handlerStoreSelected}
    />
  </div>

  <div class="mb-2">
    <ShopSelectorDialogButtonConfirm
      styleOverride=""
      functionToDo={() => {
        if (shopSelectedTemporal)
          props.handlerSelectedInput(shopSelectedTemporal);
      }}
      title={"Select store"}
    />
  </div>
</div>
