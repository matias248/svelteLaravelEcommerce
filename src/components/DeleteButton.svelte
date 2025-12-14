<script lang="ts">
  	let props = $props();
</script>

<button type="button" name="deleteButton" onclick={(e) => { e.preventDefault(); props.functionToDo() }} class={"text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-hidden focus:ring-red-300 font-medium rounded-lg text-xs w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-800 dark:hover:bg-red-900 dark:focus:ring-blue-800 " + (props.styleOverride ?? "")}>{props.title}</button>