<script lang="ts">
  let { value = $bindable(), ...props } = $props();
  import ImagePlaceholder from "../../assets/images/iconImagePlaceholder.svelte";
</script>

<div class="mb-5">
  <div
    class="w-24 h-24 mb-2 bg-white border border-slate-400 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-700 mx-auto sm:mx-0"
  >
    {#if value}
      <img
        class="mt-5 h-16 max-w-full rounded-lg object-cover mx-auto text-center dark:text-white"
        src={value}
        alt={(typeof value === "string" && value.length > 5) ? value.slice(0,5) : value}
      />
    {/if}
    {#if !value}
      <ImagePlaceholder />
    {/if}
  </div>

  <label
    for={"inputString-" + props.title}
    class="block mb-2 text-lg font-medium dark:text-white flex items-center"
  >
    {props.title + (props.required ? "*" : "")}
  </label>
  <textarea
    id={"inputImageUrl-" + props.title}
    rows={1}
    class={"bg-gray-50 border border-slate-400 text-gray-900 text-base rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white " +
      (props.errorShouldDisplay ? "bg-red-200" : "") +
      " " +
      (props.styleOverride ?? "")}
    required={props.required}
    bind:value
  >
  </textarea>
  {#if props.helpText && props.errorShouldDisplay}
    <div class="text-xs dark:text-white italic overflow-hidden">
      {props.helpText}
    </div>
  {/if}
</div>
