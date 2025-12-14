<script lang="ts">
  import { page } from "$app/state";
  import ProductList from "../../../../components/product/ProductList.svelte";

  const id = $derived(() => (page.params.id ? +page.params.id : undefined));
</script>

<ProductList storeId={id()} />
