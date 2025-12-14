<script lang="ts">
  import { page } from "$app/state";
  import ProductForm from "../../../../../../components/product/ProductForm.svelte";
  $: id = page.params.id;
  $: pid = page.params.pId;
</script>

<ProductForm storeId={id} productId={pid} title="Edit the product"/>