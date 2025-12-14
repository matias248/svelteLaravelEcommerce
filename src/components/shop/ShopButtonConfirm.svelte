<script lang="ts">
  export let functionToDo: () => void;
  export let title: string;
  export let styleOverride: string = "";
</script>

<button
  name="confirmDialogShopButton"
  class={"bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-lg w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 dark:text-white " +
    styleOverride}
  on:click|stopPropagation={functionToDo}
>
  {title}
</button>
