<script lang="ts">
  import type { ProductDTO } from "../../models/Product";
  import EditButton from "../forms/EditButton.svelte";
  import ImagePlaceholder from "../../assets/images/iconImagePlaceholder.svelte";

  export let product: ProductDTO;
  export let onClick: (id: number | string) => void;
  export let onClickToEdit: (id: number | string) => void;
</script>

<div
  id={"productElementGallery" + product.id}
  class="h-56 md:w-56 bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-700 relative"
  on:click={() => onClick(product.id)}
  role="button"
  tabindex="0"
  on:keydown={(e) => {
    if (e.key === "Enter" || e.key === " ") onClick(product.id);
  }}
>
  <EditButton
    id={product.id + ""}
    styleOverride="absolute top-0 right-0"
    functionToDo={() => onClickToEdit(product.id)}
  />

  <div id={"imageProductGallery" + product.id} class="w-28 mt-5 mx-auto h-16">
    {#if product.imageUrl}
      <img
        class="h-16 max-w-full rounded-lg object-cover mx-auto text-center dark:text-white"
        src={product.imageUrl}
        alt={product.name.slice(0,8)}
      />
    {:else}
      <div id={"divNoImageSet" + product.id} class="h-16 max-w-full rounded-lg">
        <ImagePlaceholder />
      </div>
    {/if}
  </div>

  <div
    id={"textProductGallery" + product.id}
    class="mt-8 max-w-full h-24 mx-1 text-center"
  >
    <p
      id={"1textProductGallery" + product.id}
      class="h-1/2 w-full text-xl font-bold text-gray-900 dark:text-white overflow-hidden text-ellipsis leading-6"
    >
      {product.name}
    </p>
    <p
      id={"2textProductGallery" + product.id}
      class="w-full text-sm text-gray-700 dark:text-gray-400 leading-6 line-clamp-2"
    >
      {product.description}
    </p>
  </div>
</div>
