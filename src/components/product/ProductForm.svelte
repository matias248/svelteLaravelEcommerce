<script lang="ts">
  import Spinner from "../../assets/images/spinner.svelte";
  import type { StoreDTO } from "../../models/Store";
  import {
    DESCRIPTION_RESTRICTION,
    descriptionRestrictionMessage,
    NAME_RESTRICTION,
    nameRestrictionMessage,
    onlyNumbersRestrictionMessage,
    onlyNumbersRestrictionMessageAndPointOrComa,
    REGEX,
  } from "../../utils/constants";
  import DeleteButton from "../DeleteButton.svelte";
  import DisplayNotFound from "../DisplayNotFound.svelte";
  import CancelButton from "../forms/CancelButton.svelte";
  import InputOfStringForm from "../forms/InputOfStringForm.svelte";
  import InputOfUrlImagesForm from "../forms/InputofUrlImagesForm.svelte";
  import { goto } from "$app/navigation";

  import ValidateButton from "../ValidateButton.svelte";
  import {
    createStoreById,
    deleteStoreById,
    getStoreById,
    updateStoreById,
  } from "../../services/storeService";
  import { onMount } from "svelte";
  import {
    arrayCategoryType,
    arrayCurrencyType,
    arrayInventoryStatusType,
    type ProductDTO,
  } from "../../models/Product";
  import {
    createProductById,
    deleteProductById,
    getProductByIdWithstore,
    updateProductById,
  } from "../../services/productService";
  import InputOfSwitchForm from "../forms/InputOfSwitchForm.svelte";
  import { replaceTextNumberPerNumber } from "../../utils/utilsFunctions";
  import { pathData } from "../../store";

  const props = $props<{
    title: string;
    productId?: number | string;
    storeId?: number | string;
  }>();

  let product = $state<ProductDTO | undefined>({
    name: "",
    description: "",
    price: 0,
    currency: arrayCurrencyType[0],
    imageUrl: "",
    category: arrayCategoryType[0],
    inventoryStatus: arrayInventoryStatusType[0],
    id: -1,
    storeId: -1,
  });
  let price = $state<string>("0");
  let isLoading = $state(true);
  let store = $state<StoreDTO>();

  onMount(() => {
    if (props.productId !== undefined && props.storeId !== undefined) {
      isLoading = true;
      getProductByIdWithstore(+props.storeId, +props.productId)
        .then((r) => {
          product = r.product;
          price = product.price + "";
          store = r.store;
          pathData.set({
            inStores: true,
            inProducts: true,
            storeName: r.store.name,
            storeId: r.store.id + "",
            productName: product.name,
            productId: product.id + "",
          });
        })
        .catch(() => {
          console.error("Error loading something");
        })
        .finally(() => {
          isLoading = false;
        });
    } else {
      getStoreById(+props.storeId)
        .then((r) => {
          store = r;
          pathData.set({
            inStores: true,
            inProducts: true,
            storeName: store.name,
            storeId: store.id + "",
            productName: undefined,
            productId: undefined,
          });
        })
        .catch(() => {
          console.error("Error loading store");
          product = undefined;
        })
        .finally(() => {
          isLoading = false;
        });
    }
    isLoading = false;
  });

  let onSubmit = (e: SubmitEvent) => {
    e.preventDefault();
    if (product !== undefined) {
      if (
        product.name.length <= NAME_RESTRICTION &&
        product.description.length <= DESCRIPTION_RESTRICTION &&
        REGEX.NUMBERS_DOTS_COMMAS.test(price)
      ) {
        product.price = +replaceTextNumberPerNumber(price);
        if (props.productId === undefined && props.storeId !== undefined) {
          createProductById(+props.storeId, product)
            .then(() => {
              goto(`/stores/${props.storeId}/products/`);
            })
            .catch(() => alert("error when creating"));
        }
        if (props.productId !== undefined && props.storeId !== undefined) {
          updateProductById(+props.storeId, +props.productId, product)
            .then(() => {
              goto(`/stores/${props.storeId}/products/`);
            })
            .catch(() => alert("error when updating"));
        }
      }
    }
  };

  let deleteButton = () => {
    if (props.productId !== undefined && props.storeId) {
      deleteProductById(+props.storeId, +props.productId)
        .then(() => {
          goto(`/stores/${+props.storeId}/products/`);
        })
        .catch(() => alert("error when delete"));
    }
  };
</script>

{#if !isLoading && product}
  <div class="flex items-center flex-col pb-4">
    <div class="mb-6 text-4xl text-center mb-16 dark:text-white">
      {props.title}
    </div>
    <form onsubmit={(e) => onSubmit(e)} class="mx-auto w-3/4">
      <InputOfUrlImagesForm
        title={"URL"}
        errorShouldDisplay={false}
        required={false}
        bind:value={product.imageUrl}
        helpText={descriptionRestrictionMessage}
      />
      <InputOfStringForm
        numberOfLines={1}
        title={"Name"}
        errorShouldDisplay={product.name.length > NAME_RESTRICTION}
        required={true}
        helpText={nameRestrictionMessage}
        bind:value={product.name}
      />
      <InputOfStringForm
        numberOfLines={4}
        title={"Description"}
        errorShouldDisplay={product.description.length >
          DESCRIPTION_RESTRICTION}
        required={true}
        helpText={descriptionRestrictionMessage}
        bind:value={product.description}
      />

      <div class="flex gap-4">
        <InputOfStringForm
          numberOfLines={1}
          title={"Price"}
          errorShouldDisplay={!REGEX.NUMBERS_DOTS_COMMAS.test(price)}
          required={true}
          helpText={onlyNumbersRestrictionMessageAndPointOrComa}
          bind:value={price}
        />
        <InputOfSwitchForm
          title={"Currency"}
          bind:optionSelected={product.currency}
          options={arrayCurrencyType}
        />
      </div>
      <InputOfSwitchForm
        title={"Category"}
        bind:optionSelected={product.category}
        options={arrayCategoryType}
      />
      <InputOfSwitchForm
        title={"Inventory status"}
        bind:optionSelected={product.inventoryStatus}
        options={arrayInventoryStatusType}
      />

      {#if props.productId !== undefined}
        <div class=" md:gap-28 w-40 min-h-8 mb-8 md:mb-4">
          <DeleteButton
            functionToDo={() => deleteButton()}
            title={"Delete Product"}
          ></DeleteButton>
        </div>
      {/if}
      <div
        class="grid md:grid-cols-2 md:gap-28 gap-4 mt-4 mx-auto md:w-80 min-h-14"
      >
        <ValidateButton functionToDo={() => {}} title={"Submit"} />
        <CancelButton
          functionToDo={() => {
            goto(`/stores/${props.storeId}/products/`);
          }}
          title={"Cancel"}
        />
      </div>
    </form>
  </div>
{/if}
{#if !isLoading && !product}
  <DisplayNotFound />
{/if}
{#if isLoading}
  <div class="flex justify-center"><Spinner /></div>
{/if}
