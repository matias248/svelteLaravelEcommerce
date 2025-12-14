<script lang="ts">
  import type { CartItemDTO } from "../../models/CartItem";
  import IconImagePlaceholder from "../../assets/images/iconImagePlaceholder.svelte";
  import MinusPlusInput from "./MinusPlusInput.svelte";

  export let cartItem: CartItemDTO;
  export let changeQuantityInCartShop: (
    shopItem: CartItemDTO,
    quantity: number
  ) => void;

  const wrapperchangeQuantityInCartShop = (quantity: number) => {
    changeQuantityInCartShop(cartItem, quantity);
  };
</script>

<div
  id={"ShopCartItem" + cartItem.id}
  class="h-55 w-full md:min-w-56 bg-white rounded-lg shadow-xs dark:bg-gray-800 p-1"
>
  <div id={"ShopCartItemImage" + cartItem.id} class="size-18 mt-2 mx-auto">
    {#if cartItem.imageUrl}
      <img
        class="h-full max-w-full rounded-lg object-cover mx-auto text-center dark:text-white"
        src={cartItem.imageUrl}
        alt="product"
      />
    {:else}
      <div
        id={"divNoImageSet" + cartItem.id}
        class="h-full max-w-full rounded-lg"
      >
        <IconImagePlaceholder />
      </div>
    {/if}
  </div>

  <div
    id={`textShopCart${cartItem.id}`}
    class="mt-2 max-w-full h-14 mx-1 text-center overflow-auto"
  >
    <div id={`1textShopCartItem${cartItem.id}`} class="w-full">
      <div
        class="text-xl font-bold text-gray-900 dark:text-white leading-7 whitespace-nowrap"
      >
        {cartItem.name}
      </div>
    </div>

    <div class="w-full">
      <p
        id={`2textShopCartItem${cartItem.id}`}
        class="text-xl font-bold text-gray-900 dark:text-white whitespace-nowrap leading-7"
      >
        {cartItem.price}€
      </p>
    </div>
  </div>

  <div>
    <div class="h-16 flex justify-center items-center rounded-lg">
      <MinusPlusInput
        modifyValue={wrapperchangeQuantityInCartShop}
        value={cartItem.quantity}
        id={"minusPlusCartItem" + cartItem.id}
      />
    </div>
  </div>
</div>
