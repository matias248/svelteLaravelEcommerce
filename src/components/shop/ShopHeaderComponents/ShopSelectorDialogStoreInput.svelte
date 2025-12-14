<script lang="ts">
  import LocationIcon from "../../../assets/images/locationIcon.svelte";
  import type { StoreDTO } from "../../../models/Store";
  export let store: StoreDTO;
  export let idStoreSelected: number | undefined;
  export let onClick: (id: number) => void;

  const handleClick = () => {
    onClick(store.id);
  };
</script>

<div
  id={"storeElementDialog" + store.id}
  class={
    "h-36 w-full md:min-w-56 bg-white border-2 rounded-lg shadow-xs dark:bg-gray-800 p-1 " +
    (idStoreSelected === store.id
      ? "border-red-200 dark:border-gray-200"
      : "border-gray-200 dark:border-gray-700")
  }
  role="button"
  tabindex="0"
  aria-pressed={idStoreSelected === store.id}
  on:click={handleClick}
  on:keydown={(e) => e.key === "Enter" && handleClick()}
>
  <div
    id={"textStoreElementDialog" + store.id}
    class="max-w-full mx-1 text-center"
  >
    <p
      id={"1textStoreElementDialog" + store.id}
      class="mb-2 h-7 w-full text-xl font-bold text-gray-900 dark:text-white truncate leading-7"
    >
      {store.name}
    </p>

    <div class="flex justify-center">
      <div class="size-7 dark:fill-slate-300">
        <LocationIcon />
      </div>
    </div>

    <p
      id={"2textStoreElementDialog" + store.id}
      class="h-5 w-full text-sm text-gray-900 dark:text-white truncate leading-5"
    >
      {store.address.state}
    </p>

    <p
      id={"3textStoreElementDialog" + store.id}
      class="h-5 w-full text-sm text-gray-900 dark:text-white truncate leading-5"
    >
      {store.address.zipCode + " " + store.address.city}
    </p>

    <p
      id={"4textStoreElementDialog" + store.id}
      class="h-5 w-full text-sm text-gray-900 dark:text-white truncate leading-5"
    >
      {store.address.streetNumber + " " + store.address.streetName}
    </p>
  </div>
</div>
