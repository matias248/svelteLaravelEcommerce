<script lang="ts">
  import ShopSelectorDialogStoreInput from "./ShopSelectorDialogStoreInput.svelte";

  let props = $props();
</script>

<div class="flex flex-col gap-1 overflow-auto">
  {#if props.storesList}
    {#each props.storesList as store (store.id)}
      <ShopSelectorDialogStoreInput
        {store}
        onClick={() => {
          props.handlerTemporalStore(store);
        }}
        idStoreSelected={props.selectedStore ? props.selectedStore.id : undefined}
      />
    {/each}
  {/if}
</div>
