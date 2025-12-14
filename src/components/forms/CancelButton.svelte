<script lang="ts">
  export let title: string;
  export let functionToDo: () => void;
  export let styleOverride: string = "";
</script>

<button
  type="button"
  name="cancelButton"
  on:click={(e) => {
    e.preventDefault();
    functionToDo();
  }}
  class={`text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-hidden 
        focus:ring-red-300 font-medium rounded-lg text-lg w-full sm:w-auto px-5 py-2.5 
        text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 
        ${styleOverride}`}
>
  {title}
</button>
