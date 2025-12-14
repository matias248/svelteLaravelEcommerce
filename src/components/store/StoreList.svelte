<script lang="ts">
  import type { StoreDTO } from "../../models/Store";
  import { onMount } from "svelte";
  import { getStores } from "../../services/storeService";
  import Spinner from "../../assets/images/spinner.svelte";
  import StoreImageGallery from "./StoreImageGallery.svelte";
  import { goto } from "$app/navigation";
  import FixedButton from "../FixedButton.svelte";
  import { pathData } from "../../store";
  const title = "List of stores";
  let stores = $state<StoreDTO[]>([]);
  let loading = $state(true);

  onMount(async () => {
    loading = true;
    getStores()
      .then((r) => {
        stores = r;
        pathData.set({
          inStores: true,
          inProducts: false,
          storeName: undefined,
          storeId: undefined,
          productName: undefined,
          productId: undefined,
        });
      })
      .catch(() => {
        console.error("Error loading stores");
        pathData.set({
          inStores: true,
          inProducts: false,
          storeName: undefined,
          storeId: undefined,
          productName: undefined,
          productId: undefined,
        });
      })
      .finally(() => {
        loading = false;
      });
  });
</script>

{#if loading}
  <div class="flex justify-center"><Spinner /></div>
{:else}
  <div class="mx-auto max-w-[1600px] mx-auto w-[90%]">
    <div class="text-4xl text-center mb-8 dark:text-white">{title}</div>

    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:gap-y-4 gap-y-6 pb-4 md:justify-items-center"
    >
      {#each stores as store (store.id)}
        <StoreImageGallery
          {store}
          onClick={() => {
            goto(`/stores/${store.id}`);
          }}
          onClickToEdit={() => {
            goto(`/stores/${store.id}/edit`);
          }}
          onClickToProductsListButton={() => {
            goto(`/stores/${store.id}/products/`);
          }}
        />
      {/each}
    </div>
    <FixedButton
      functionToDo={() => goto(`/stores/new`)}
      styleOverride=""
      title="Create a Store"
    />
  </div>
{/if}
