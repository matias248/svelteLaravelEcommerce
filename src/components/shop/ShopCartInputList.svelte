<script lang="ts">
  import ShopCartInputItem from "./ShopCartInputItem.svelte";

  let props = $props();
</script>

<div class="flex flex-col gap-1 overflow-auto h-full">
  {#if props.cartItems}
    {#each props.cartItems as cartItem (cartItem.id)}
      <ShopCartInputItem
        {cartItem}
        changeQuantityInCartShop={props.changeQuantityInCartShop}
      />
    {/each}
  {/if}
  {#if props.cartItems === undefined || props.cartItems?.length === 0}
    <div id="emptyCartShop" class=" dark:text-white text-center my-auto">
      The cart shop is empty
    </div>
  {/if}
</div>
