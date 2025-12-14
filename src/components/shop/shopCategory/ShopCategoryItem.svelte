<script lang="ts">
  import CrossIcon from "../../../assets/images/crossIcon.svelte";
  import VerifyIcon from "../../../assets/images/verifyIcon.svelte";



  export let category: string;
  export let filterOn: boolean;
  export let onChange: () => void;
  export let id: number;
</script>

<div
  id={"ShopCategoryItem" + id}
  class={"dark:text-white rounded-lg px-2 flex items-center gap-1 cursor-pointer " +
    (filterOn ? "bg-blue-500" : "bg-gray-500")}
  role="button"
  tabindex="0"
  aria-pressed={filterOn}
  aria-label={`Toggle filter for ${category}`}
  on:click={onChange}
  on:keydown={(e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      onChange();
    }
  }}
>
  {#if !filterOn}
    <div class="dark:fill-white size-[20px]">
      <CrossIcon />
    </div>
  {:else}
    <div class="dark:fill-white size-[20px]">
      <VerifyIcon />
    </div>
  {/if}

  <div>{category}</div>
</div>
