<script lang="ts">
  import CrossIcon from "../../../assets/images/crossIcon.svelte";
  let { cartItem, changeQuantityInCartShop } = $props();
  import ImagePlaceholder from "../../../assets/images/iconImagePlaceholder.svelte";
  import MinusPlusInput from "../MinusPlusInput.svelte";

  let showDescription = $state(false);

  function wrapperChangeQuantity(quantity: number) {
    changeQuantityInCartShop(cartItem, quantity);
  }
</script>

<div
  id={"ShopProductElementGallery" + cartItem.id}
  class="h-75 min-w-64 bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-700"
>
  {#if !showDescription}
    <div
      id={"ShopImageProductGallery" + cartItem.id}
      class="w-56 mt-2 mx-auto h-28"
    >
      {#if cartItem.imageUrl}
        <img
          class="h-28 max-w-full rounded-lg object-cover mx-auto text-center dark:text-white"
          src={cartItem.imageUrl}
          alt="error loading "
        />
      {:else}
        <div
          id={"divNoImageSet" + cartItem.id}
          class="h-28 max-w-full rounded-lg"
        >
          <ImagePlaceholder />
        </div>
      {/if}
    </div>

    <div
      id={"textShopProductGallery" + cartItem.id}
      class="mt-2 max-w-full h-24 mx-1 text-center overflow-auto"
    >
      <div class="w-full">
        <div
          class="text-2xl font-bold text-gray-900 dark:text-white leading-8 whitespace-nowrap"
        >
          {cartItem.name}
        </div>
      </div>

      <div class="w-full">
        <p
          class="text-2xl font-bold text-gray-900 dark:text-white whitespace-nowrap leading-8"
        >
          {cartItem.price}{cartItem.currency}
        </p>
      </div>

      <div
        class="flex flex-row-reverse items-center max-[1040px]:justify-center"
      >
        <button
          id={"learnMore" + cartItem.id}
          onclick={() => (showDescription = true)}
          class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-hidden
          focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-2 py-1 text-center
          dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Learn more
        </button>
      </div>
    </div>

    <div>
      <div class="h-16 flex justify-center items-center rounded-lg">
        <MinusPlusInput
          modifyValue={wrapperChangeQuantity}
          value={cartItem.quantity}
          id={"minusPlusProductItem" + cartItem.id}
        />
      </div>
    </div>
  {:else}
    <div
      id={"descriptionProductCrossIcon" + cartItem.id}
      class="size-12 cursor-pointer"
      role="button"
      tabindex="0"
      aria-label="Close description"
      onclick={() => (showDescription = false)}
      onkeydown={(e) => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          showDescription = false;
        }
      }}
    >
      <CrossIcon  />
    </div>

    <div
      id={"descriptionProductText" + cartItem.id}
      class="dark:text-white overflow-y-auto h-61 mx-1"
    >
      {cartItem.description}
    </div>
  {/if}
</div>
