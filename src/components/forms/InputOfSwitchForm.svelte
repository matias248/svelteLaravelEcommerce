<script lang="ts">
    export let title: string;
    export let optionSelected: string = "";
    export let options: string[] = [];
    export let errorShouldDisplay: boolean = false;
    export let styleOverride: string = "";
</script>

<div class="mb-5">
    <label for={`switch-${title}`} class="block mb-2 text-base sm:text-lg font-medium dark:text-white">
        {title}
    </label>

    <select
        name={`${title}selectedOption`}
        id={`switch-${title}`}
        class={`block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border 
            border-slate-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white ${errorShouldDisplay ? "bg-red-200 dark:bg-red-800" : ""}  
            ${styleOverride}`}
        aria-invalid={errorShouldDisplay}
        bind:value={optionSelected}
    >
        {#each options as option, index}
            <option 
                id={index+""} 
                value={option}
            >
                {option}
            </option>
        {/each}
    </select>
</div>
