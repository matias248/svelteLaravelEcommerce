<script lang="ts">
  import EditButton from "../forms/EditButton.svelte";
  import ImagePlaceholder from "../../assets/images/iconImagePlaceholder.svelte";

  export let store: {
    id: number;
    name: string;
    imageUrl?: string;
    address: { city: string };
  };

  export let onClick: () => void;
  export let onClickToEdit: () => void;
  export let onClickToProductsListButton: () => void;

  function stopPropagationAndCall(fn: () => void, event: MouseEvent) {
    event.stopPropagation();
    fn();
  }
</script>

<div
  role="button"
  tabindex="0"
  on:keydown={(e) => {
    if (e.key === "Enter" || e.key === " ") onClick();
  }}
  id={"storeElementGallery" + store.id}
  class="h-56 md:w-56 bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-700 relative"
  on:click={onClick}
>
  <EditButton
    id={store.id + ""}
    styleOverride="absolute top-0 right-0"
    functionToDo={onClickToEdit}
  />

  <div id={"imageStoreGallery" + store.id} class="w-28 mt-5 mx-auto h-16">
    {#if store.imageUrl}
      <img
        class="h-16 max-w-full rounded-lg object-cover mx-auto text-center dark:text-white"
        src={store.imageUrl}
        alt={store.name.slice(0,8)}
      />
    {:else}
      <div id={"divNoImageSet" + store.id} class="h-16 max-w-full rounded-lg">
        <ImagePlaceholder />
      </div>
    {/if}
  </div>

  <div
    id={"textStoreGallery" + store.id}
    class="mt-8 max-w-full h-24 mx-1 text-center"
  >
    <p
      id={"1textStoreGallery" + store.id}
      class="h-1/3 w-full text-xl font-bold text-gray-900 dark:text-white truncate leading-7"
    >
      {store.name}
    </p>
    <p
      id={"2textStoreGallery" + store.id}
      class="h-1/3 w-full text-sm text-gray-900 dark:text-white truncate leading-5"
    >
      {store.address.city}
    </p>
    <div class="h-1/3 flex flex-row-reverse items-center overflow-hidden">
      <button
        on:click={(e) => stopPropagationAndCall(onClickToProductsListButton, e)}
        id={"listOfProductsButton" + store.id}
        class="max-h-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      >
        List of Products
      </button>
    </div>
  </div>
</div>
