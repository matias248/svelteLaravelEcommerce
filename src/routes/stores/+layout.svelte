<script lang="ts">
  import favicon from "$lib/assets/favicon.svg";
  import Header from "../../components/Header.svelte";
  import PathList from "../../components/PathList.svelte";

  let { children } = $props();
</script>

<svelte:head>
  <link rel="icon" href={favicon} />
</svelte:head>

<div class="bg-slate-200 dark:bg-gray-900 min-h-screen">
  <PathList/>
  {@render children()}
</div>
