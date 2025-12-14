<script lang="ts">
  import { onMount } from "svelte";
  import { goto } from "$app/navigation";

  import DisplayNotFound from "../DisplayNotFound.svelte";
  import {
    StoresKeysToNotDisplayInDetails,
    type StoreDTO,
  } from "../../models/Store";
  import { getStoreById } from "../../services/storeService";
  import Spinner from "../../assets/images/spinner.svelte";
  import { formatString } from "../../utils/utilsFunctions";
  import { pathData } from "../../store";

  let store: StoreDTO | undefined = $state(undefined);
  let isLoading = $state(true);

  const title = "Details of the store";

  let { id } = $props();

  function goToEdit() {
    if (id !== undefined) {
      goto(`/stores/${id}/edit`);
    }
  }

  // ============ ciclo de vida ============
  onMount(() => {
    if (id !== undefined) {
      isLoading = true;

      getStoreById(+id)
        .then((r) => {
          store = r;
          
          pathData.set({
            inStores: true,
            inProducts: false,
            storeName: store.name,
            storeId: store.id + "",
            productName: undefined,
            productId: undefined,
          });
        })
        .catch(() => {
          console.error("Error loading store");
        })
        .finally(() => {
          isLoading = false;
        });
    }
  });
</script>

<div>
  {#if !isLoading && store}
    <div class="mb-6 text-4xl text-center mb-16 dark:text-white">
      {title}
    </div>

    <div class="max-w-[1000px] mx-auto w-[90%] rounded-lg pb-2">
      <div class="text-3xl text-center mb-1 dark:text-white flex justify-end">
        <button
          id="gotoEditButton"
          onclick={goToEdit}
          class="max-h-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Go to Edit
        </button>
      </div>

      <ul
        class="space-y-2 bg-slate-100 border-gray-200 dark:bg-gray-800 dark:text-white rounded-lg"
      >
        {#each Object.entries(store).filter( ([key]) => StoresKeysToNotDisplayInDetails.every((k) => k !== key) ) as [key, value], index}
          {#if typeof value !== "object"}
            <li
              id={"displayStoreElement" + index}
              class="flex justify-between border-gray-200 border rounded-lg shadow-xs bg-slate-400 dark:bg-gray-500 dark:border-gray-700 gap-2"
            >
              <div
                id={"displayStoreElement" + index + "key"}
                class="bg-slate-300 dark:bg-gray-600 rounded-l-lg px-1 w-1/2 overflow-y-auto"
              >
                {formatString(key)}
              </div>

              <div
                id={"displayStoreElement" + index + "value"}
                class="bg-slate-300 dark:bg-gray-600 rounded-r-lg px-1 w-1/2 overflow-y-auto text-start"
              >
                {value}
              </div>
            </li>
          {:else}
            {#each Object.entries(value) as [k2, v2], index2}
              {#if typeof v2 === "number" || typeof v2 === "string"}
                <li
                  id={"displayStoreElement" + index + "-" + index2}
                  class="flex justify-between border border-gray-200 rounded-lg shadow-xs bg-slate-400 dark:bg-gray-500 dark:border-gray-700 gap-2"
                >
                  <div
                    id={"displayStoreElement" + index + "-" + index2 + "key"}
                    class="bg-slate-300 dark:bg-gray-600 rounded-l-lg px-1 w-1/2 overflow-y-auto"
                  >
                    {formatString(k2)}
                  </div>

                  <div
                    id={"displayStoreElement" + index + "-" + index2 + "value"}
                    class="bg-slate-300 dark:bg-gray-600 rounded-r-lg px-1 w-1/2 overflow-y-auto text-start"
                  >
                    {v2}
                  </div>
                </li>
              {/if}
            {/each}
          {/if}
        {/each}
      </ul>
    </div>
  {:else if !isLoading && !store}
    <DisplayNotFound />
  {:else}
    <div class="flex justify-center"><Spinner /></div>
  {/if}
</div>
