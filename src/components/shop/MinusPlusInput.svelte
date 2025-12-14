<script lang="ts">
  import { keepOnlyNumbers } from "../../utils/utilsFunctions";

  export let modifyValue: (value: number) => void;
  export let value: number;
  export let id: string;

  // Svelte equivalent de useState
  let emptyValue = false;

  // funciones + y -
  const minusFunction = () => {
    modifyValue(value - 1);
  };

  const plusFunction = () => {
    modifyValue(value + 1);
  };

  // handle input
  const handleInputChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    let inputValue = target.value;

    const isPositiveInteger = /^[0-9]\d*$/.test(inputValue);
    if (isPositiveInteger) {
      if (+inputValue <= 99) {
        modifyValue(+inputValue);
      }
      else{
        target.value = value+"";
      }
    }
    else{
      target.value = keepOnlyNumbers(inputValue);
    }

    if (inputValue === "") {
      emptyValue = true;
    } else if (+inputValue === value) {
      emptyValue = false;
    }
  };

  $: if (emptyValue) emptyValue = false;
</script>

<button
  id={id + "-"}
  disabled={value <= 0}
  class="bg-red-500 text-white px-4 py-2 rounded-l hover:bg-red-600"
  on:click={minusFunction}
>
  -
</button>

<input
  id={id + "input"}
  class="mx-2 border border-gray-200 text-center w-16 h-10 dark:bg-white"
  value={emptyValue ? "" : value}
  on:input={handleInputChange}
/>

<button
  id={id + "+"}
  disabled={value >= 99}
  class="bg-green-500 text-white px-4 py-2 rounded-r hover:bg-green-600"
  on:click={(event) => {
    plusFunction();
  }}
>
  +
</button>
