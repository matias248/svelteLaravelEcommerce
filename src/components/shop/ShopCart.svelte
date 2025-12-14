<script lang="ts">
  import { fly } from "svelte/transition";
  import CrossIcon from "../../assets/images/crossIcon.svelte";
  import { getTotalPriceCart } from "../../utils/utilsFunctions";
  import ShopButtonConfirm from "./ShopButtonConfirm.svelte";
  import ShopCartInputList from "./ShopCartInputList.svelte";
  let props = $props();
  let totalPriceCart = $derived(getTotalPriceCart(props.cart ?? []));
</script>

<div
  transition:fly={{ x: 300, duration: 500, opacity: 0 }}
  class="fixed h-dvh bg-gray-300 dark:bg-gray-500 top-0 right-0 max-[460px]:w-[60%] w-[40%] md:w-[30%] z-10 rounded-l-lg flex flex-col gap-1 px-2"
>
  <div
    role="button"
    tabindex="0"
    id="crossShopCart"
    class="size-10 relative -left-1"
    onkeydown={(e) => {
      if (e.key === "Enter" || e.key === " ")
        props.handlerCartListVisble(false);
    }}
    onclick={() => {
      props.handlerCartListVisble(false);
    }}
  >
    <CrossIcon />
  </div>
  <div class="dark:text-white font-bold self-center text-xl">Cart shop</div>
  <div class="flex-1 overflow-auto mb-2">
    <ShopCartInputList
      cartItems={props.cart}
      changeQuantityInCartShop={props.changeQuantityInCartShop}
    />
  </div>
  <div class="mb-2">
    <div class="dark:text-white text-xl overflow-x-auto whitespace-nowrap">
      Total: {totalPriceCart} €
    </div>
  </div>
  <div class="mb-2">
    <ShopButtonConfirm
      styleOverride=""
      functionToDo={() => {
        if (props.cart && props.cart.length > 0) {
          props.handlerOrderConfirmModal();
        }
      }}
      title={"Submit Order"}
    />
  </div>
</div>
