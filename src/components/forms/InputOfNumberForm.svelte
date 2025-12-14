<script lang="ts">
  export let title: string;
  export let required: boolean = false;
  export let helpText: string | undefined;
  export let errorShouldDisplay: boolean = false;
  export let styleOverride: string = "";
  export let value: string = "";

  let safeId = "input-" + title.toLowerCase().replace(/[^a-z0-9]+/g, "-");
</script>

<div class="mb-5 w-full min-w-[100px]">
  <label
    for={safeId}
    class="block mb-2 text-base sm:text-lg font-medium dark:text-white flex items-center"
  >
    {title}{required ? "*" : ""}
  </label>

  <input
    type="text"
    id={safeId}
    bind:value
    class={
      "bg-gray-50 border border-slate-400 text-gray-900 text-base rounded-lg block w-full p-2.5 " +
      "dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white " +
      (errorShouldDisplay ? "bg-red-200 dark:bg-red-800" : "") +
      " " +
      styleOverride
    }
    required={required}
  />

  {#if helpText && errorShouldDisplay}
    <div class="text-xs dark:text-white italic overflow-hidden">
      {helpText}
    </div>
  {/if}
</div>
