<script lang="ts">
  import { page } from "$app/state";
  import StoreDetail from "../../../components/store/StoreDetail.svelte";
  $: id = page.params.id;
</script>

<StoreDetail id={id}/>