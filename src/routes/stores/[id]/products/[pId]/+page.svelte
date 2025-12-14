<script lang="ts">
  import { page } from "$app/state";
  import ProductDetail from "../../../../../components/product/ProductDetail.svelte";
  $: id = page.params.id ? +page.params.id : undefined ;
  $: pid = page.params.pId ? +page.params.pId : undefined ;
</script>

<ProductDetail title="Details of the product" storeId={id} productId={pid} />
