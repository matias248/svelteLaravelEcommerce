<script lang="ts">
  export let title: string;
  export let required: boolean = false;
  export let numberOfLines: number = 3;
  export let helpText: string | undefined;
  export let errorShouldDisplay: boolean = false;
  export let styleOverride: string = "";
  export let value: string;
  let safeId = "inputString-" + title;


</script>

<div class="mb-5 w-full min-w-[100px]">
  <label
    for={safeId}
    class="block mb-2 text-base sm:text-lg dark:text-white flex items-center font-medium"
  >
    {title}{required ? "*" : ""}
  </label>

  <textarea
    id={safeId}
    rows={numberOfLines}
    class={`block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-slate-400 
            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
            ${errorShouldDisplay ? "bg-red-200 dark:bg-red-800" : ""}
            ${numberOfLines === 1 ? "h-11.5" : ""}
            ${styleOverride}
        `}
    aria-invalid={errorShouldDisplay}
    aria-describedby={errorShouldDisplay ? `${safeId}-error` : undefined}
    {required}
    bind:value
  ></textarea>

  {#if helpText && errorShouldDisplay}
    <div
      id={`${safeId}-error`}
      class="text-xs dark:text-white italic overflow-hidden"
    >
      {helpText}
    </div>
  {/if}
</div>
