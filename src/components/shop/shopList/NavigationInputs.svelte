<script lang="ts">
  export let currentPage: number;
  export let totalPages: number;
  export let handlerCurrentPage: (page: number) => void;
  export let styleOverride: string = "";

  const leftArrowFunction = () => {
    handlerCurrentPage(currentPage - 1);
  };

  const rightArrowFunction = () => {
    handlerCurrentPage(currentPage + 1);
  };

  const handleInputChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const value = target.value;

    const isPositiveInteger = /^[1-9]\d*$/.test(value);

    if (isPositiveInteger || value === "") {
      handlerCurrentPage(value === "" ? 0 : +value);
    }
  };
</script>

<div class={"flex gap-[6px] " + styleOverride}>
  <button
    type="button"
    disabled={currentPage <= 1}
    class="w-[20px] bg-gray-600 rounded-md dark:text-white p-[4px]"
    on:click={(e) => { e.stopPropagation(); leftArrowFunction(); }}
  >
    &lt;
  </button>

  <div class="flex gap-[2px] max-w-[200px] h-[35px] overflow-auto items-center px-[2px]">
    <input
      class="max-w-[50px] bg-white rounded-md text-center dark:text-white dark:bg-gray-400 h-[25px]"
      value={currentPage !== 0 ? currentPage : ""}
      on:input={handleInputChange}
    />

    <div class="rounded-md dark:text-white h-[25px] whitespace-nowrap">
      of {totalPages === 0 ? 1 : totalPages}
    </div>
  </div>

  <button
    type="button"
    disabled={currentPage >= totalPages}
    class="w-[20px] bg-gray-600 rounded-md dark:text-white p-[4px]"
    on:click={(e) => { e.stopPropagation(); rightArrowFunction(); }}
  >
    &gt;
  </button>
</div>
