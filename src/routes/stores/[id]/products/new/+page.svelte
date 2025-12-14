<script>
  import { page } from "$app/state";
  import ProductForm from "../../../../../components/product/ProductForm.svelte";
  $: id = page.params.id;
</script>

<ProductForm
  storeId={id ? +id : id}
  productId={undefined}
  title="Create a new product"
/>
