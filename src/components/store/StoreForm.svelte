<script lang="ts">
  import Spinner from "../../assets/images/spinner.svelte";
  import type { StoreDTO } from "../../models/Store";
  import {
    DESCRIPTION_RESTRICTION,
    descriptionRestrictionMessage,
    NAME_RESTRICTION,
    nameRestrictionMessage,
    onlyNumbersRestrictionMessage,
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
  import { pathData } from "../../store";

  let props = $props();

  let store = $state<StoreDTO | undefined>({
    id: -1,
    name: "",
    contactPhone: "0",
    imageUrl: "",
    address: {
      state: "",
      streetNumber: "",
      streetName: "",
      city: "",
      zipCode: "",
    },
    location: { latitude: 0, longitude: 0 },
  });
  let latitude = $state<string>("0");
  let longitude = $state<string>("0");
  let isLoading = $state(true);

  onMount(() => {
    if (props.id !== undefined) {
      isLoading = true;
      getStoreById(+props.id)
        .then((r) => {
          store = r;
          latitude = store.location.latitude + "";
          longitude = store.location.longitude + "";
          pathData.set({
            inStores: true,
            inProducts: false,
            storeName: store.name,
            storeId: store.id + "",
            productName: undefined,
            productId: undefined,
          });
        })
        .catch(() => {
          console.error("Error loading store");
          pathData.set({
            inStores: true,
            inProducts: false,
            storeName: undefined,
            storeId: undefined,
            productName: undefined,
            productId: undefined,
          });
          store = undefined;
        })
        .finally(() => {
          isLoading = false;
        });
    } else {
      pathData.set({
        inStores: true,
        inProducts: false,
        storeName: undefined,
        storeId: undefined,
        productName: undefined,
        productId: undefined,
      });
      isLoading = false;
    }
  });

  let onSubmit = (e: SubmitEvent) => {
    e.preventDefault();
    if (store !== undefined) {
      if (
        store.name.length <= NAME_RESTRICTION &&
        store.address.city.length <= NAME_RESTRICTION &&
        store.address.state.length <= NAME_RESTRICTION &&
        store.address.zipCode.length <= NAME_RESTRICTION &&
        store.address.streetNumber.length <= NAME_RESTRICTION &&
        store.address.streetName.length <= DESCRIPTION_RESTRICTION &&
        REGEX.LATITUDE.test(latitude) &&
        REGEX.LONGITUDE.test(longitude)
      ) {
        store.location.longitude = +longitude;
        store.location.latitude = +latitude;
        if (props.id === undefined) {
          createStoreById(store)
            .then(() => {
              goto("/stores");
            })
            .catch(() => alert("error when creating"));
        } else {
          updateStoreById(store.id, store)
            .then(() => {
              goto("/stores");
            })
            .catch(() => alert("error when updating"));
        }
      }
    }
  };

  let deleteButton = () => {
    if (props.id !== undefined) {
      deleteStoreById(+props.id)
        .then(() => {
          goto("/stores");
        })
        .catch(() => alert("error when delete"));
    }
  };
</script>

{#if !isLoading && store}
  <div class="flex items-center flex-col pb-4">
    <div class="mb-6 text-4xl text-center mb-16 dark:text-white">
      {props.title}
    </div>
    <form onsubmit={(e) => onSubmit(e)} class="mx-auto w-3/4">
      <InputOfUrlImagesForm
        title={"URL"}
        errorShouldDisplay={false}
        required={false}
        bind:value={store.imageUrl}
        helpText={descriptionRestrictionMessage}
      />
      <div class="flex gap-4">
        <InputOfStringForm
          numberOfLines={1}
          title={"Name"}
          errorShouldDisplay={store.name.length > NAME_RESTRICTION}
          required={true}
          helpText={nameRestrictionMessage}
          bind:value={store.name}
        />
        <InputOfStringForm
          numberOfLines={1}
          title={"City"}
          errorShouldDisplay={store.address.city.length > NAME_RESTRICTION}
          required={true}
          helpText={nameRestrictionMessage}
          bind:value={store.address.city}
        />
      </div>
      <div class="flex gap-4">
        <InputOfStringForm
          numberOfLines={1}
          title={"State"}
          errorShouldDisplay={store.address.state.length > NAME_RESTRICTION}
          required={true}
          helpText={nameRestrictionMessage}
          bind:value={store.address.state}
        />
      </div>
      <div class="flex gap-4">
        <InputOfStringForm
          numberOfLines={1}
          title={"Zipcode"}
          required={true}
          errorShouldDisplay={store.address.zipCode.length > NAME_RESTRICTION}
          helpText={nameRestrictionMessage}
          bind:value={store.address.zipCode}
        />
        <InputOfStringForm
          numberOfLines={1}
          required={true}
          title={"Street Number"}
          errorShouldDisplay={store.address.streetNumber.length >
            NAME_RESTRICTION}
          helpText={onlyNumbersRestrictionMessage}
          bind:value={store.address.streetNumber}
        />
      </div>
      <InputOfStringForm
        numberOfLines={1}
        title={"Street Name"}
        required={true}
        errorShouldDisplay={store.address.streetName.length >
          DESCRIPTION_RESTRICTION}
        helpText={descriptionRestrictionMessage}
        bind:value={store.address.streetName}
      />
      <div class="flex gap-4">
        <InputOfStringForm
          numberOfLines={1}
          title={"Latitude"}
          required={true}
          errorShouldDisplay={!REGEX.LATITUDE.test(latitude)}
          helpText={undefined}
          bind:value={latitude}
        />
        <InputOfStringForm
          numberOfLines={1}
          title={"Longitude"}
          required={true}
          errorShouldDisplay={!REGEX.LONGITUDE.test(longitude)}
          helpText={undefined}
          bind:value={longitude}
        />
      </div>
      {#if props.id !== undefined}
        <div class=" md:gap-28 w-40 min-h-8 mb-8 md:mb-4">
          <DeleteButton
            functionToDo={() => deleteButton()}
            title={"Delete Store"}
          ></DeleteButton>
        </div>
      {/if}
      <div
        class="grid md:grid-cols-2 md:gap-28 gap-4 mt-4 mx-auto md:w-80 min-h-14"
      >
        <ValidateButton functionToDo={() => {}} title={"Submit"} />
        <CancelButton
          functionToDo={() => {
            goto("/stores/");
          }}
          title={"Cancel"}
        />
      </div>
    </form>
  </div>
{/if}
{#if !isLoading && !store}
  <DisplayNotFound />
{/if}
{#if isLoading}
  <div class="flex justify-center"><Spinner /></div>
{/if}
