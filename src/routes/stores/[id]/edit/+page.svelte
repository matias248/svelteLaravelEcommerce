<script lang="ts">
  import StoreForm from "../../../../components/store/StoreForm.svelte";
  import { page } from "$app/state";

  const id = $derived(() => page.params.id);

</script>

<StoreForm id={id()} title="Edit the store" />
