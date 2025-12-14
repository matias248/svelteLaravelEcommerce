<script lang="ts">
  export let functionToDo: () => void;
  export let styleOverride: string = "";
  export let title: string;
</script>

<button
  id="fixedButton"
  on:click={functionToDo}
  class={"fixed bottom-4 right-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-lg px-2.5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 " +
    (styleOverride ?? "")}
>
  <svg
    class=" h-[20px] me-2"
    viewBox="0 0 24 24"
    fill="white"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
  >
    <line x1="12" y1="5" x2="12" y2="19"></line>
    <line x1="5" y1="12" x2="19" y2="12"></line>
  </svg>
  <span> {title}</span></button
>
