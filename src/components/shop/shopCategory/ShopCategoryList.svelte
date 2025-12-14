<script lang="ts">
  import ShopCategoryItem from "./ShopCategoryItem.svelte";



  export let updateFilterCategoryMap: (key: string, value: boolean) => void;
  export let filterCategoryMap: Map<string, boolean>;

  const title = "Our Categories";
</script>

<div
  id="categoryListContainer"
  class="max-w-[1200px] mx-auto w-[90%] rounded-lg"
>
  <div id="categoryListTitle" class="dark:text-white text-lg">
    {title}
  </div>

  <div id="categoryList" class="flex gap-1 flex-wrap">
    {#each [...filterCategoryMap.entries()] as [key, value], index}
      <ShopCategoryItem
        id={index}
        category={key}
        filterOn={value}
        onChange={() => updateFilterCategoryMap(key, !value)}
      />
    {/each}
  </div>
</div>
