<script lang="ts">
  import { goto } from "$app/navigation";
  import EcIcon from "../assets/images/ecPortofolio.svelte";
  import ShopIcon from "../assets/images/shopIcon.svelte";
  import FormIcon from "../assets/images/formIcon.svelte";
  import { AppNames, type AppNamesType } from "../utils/constants";
  import { getCurrentApp } from "../utils/utilsFunctions";
  import { page } from "$app/state";
  import { derived } from "svelte/store";

 // let currentRoute: AppNamesType | undefined = getCurrentApp(page.url.pathname);

  let currentRoute = $derived(getCurrentApp(page.url.pathname));
</script>

<header class="h-[64px] mb-8">
  <nav class="bg-slate-100 border-gray-200 py-[10px] dark:bg-gray-800 h-full">
    <div
      class="flex flex-wrap justify-between items-center mx-auto max-w-full px-2"
    >
      <div class="flex items-center gap-1">
        <div class="size-12">
          <EcIcon />
        </div>
        <span
          class="self-center text-xl font-semibold whitespace-nowrap dark:text-white hidden sm:inline"
        >
          ECportfolio
        </span>
      </div>

      <div class="flex items-center lg:order-2">
        {#if currentRoute !== AppNames.FORMS}
          <button
            id="NavigationFormsApp"
            class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden flex gap-1"
            onclick={() => {
              goto("/stores");
            }}
          >
            <div class="size-6"><FormIcon /></div>
            <div class="hidden min-[320px]:inline">Forms</div>
          </button>
        {/if}

        {#if currentRoute !== AppNames.SHOP}
          <button
            id="NavigationShopApp"
            class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden flex gap-1"
            onclick={() => goto("/shop")}
          >
            <div class="size-6"><ShopIcon /></div>
            <div class="hidden min-[320px]:inline">Shop</div>
          </button>
        {/if}
      </div>
    </div>
  </nav>
</header>
