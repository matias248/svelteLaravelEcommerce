<script lang="ts">
  import EditIcon from '../../assets/images/editIcon.svelte';

  export let id:string;
  export let styleOverride: string;
  export let functionToDo: () => void;

  function handleClick(event: MouseEvent) {
    event.stopPropagation();
    functionToDo();
  }
</script>

<button
  id={id ? "editButton" + id : "editButton"}
  class={"w-14 bg-gray-600 rounded-lg dark:fill-white " + (styleOverride ?? "")}
  on:click={handleClick}
>
  <EditIcon />
</button>
